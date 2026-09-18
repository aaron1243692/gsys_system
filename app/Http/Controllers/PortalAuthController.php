<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PortalAuthController extends Controller
{
    public function show(string $portal)
    {
        return view('portal.login', compact('portal'));
    }

    public function store(Request $request, string $portal)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $guard = Auth::guard($portal);
        if (filter_var($credentials['username'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }
        if (! $guard->validate($credentials)) {
            throw ValidationException::withMessages(['username' => 'Invalid username or password.']);
        }
        $account = $guard->getProvider()->retrieveByCredentials($credentials);
        if ($account->status !== 'ACTIVE' || ($portal === 'student' && ! $account->student()->whereHas('info')->exists())) {
            throw ValidationException::withMessages(['username' => 'Your account is not active. School staff must review and activate it before portal access.']);
        }
        // Switching portals must not carry an administrative or another portal identity.
        foreach (['web', 'teacher', 'student', 'guardian'] as $name) {
            Auth::guard($name)->logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Reuse the identity just validated; do not ignore a second authentication attempt.
        $guard->login($account);
        $request->session()->regenerate();

        return redirect()->route($portal.'.home');
    }

    public function destroy(Request $request, string $portal)
    {
        Auth::guard($portal)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal.login', ['portal' => $portal]);
    }
}
