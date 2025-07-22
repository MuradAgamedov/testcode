<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VacancyApplicationTask;
use Illuminate\Http\Request;

class VacancyApplicationTaskController extends Controller
{
    public function store(Request $request)
    {
        $user = auth('worker')->id();
        $data = $request->validate([
            'application_id' => 'required|exists:vacancy_applications,id',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file')->store('vacancy-tasks', 'public');

        $task = VacancyApplicationTask::create([
            'application_id' => $data['application_id'],
            'file_path' => '/storage/' . $filePath,
            'user_id' => $user,
            'submitted_at' => now(),
        ]);



        return response()->json([
            'message' => 'Task uploaded and status set to pending',
            'task' => $task,
        ]);
    }
}
