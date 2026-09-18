<?php

namespace Tests\Feature;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Tests\TestCase;

class WebSystemStructureAuditTest extends TestCase
{
    public function test_every_literal_blade_form_has_a_route_with_the_matching_method_and_csrf(): void
    {
        $routes = [];
        foreach (app('router')->getRoutes()->getRoutes() as $route) {
            if ($route->getName()) $routes[$route->getName()] = $route->methods();
        }

        $issues = [];
        $forms = 0;
        $references = 0;
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(resource_path('views')));
        foreach ($files as $file) {
            if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) continue;
            $text = file_get_contents($file->getPathname());
            preg_match_all('/route\(\s*[\'\"]([^\'\"]+)/', $text, $routeReferences);
            foreach ($routeReferences[1] as $name) {
                $references++;
                if (! isset($routes[$name]) && ! str_contains($name, '$')) $issues[] = "Missing route {$name} in {$file->getPathname()}";
            }

            preg_match_all('/<form\b([^>]*)>(.*?)<\/form>/is', $text, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
            foreach ($matches as $match) {
                $forms++;
                $attributes = $match[1][0];
                $body = $match[2][0];
                $line = substr_count(substr($text, 0, $match[0][1]), "\n") + 1;
                $location = "{$file->getPathname()}:{$line}";
                if (preg_match('/<form\b/i', $body)) $issues[] = "Nested form at {$location}";
                $htmlMethod = preg_match('/method\s*=\s*[\'\"]([^\'\"]+)/i', $attributes, $methodMatch)
                    ? strtoupper($methodMatch[1]) : 'GET';
                $method = preg_match('/@method\(\s*[\'\"]([^\'\"]+)/i', $body, $overrideMatch)
                    ? strtoupper($overrideMatch[1]) : $htmlMethod;
                if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true) && ! str_contains($body, '@csrf')) {
                    $issues[] = "Missing CSRF for {$method} form at {$location}";
                }
                if (preg_match('/action\s*=\s*[\'\"]\{\{\s*route\(\s*[\'\"]([^\'\"]+)/i', $attributes, $actionMatch)) {
                    $name = $actionMatch[1];
                    if (isset($routes[$name]) && ! in_array($method, $routes[$name], true)) {
                        $issues[] = "{$method} form targets ".implode('|', $routes[$name])." route {$name} at {$location}";
                    }
                }
            }
        }

        $this->assertSame(170, $references, 'Update the audited route-reference count when intentionally changing the UI.');
        $this->assertSame(110, $forms, 'Update the audited form count when intentionally changing the UI.');
        $this->assertSame([], $issues, implode("\n", $issues));
    }

    public function test_read_only_legacy_teacher_redirect_rejects_state_changing_methods(): void
    {
        $route = app('router')->getRoutes()->getByName('teacher.classes.legacy');
        $this->assertSame(['GET', 'HEAD'], $route->methods());
    }
}
