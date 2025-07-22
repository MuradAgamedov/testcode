<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use App\Models\VacancyTechnicalTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VacancyTechnicalTaskController extends Controller
{
    public function store(Request $request, $vacancyId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5120', // max 5MB
        ]);

        $vacancy = Vacancy::findOrFail($vacancyId);

        $path = $request->file('file')->store('public/tasks');

        $task = VacancyTechnicalTask::create([
            'vacancy_id' => $vacancy->id,
            'file_path' => Storage::url($path), // /storage/tasks/...
        ]);

        return response()->json([
            'id' => $task->id,
            'vacancy_id' => $task->vacancy_id,
            'file_url' => $task->file_url,
            'created_at' => $task->created_at,
        ]);


    }
}
