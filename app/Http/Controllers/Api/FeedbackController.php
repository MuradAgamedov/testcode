<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FeedbackMessage;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'role'    => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        FeedbackMessage::create($data);

        return response()->json([
            'message' => 'Thank you for your feedback!',
        ], 201);
    }
}
