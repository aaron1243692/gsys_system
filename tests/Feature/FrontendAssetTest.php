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
}
