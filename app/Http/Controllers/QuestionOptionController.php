<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuestionOptionController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'is_correct' => 'required|boolean',
        ]);

        $option = $question->options()->create($validated);

        // Əgər bu doğru cavabdırsa, question cədvəlindəki correct_option_id güncəllə
        if ($validated['is_correct']) {
            $question->correct_option_id = $option->id;
            $question->save();
        }

        return response()->json([
            'message' => 'Variant əlavə edildi.',
            'data' => $option,
        ], 201);
    }
}
