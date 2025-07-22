<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        // Fetch all roles from the database
         $roles = Role::select('id', 'name')->get();

        // Return the roles as a JSON response
       return response()->json([
            'message' => 'Roles fetched successfully',
            'data' => $roles
        ]);
    }

  
}
