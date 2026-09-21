<?php

namespace App\Http\Middleware;

use App\Support\WebPermissions;
use Closure;
use DOMDocument;
use DOMElement;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class FilterUnauthorizedWebActions
{
    public function __construct(private readonly Router $router) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $user = $request->user('web');
        $type = (string) $response->headers->get('Content-Type');

        if (! $user || ! str_contains($type, 'text/html') || ! class_exists(DOMDocument::class)) return $response;

        $html = $response->getContent();
        if (! is_string($html) || $html === '') return $response;

        $dom = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $removedIds = [];
        foreach (iterator_to_array($dom->getElementsByTagName('form')) as $form) {
            if (! $form instanceof DOMElement) continue;
            $method = strtoupper($form->getAttribute('method') ?: 'GET');
            foreach ($form->getElementsByTagName('input') as $input) {
                if ($input->getAttribute('name') === '_method') $method = strtoupper($input->getAttribute('value'));
            }
            if (! $this->allowed($user, $form->getAttribute('action') ?: $request->fullUrl(), $method)) {
                if ($form->parentNode instanceof DOMElement && $form->parentNode->tagName === 'dialog') {
                    $removedIds[] = $form->parentNode->getAttribute('id');
                    $form->parentNode->remove();
                } else $form->remove();
            }
        }

        foreach (iterator_to_array($dom->getElementsByTagName('a')) as $link) {
            if ($link instanceof DOMElement && ! $this->allowed($user, $link->getAttribute('href'), 'GET')) $link->remove();
        }
        foreach (iterator_to_array($dom->getElementsByTagName('button')) as $button) {
            if (! $button instanceof DOMElement) continue;
            foreach ($removedIds as $id) {
                if ($id !== '' && str_contains($button->getAttribute('onclick'), $id)) $button->remove();
            }
        }

        // Remove sidebar headings whose following menu has no remaining links.
        foreach (iterator_to_array($dom->getElementsByTagName('div')) as $div) {
            if (! $div instanceof DOMElement || ! $div->hasAttribute('data-sidebar-group-menu')) continue;
            if ($div->getElementsByTagName('a')->length === 0) {
                $id = $div->getAttribute('id');
                foreach (iterator_to_array($dom->getElementsByTagName('button')) as $button) {
                    if ($button instanceof DOMElement && $button->getAttribute('aria-controls') === $id) $button->remove();
                }
                $div->remove();
            }
        }

        $output = $dom->saveHTML();
        $response->setContent(preg_replace('/^<\?xml encoding="UTF-8"\?>/', '', $output) ?? $output);
        return $response;
    }

    private function allowed($user, string $url, string $method): bool
    {
        if ($url === '' || str_starts_with($url, '#') || str_starts_with($url, 'javascript:')) return true;
        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path)) return true;
        try {
            $route = $this->router->getRoutes()->match(Request::create($path, $method));
        } catch (NotFoundHttpException|MethodNotAllowedHttpException) {
            return true;
        }
        $permission = WebPermissions::forRoute((string) $route->getName(), $method);
        return ! $permission || $user->can($permission);
    }
}
