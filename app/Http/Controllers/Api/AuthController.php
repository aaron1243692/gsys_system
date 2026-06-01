<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function studentLogin(Request $request): JsonResponse
    {
        return $this->login($request, Student::class, 'student');
    }

    public function guardianLogin(Request $request): JsonResponse
    {
        return $this->login($request, Guardian::class, 'guardian');
    }

    /**
     * @param class-string<Model> $model
     */
    private function login(Request $request, string $model, string $role): JsonResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $account = $model::query()
            ->where('username', $credentials['username'])
            ->first();

        if (! $account || ! Hash::check($credentials['password'], $account->password)) {
            throw ValidationException::withMessages([
                'username' => ['Invalid username or password.'],
            ]);
        }

        return response()->json([
            'message' => 'Login successful.',
            'user' => [
                'id' => $account->id,
                'username' => $account->username,
                'role' => $role,
            ],
        ]);
    }
}
