<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FrontendAssetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_public_and_authenticated_layouts_use_reachable_built_assets(): void
    {
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true, flags: JSON_THROW_ON_ERROR);
        $css = '/build/'.$manifest['resources/css/app.css']['file'];
        $js = '/build/'.$manifest['resources/js/app.js']['file'];

        $landing = $this->get(route('signin'));
        $landing->assertOk()->assertSee($css, false)->assertSee($js, false)->assertDontSee('0.0.0.0:5173', false);

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin = User::factory()->create(['status' => 'ACTIVE']);
        $admin->assignRole($role);

        $this->actingAs($admin)->get(route('dashboard'))
            ->assertOk()
            ->assertSee($css, false)
            ->assertSee($js, false)
            ->assertDontSee('0.0.0.0:5173', false);
    }

    public function test_shared_layout_always_uses_vite_instead_of_a_stale_inline_fallback(): void
    {
        $layout = file_get_contents(resource_path('views/layouts/clean.blade.php'));

        $this->assertSame(1, substr_count($layout, '@vite('));
        $this->assertStringContainsString('resources/css/app.css', $layout);
        $this->assertStringContainsString('resources/js/app.js', $layout);
        $this->assertStringNotContainsString("file_exists(public_path('build/manifest.json'))", $layout);
        $this->assertStringNotContainsString('tailwindcss v4.0.7', $layout);
    }

    public function test_every_full_page_blade_view_inherits_the_shared_vite_layout(): void
    {
        $viewRoot = resource_path('views');
        $layoutParents = [
            'layouts.app' => 'layouts.clean',
            'portal.layout' => 'layouts.clean',
        ];
        $fragmentViews = [
            'grading/dashboard-schedule.blade.php',
            'grading/schedule-preview.blade.php',
            'grading/teacher-workflow.blade.php',
            'report/grades/table.blade.php',
        ];
        $issues = [];

        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($viewRoot)) as $file) {
            if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($viewRoot) + 1));
            if (str_starts_with($relative, 'layouts/') || str_starts_with($relative, 'portal/partials/') || in_array($relative, $fragmentViews, true)) {
                continue;
            }

            $contents = file_get_contents($file->getPathname());
            if (preg_match("/@extends\\(['\"]([^'\"]+)/", $contents, $match)) {
                $layout = $match[1];
                $root = $layoutParents[$layout] ?? $layout;
                if ($root !== 'layouts.clean') {
                    $issues[] = "{$relative} extends {$layout}, which does not inherit layouts.clean";
                }
            } elseif (! str_contains($contents, "@include('signin'")) {
                $issues[] = "{$relative} does not inherit a full-page layout";
            }
        }

        $this->assertSame([], $issues, implode("\n", $issues));
    }
}
