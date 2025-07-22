<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthInfoController extends Controller
{
    public function show(Request $request)
    {
        $guards = ['worker', 'hr'];

        foreach ($guards as $guard) {
            auth()->shouldUse($guard);
            try {
                $user = auth($guard)->user();
                if ($user && $user->user_type === $guard) {
                    return response()->json([
                        'role' => $guard,
                        'user' => $user,
                    ]);
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
