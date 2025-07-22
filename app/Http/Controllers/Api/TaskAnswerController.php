<?php

// app/Http/Controllers/Api/TaskAnswerController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TaskAnswerController extends Controller
{
    public function index(Request $request)
{
    $taskAnswers = TaskAnswer::query();

    if ($request->has('user_id')) {
        $taskAnswers->where('user_id', $request->user_id);
    }

    if ($request->has('vacancy_id')) {
        $taskAnswers->where('vacancy_id', $request->vacancy_id);
    }

    if ($request->has('application_status_id')) {
        $taskAnswers->where('application_status_id', $request->application_status_id);
    }

    return response()->json($taskAnswers->get());
}



  public function store(Request $request)
{
    $validated = $request->validate([
        'vacancy_id' => 'required|exists:vacancies,id',
        'application_status_id' => 'required|exists:application_statuses,id',
    ]);

    try {
        $taskAnswer = TaskAnswer::create([
            'user_id' => auth()->id(), // tokenlə gələn user ID
            'vacancy_id' => $validated['vacancy_id'],
            'application_status_id' => $validated['application_status_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json($taskAnswer, 201);
    } catch (\Exception $e) {
        Log::error('TaskAnswer creation failed: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred.'], 500);
    }
}


    

    public function show(TaskAnswer $taskAnswer)
    {
        return $taskAnswer->load(['user', 'vacancy']);
    }

    public function update(Request $request, TaskAnswer $taskAnswer)
    {
        $data = $request->validate([
            'result' => 'required|in:Accept,Reject,Wait',
        ]);

        $taskAnswer->update($data);

        return response()->json($taskAnswer);
    }

    public function destroy(TaskAnswer $taskAnswer)
    {
        $taskAnswer->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
