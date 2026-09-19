<?php

namespace App\Http\Middleware;

use App\Models\{Guardian, MobileApiToken, StudentAccount};
use Closure;
use Illuminate\Http\Request;

class MobileApiAuth
{
    public function handle(Request $request, Closure $next, ?string $requiredRole = null)
    {
        $plain = $request->bearerToken();
        $token = $plain ? MobileApiToken::where('token_hash', hash('sha256', $plain))->first() : null;
        if (! $token || ($token->expires_at && $token->expires_at->isPast())) {
            $token?->delete();
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }
        if ($requiredRole && $token->account_type !== $requiredRole) {
            return response()->json(['success' => false, 'message' => 'This account cannot access that portal.'], 403);
        }
        $model = $token->account_type === 'student' ? StudentAccount::class : Guardian::class;
        $account = $model::find($token->account_id);
        if (! $account || $account->status !== 'ACTIVE') {
            $token->delete();
            return response()->json(['success' => false, 'message' => 'This account is no longer active.'], 403);
        }
        $token->forceFill(['last_used_at' => now()])->save();
        $request->attributes->set('mobile_token', $token);
        $request->attributes->set('mobile_user', $account);
        $request->attributes->set('mobile_role', $token->account_type);
        return $next($request);
    }
}
