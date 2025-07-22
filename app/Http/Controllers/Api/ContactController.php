<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
{
    // Validate
    $validated = $request->validate([
        'email' => 'required|email',
        'name' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    // DB-yə yazırıq:
    ContactMessage::create($validated);

    // Success cavabı
    return response()->json([
        'message' => 'Thank you for your message!',
    ], 201);
}

}
