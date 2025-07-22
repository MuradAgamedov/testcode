<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancySkillController extends Controller
{
public function store(Request $request, $vacancyId)
{
    $vacancy = Vacancy::findOrFail($vacancyId);

    // Postman body'dən gələn: ya array formatında, ya da vergüllə ayrılmış string
    $skillInput = $request->input('skill_ids');

    if (is_string($skillInput)) {
        $skillIds = explode(',', $skillInput);
    } elseif (is_array($skillInput)) {
        $skillIds = $skillInput;
    } else {
        $skillIds = [];
    }

    // Debug:


    // Sync et
    $vacancy->skills()->sync($skillIds);

    return response()->json([
        'message' => 'Skills updated successfully.',
        'skills' => $vacancy->skills()->get()
    ]);
}


    public function index(Vacancy $vacancy)
    {
        logger('Reached vacancy skill index', ['vacancy_id' => $vacancy->id]);

        $vacancy->load('skills');

        return response()->json([
            'message' => 'Vacancy skills fetched successfully',
            'skills' => $vacancy->skills
        ]);
    }
}
