<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class SettingRoleController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $roles = Role::query()
            ->with('permissions')
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.setting.roles', [
            'roles' => $roles,
            'permissionGroups' => Permission::query()
                ->with(['children' => fn ($query) => $query->orderBy('name')])
                ->whereNull('parent_id')
                ->orderBy('name')
                ->get(),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->where('guard_name', 'web')],
        ], [
            'name.unique' => 'This role already exists.',
        ]);

        Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('configuration.setting.roles')
            ->with('success', 'Role added successfully.');
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')
                    ->where('guard_name', $role->guard_name)
                    ->ignore($role->id),
            ],
        ], [
            'name.unique' => 'This role already exists.',
        ]);

        $role->update($validated);

        return redirect()
            ->route('configuration.setting.roles')
            ->with('success', 'Role updated successfully.');
    }

    public function destroyPermission(Role $role, Permission $permission): RedirectResponse
    {
        $role->revokePermissionTo($permission);

        return redirect()
            ->route('configuration.setting.roles')
            ->with('success', 'Permission removed from role successfully.');
    }

    public function syncPermissions(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'permission_ids' => ['nullable', 'array'],
            'permission_ids.*' => ['integer', 'exists:permissions,id'],
        ]);

        $permissionIds = collect($validated['permission_ids'] ?? [])
            ->map(fn ($permissionId) => (int) $permissionId)
            ->unique()
            ->values();

        $permissions = Permission::query()
            ->whereIn('id', $permissionIds)
            ->whereNotNull('parent_id')
            ->get();

        $role->syncPermissions($permissions);

        return redirect()
            ->route('configuration.setting.roles')
            ->with('success', 'Permissions updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()
            ->route('configuration.setting.roles')
            ->with('success', 'Role deleted successfully.');
    }
}
