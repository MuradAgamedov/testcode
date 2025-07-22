<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserSocial;
use Illuminate\Http\Request;

class UserSocialController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json($user->socialLinks);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'platform' => 'required|string',
            'url' => 'required|url',
        ]);

        $data['user_id'] = auth()->id();


        $social = UserSocial::create($data);

        return response()->json($social, 201);
    }

    public function show($id)
    {
        $social = UserSocial::with('user')->findOrFail($id);
        return response()->json($social);
    }

    public function update(Request $request, $id)
    {
        $social = UserSocial::findOrFail($id);

        $data = $request->validate([
            'platform' => 'sometimes|string',
            'url' => 'sometimes|url',
        ]);

        $social->update($data);

        return response()->json($social);
    }

    public function destroy($id)
    {
        $social = UserSocial::findOrFail($id);
        $social->delete();

        return response()->json(['message' => 'Deleted successfully.']);
    }
}
