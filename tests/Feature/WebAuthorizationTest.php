<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WebAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $group = Permission::query()->firstOrCreate([
            'codename' => 'group.authorization_test',
        ], [
            'name' => 'Authorization Test', 'codename' => 'group.authorization_test',
            'parent_id' => null, 'guard_name' => 'web',
        ]);
        foreach (['dashboard.view', 'roles.view', 'roles.create', 'permissions.assign'] as $codename) {
            Permission::query()->firstOrCreate(['codename' => $codename], [
                'name' => str($codename)->afterLast('.')->headline(), 'codename' => $codename,
                'parent_id' => $group->id, 'guard_name' => 'web',
            ]);
        }
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_staff_needs_view_permission_for_direct_page_access(): void
    {
        $staff = $this->staff();

        $this->actingAs($staff)->get('/dashboard')->assertForbidden();

        $staff->roles->first()->givePermissionTo(Permission::findByName('dashboard.view'));

        $this->actingAs($staff)->get('/dashboard')->assertOk();
    }

    public function test_role_management_requires_each_sensitive_permission(): void
    {
        $staff = $this->staff();
        $role = $staff->roles->first();
        $role->givePermissionTo(Permission::findByName('roles.view'));

        $this->actingAs($staff)->get('/configuration/setting/roles')->assertOk();
        $this->actingAs($staff)->post('/configuration/setting/roles', ['name' => 'Injected'])->assertForbidden();
        $this->assertDatabaseMissing('roles', ['name' => 'Injected']);

        $role->givePermissionTo(Permission::findByName('roles.create'));
        $this->actingAs($staff)->post('/configuration/setting/roles', ['name' => 'Registrar'])->assertRedirect();
        $this->assertDatabaseHas('roles', ['name' => 'Registrar']);
    }

    public function test_admin_cannot_remove_the_last_administration_path(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin = User::factory()->create(['status' => 'ACTIVE']);
        $admin->assignRole($adminRole);

        $this->actingAs($admin)->delete(route('configuration.setting.roles.destroy', $adminRole))->assertForbidden();
        $this->actingAs($admin)->delete(route('configuration.setting.users.destroy', $admin))->assertForbidden();
        $this->assertDatabaseHas('roles', ['id' => $adminRole->id]);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_view_without_create_hides_role_create_control(): void
    {
        $staff = $this->staff();
        $staff->roles->first()->givePermissionTo(Permission::findByName('roles.view'));

        $this->actingAs($staff)->get('/configuration/setting/roles')
            ->assertOk()
            ->assertDontSee('add-role-modal');
    }

    public function test_role_permission_save_and_removal_persist_after_reload(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin = User::factory()->create(['status' => 'ACTIVE']);
        $admin->assignRole($adminRole);
        $target = Role::create(['name' => 'permission-target', 'guard_name' => 'web']);
        $permission = Permission::findByName('dashboard.view');

        $this->actingAs($admin)->post(route('configuration.setting.roles.permissions.sync', $target), [
            'permission_ids' => [$permission->id],
        ])->assertRedirect();
        $this->assertDatabaseHas('role_has_permissions', ['role_id' => $target->id, 'permission_id' => $permission->id]);
        $this->get(route('configuration.setting.roles'))->assertOk()
            ->assertSee('value="'.$permission->id.'"', false)->assertSee('checked', false)
            ->assertSeeInOrder(['Dashboard', 'Configuration', 'Academic', 'Reports', 'Accounts', 'Settings'])
            ->assertSee('View Approval Queue')->assertSee('Assign Permissions')
            ->assertSee('Select All')->assertSee('Clear All');

        $this->post(route('configuration.setting.roles.permissions.sync', $target), [])->assertRedirect();
        $this->assertDatabaseMissing('role_has_permissions', ['role_id' => $target->id, 'permission_id' => $permission->id]);
    }

    public function test_user_role_options_are_dynamic_and_assignment_is_guarded(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $registrar = Role::create(['name' => 'Test Registrar', 'guard_name' => 'web']);
        $wrongGuard = Role::create(['name' => 'API Only', 'guard_name' => 'api']);
        $registrar->givePermissionTo(Permission::findByName('dashboard.view'));
        $admin = User::factory()->create(['status' => 'ACTIVE']);
        $admin->assignRole($adminRole);

        $this->actingAs($admin)->get(route('configuration.setting.users'))->assertOk()
            ->assertSeeInOrder(['admin', 'staff', 'Test Registrar'])
            ->assertDontSee('API Only');

        $this->post(route('configuration.setting.users.store'), [
            'username' => 'role-test-user', 'email' => 'role-test@example.test', 'role_id' => $registrar->id,
        ])->assertRedirect();
        $user = User::where('username', 'role-test-user')->firstOrFail();
        $this->assertTrue($user->hasRole($registrar));
        $this->assertTrue($user->can('dashboard.view'));

        $this->get(route('configuration.setting.users'))->assertOk()
            ->assertSee('value="'.$registrar->id.'" selected', false);
        $this->put(route('configuration.setting.users.update', $user), [
            'username' => $user->username, 'email' => $user->email, 'role_id' => $staffRole->id,
        ])->assertRedirect();
        $this->assertTrue($user->fresh()->hasRole($staffRole));
        $this->assertFalse($user->fresh()->hasRole($registrar));

        $this->post(route('configuration.setting.users.store'), [
            'username' => 'wrong-guard', 'email' => 'wrong-guard@example.test', 'role_id' => $wrongGuard->id,
        ])->assertSessionHasErrors('role_id');
    }

    public function test_user_without_assign_role_permission_cannot_change_a_role(): void
    {
        $actor = $this->staff();
        $actor->roles->first()->givePermissionTo(Permission::findByName('users.update'));
        $targetRole = Role::create(['name' => 'Target Role', 'guard_name' => 'web']);
        $replacement = Role::create(['name' => 'Replacement Role', 'guard_name' => 'web']);
        $target = User::factory()->create(['status' => 'ACTIVE']);
        $target->assignRole($targetRole);

        $this->actingAs($actor)->put(route('configuration.setting.users.update', $target), [
            'username' => $target->username, 'email' => $target->email, 'role_id' => $replacement->id,
        ])->assertForbidden();
        $this->assertTrue($target->fresh()->hasRole($targetRole));
    }

    private function staff(): User
    {
        $role = Role::create(['name' => 'test-staff-'.str()->random(6), 'guard_name' => 'web']);
        $user = User::factory()->create(['status' => 'ACTIVE']);
        $user->assignRole($role);

        return $user->load('roles');
    }
}
