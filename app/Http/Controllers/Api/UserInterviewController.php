<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VacancyApplicationInterview;

class UserInterviewController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $interviews = VacancyApplicationInterview::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['application', 'application.vacancy'])
            ->get();

        return response()->json($interviews);

    }
    }
