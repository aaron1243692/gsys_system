<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SignInController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if (in_array($request->query('role'), ['teacher', 'student', 'guardian'], true)) {
            return redirect()->route('portal.login', ['portal' => $request->query('role')]);
        }

        return view('signin');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! Auth::attempt([
            $loginField => $credentials['login'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            return back()
                ->with('error', 'Sign in failed. Please check your username or password and try again.')
                ->withErrors(['login' => 'Invalid username or password.'])
                ->onlyInput('login');
        }

        $request->session()->regenerate();

        foreach (['teacher', 'student', 'guardian'] as $portal) {
            Auth::guard($portal)->logout();
        }

        return redirect()
            ->intended(route('dashboard'))
            ->with('success', 'Sign in successful. Welcome to your dashboard.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('signin');
    }
}
