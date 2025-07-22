<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserEducation;
use Illuminate\Http\Request;

class UserEducationController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        return response()->json($user->educations);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school' => 'required|string',
            'degree' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $data['user_id'] = auth('worker')->id();

        $education = UserEducation::create($data);

        return response()->json($education, 201);
    }

    public function update(Request $request, $id)
    {
        $education = UserEducation::findOrFail($id);

        $data = $request->validate([
            'school' => 'required|string',
            'degree' => 'nullable|string',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $education->update($data);

        return response()->json($education);
    }

    public function destroy($id)
    {
        $education = UserEducation::findOrFail($id);


        $education->delete();

        return response()->json(['message' => 'Education deleted successfully.']);
    }
}
