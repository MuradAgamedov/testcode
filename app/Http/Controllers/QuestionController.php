<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return Question::with('options')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'text' => 'required|string|max:1000',
            'difficulty' => 'required|in:Easy,Medium,Hard',
        ]);

        $question = Question::create($validated);

        return response()->json([
            'message' => 'Sual uğurla yaradıldı.',
            'data' => $question,
        ], 201);
    }
}
