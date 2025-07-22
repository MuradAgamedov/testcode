<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::all();

        // Return the categories as a JSON response
        return response()->json($categories);
    }
}
