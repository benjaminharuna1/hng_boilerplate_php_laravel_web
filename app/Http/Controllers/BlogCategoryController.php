<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role:super-admin'); // Role-based access
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = BlogCategory::create([
            'name' => $validated['name']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog category created successfully.',
            'data' => $category,
            'status_code' => 201
        ], 201);
    }
}
