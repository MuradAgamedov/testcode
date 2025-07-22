<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::with('questionScores')->get();

        $users = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'score' => $user->totalScore(),
            ];
        })->sortByDesc('score')->values();

        $users = $users->map(function ($user, $index) use ($users) {
            $previous = $users[$index - 1]['score'] ?? $user['score'];
            $change = $user['score'] - $previous;

            return [
                'rank' => $index + 1,
                'name' => $user['name'],
                'status' => $change === 0 ? '●' : ($change > 0 ? '+' . $change : $change),
                'score' => $user['score'],
            ];
        });

        return response()->json($users);
    }
}
