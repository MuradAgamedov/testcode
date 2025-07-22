<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function index()
    {
        $user = auth()->user();
         return response()->json([
        'skills' => Skill::all() // burada lazım gəlsə withTrashed() də yaz
    ]);
    }


    public function assignSkill(Request $request)
    {
        $data = $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $user = auth()->user();
        $user->skills()->syncWithoutDetaching([$data['skill_id']]);

        return response()->json(['message' => 'Skill assigned']);
    }

   public function removeSkill(Request $request)
{
    $data = $request->validate([
        'skill_id' => 'required|exists:skills,id',
    ]);

    $user = Auth::user(); // Tokenlə daxil olmuş istifadəçi

    $user->skills()->detach($data['skill_id']);

    return response()->json(['message' => 'Skill removed']);
}

    public function getUserSkills()
    {
        $user = Auth::user(); // tokenlə giriş edən istifadəçi
        return $user->skills;
    }
}
