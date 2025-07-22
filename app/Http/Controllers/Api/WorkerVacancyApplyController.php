<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Vacancy;
use App\Models\VacancyApplication;

use Illuminate\Http\Request;

class WorkerVacancyApplyController extends Controller
{

    public function apply(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'vacancy_id' => 'required|exists:vacancies,id',
        ]);

        $vacancy = Vacancy::findOrFail($data['vacancy_id']);

        // Yoxlayaq user artıq müraciət edib?
        $existing = VacancyApplication::where('user_id', $user->id)
            ->where('vacancy_id', $vacancy->id)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => true,
                'step' => $vacancy->technical_task_path ? 'task_required' : 'applied',
                'message' => 'You have already applied to this vacancy.',
            ]);
        }

        // Əgər yox, müraciət yaradaq
        VacancyApplication::create([
            'user_id' => $user->id,
            'vacancy_id' => $vacancy->id,
            'application_status_id' => 1, // pending status (ya da sən hansı id verirsənsə)
        ]);

        return response()->json([
            'status' => true,
            'step' => $vacancy->technical_task_path ? 'task_required' : 'applied',
            'message' => $vacancy->technical_task_path 
                ? 'Technical task is required.'
                : 'You have successfully applied.',
        ]);
    }

}
