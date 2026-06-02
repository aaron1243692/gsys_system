<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class SettingUserController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $users = User::query()
            ->with('roles')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.setting.users', [
            'users' => $users,
            'roles' => Role::query()->orderBy('name')->get(),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
        ], [
            'email.unique' => 'This email already exists.',
        ]);

        $role = ! empty($validated['role_id'])
            ? Role::query()->find($validated['role_id'])
            : null;

        unset($validated['role_id']);
        $validated['password'] = 'password';

        $user = User::create($validated);
        $user->syncRoles($role ? [$role] : []);

        return redirect()
            ->route('configuration.setting.users')
            ->with('success', 'User added successfully.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
        ], [
            'email.unique' => 'This email already exists.',
        ]);

        $role = ! empty($validated['role_id'])
            ? Role::query()->find($validated['role_id'])
            : null;

        unset($validated['role_id']);

        $user->update($validated);
        $user->syncRoles($role ? [$role] : []);

        return redirect()
            ->route('configuration.setting.users')
            ->with('success', 'User updated successfully.');
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('configuration.setting.users')
            ->with('success', 'User password reset successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('configuration.setting.users')
            ->with('success', 'User deleted successfully.');
    }
}
