<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $userInfo = UserInfo::firstOrCreate(
            ['user_id' => $user->id],
            []
        );

        $userInfo->update($data);

        return response()->json([
            'message' => 'User info updated successfully',
            'user_info' => $userInfo,
        ]);
    }
}
