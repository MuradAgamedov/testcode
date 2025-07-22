<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserQuestionScore;
use Illuminate\Http\Request;

class UserQuestionScoreController extends Controller
{
    public function filterByScore(Request $request)
    {
        // Validate the 'score' query parameter
        $validated = $request->validate([
            'score' => 'required|integer',  // You can modify this rule as per your needs
        ]);

        // Retrieve records based on the score
        $scores = UserQuestionScore::where('score', $validated['score'])->get();

        // Return the filtered results
        return response()->json($scores);
    }
}
