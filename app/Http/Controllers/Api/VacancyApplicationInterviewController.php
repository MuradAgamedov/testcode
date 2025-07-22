<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VacancyApplication;
use App\Models\VacancyApplicationInterview;
use Illuminate\Http\Request;

class VacancyApplicationInterviewController extends Controller
{
protected function authorizeInterviewQuery(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return [null, null];
    }

    if ($user->user_type === 'worker') {
        return ['worker', $user->id];
    } elseif ($user->user_type === 'hr') {
        return ['hr', $user->id];
    }

    return [null, null];
}


    public function index(Request $request)
{
    [$guard, $userId] = $this->authorizeInterviewQuery($request);

    if (!$guard || !$userId) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    if ($guard === 'worker') {
        $interviews = VacancyApplicationInterview::whereHas('application', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();
    } elseif ($guard === 'hr') {
        $interviews = VacancyApplicationInterview::whereHas('application.vacancy', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();
    } else {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    return response()->json($interviews->load('application'));
}


    public function show(Request $request, $id)
    {
        [$guard, $userId] = $this->authorizeInterviewQuery($request);

        if ($guard === 'worker') {
            $interview = VacancyApplicationInterview::where('id', $id)
                ->whereHas('application', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->firstOrFail();
        } elseif ($guard === 'hr') {
            $interview = VacancyApplicationInterview::where('id', $id)
                ->whereHas('application.vacancy', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->firstOrFail();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($interview->load('application'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'application_id' => 'required|exists:vacancy_applications,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'meet_link' => 'required|string',
        ]);

        $application = VacancyApplication::findOrFail($data['application_id']);
        $userId = $application->user_id;

        $interview = VacancyApplicationInterview::create($data);

        if (User::where('id', $userId)->exists()) {
            $interview->users()->attach($userId);
        }

        return response()->json($interview->load('users'), 201);
    }

public function update(Request $request, $id)
{
    [$guard, $userId] = $this->authorizeInterviewQuery($request);

    $applicationInterview = \App\Models\VacancyApplicationInterview::withTrashed()->findOrFail($id);

    if ($guard === 'worker') {
        $data = $request->validate([
            'result' => 'required|in:pending,accepted,rejected',
        ]);

        if (!$applicationInterview->users()->where('user_id', $userId)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    } elseif ($guard === 'hr') {
        $data = $request->validate([
            'date' => 'sometimes|date',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i',
            'meet_link' => 'sometimes|string',
        ]);

        if (
            !$applicationInterview->application ||
            !$applicationInterview->application->vacancy ||
            $applicationInterview->application->vacancy->user_id !== $userId
        ) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    } else {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $applicationInterview->update($data);

    return response()->json($applicationInterview);
}


public function destroy(Request $request, VacancyApplicationInterview $applicationInterview)
{
    [$guard, $userId] = $this->authorizeInterviewQuery($request);

    $applicationInterview->load('application.vacancy');



    if ($guard === 'hr') {
        if ($applicationInterview->application->vacancy->user_id !== $userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $applicationInterview->delete();
        return response()->json(['message' => 'Interview deleted']);
    }

    return response()->json(['message' => 'Unauthorized'], 403);
}


}
