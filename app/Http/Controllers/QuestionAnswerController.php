<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserQuestionScore;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function submit(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'option_id' => 'required|exists:question_options,id',
        ]);

        $user = auth()->user();

        // Find question with its options and correct answer
        $question = Question::with(['options', 'correctOption'])->findOrFail($id);
        $correct = $question->correctOption;

        if (!$correct) {
            return response()->json(['message' => 'Correct answer not set'], 400);
        }

        // Check if the answer is incorrect
        if ((int) $request->option_id !== (int) $correct->id) {
            return response()->json([
                'message' => 'Wrong answer',
                'score_added' => 0
            ], 200);
        }


        // Determine score by difficulty
        $score = match ($question->difficulty) {
            'Easy' => 10,
            'Medium' => 20,
            'Hard' => 30,
            default => 0,
        };

        // Prevent duplicate scoring
        $existing = UserQuestionScore::where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already answered'], 200);
        }

        // Save the score
        UserQuestionScore::create([
            'user_id'         => $user->id,
            'question_id'     => $question->id,
            'score'           => $score,
            'question_option' => $request->option_id,
        ]);

        return response()->json([
            'message'     => 'Correct!',
            'score_added' => $score,
        ]);
    }
}
