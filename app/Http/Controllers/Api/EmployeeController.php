<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        // Sadəcə worker olanlar
        $query = User::where('user_type', 'worker');

        // Əgər search varsa
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Hamısını yığırıq
        $employees = $query->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'score' => $user->totalScore(), // sənin methoddan
            ];
        })->sortByDesc('score')->values();

        // Pagination imitasiya etmək istəyirsənsə (əsl paginate olsa limit 10 olacaq)
        // amma map etdiyimiz üçün burada plain collection qalır
        // İstəsən əsl paginate da edə bilərik

        return response()->json([
            'data' => $employees,
            'total' => $employees->count(),
        ]);
    }

    //
}
