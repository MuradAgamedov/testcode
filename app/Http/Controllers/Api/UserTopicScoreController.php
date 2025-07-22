<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UserTopicScoreController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Tokenə əsasən istifadəçini alır

        $scores = DB::table('user_question_scores as uqs')
            ->join('questions as q', 'q.id', '=', 'uqs.question_id')
            ->join('topics as t', 't.id', '=', 'q.topic_id')
            ->select('t.id as topic_id', 't.name as topic_name', DB::raw('SUM(uqs.score) as total_score'))
            ->where('uqs.user_id', $userId)
            ->groupBy('t.id', 't.name')
            ->get();

        return response()->json($scores);
    } 
    public function show($userId)
    {
        $scores = DB::table('user_question_scores as uqs')
            ->join('questions as q', 'q.id', '=', 'uqs.question_id')
            ->join('topics as t', 't.id', '=', 'q.topic_id')
            ->select('t.id as topic_id', 't.name as topic_name', DB::raw('SUM(uqs.score) as total_score'))
            ->where('uqs.user_id', $userId)
            ->groupBy('t.id', 't.name')
            ->get();

        return response()->json($scores);
    }




}
