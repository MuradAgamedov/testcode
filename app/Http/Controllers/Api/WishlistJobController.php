<?php

// app/Http/Controllers/Api/WishlistJobController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WishlistJob;
use Illuminate\Http\Request;

class WishlistJobController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return WishlistJob::with('vacancy')->where('user_id', $user->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'vacancy_id' => 'required|exists:vacancies,id',
        ]);

        $wishlist = WishlistJob::firstOrCreate([
            'user_id' => auth()->id(),
            'vacancy_id' => $request->vacancy_id,
        ]);

        return response()->json(['message' => 'Added to wishlist', 'data' => $wishlist], 201);
    }

    public function destroy($vacancyId)
    {
        $wishlist = WishlistJob::where('vacancy_id', $vacancyId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $wishlist->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }

}
