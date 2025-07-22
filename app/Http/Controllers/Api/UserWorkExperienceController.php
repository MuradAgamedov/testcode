<?php


// app/Http/Controllers/Api/UserWorkExperienceController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWorkExperience;
use Illuminate\Http\Request;

class UserWorkExperienceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json($user->workExperiences, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data['user_id'] = auth()->id();

        $experience = UserWorkExperience::create($data);

        return response()->json($experience, 201);
    }

    public function update(Request $request, $id)
    {
        $experience = UserWorkExperience::findOrFail($id);


        $data = $request->validate([
            'role' => 'required|string',
            'company_name' => 'required|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $experience->update($data);

        return response()->json($experience);
    }

    public function destroy($id)
    {
        $experience = UserWorkExperience::findOrFail($id);

        $experience->delete();

        return response()->json(['message' => 'Work experience deleted']);
    }
}
