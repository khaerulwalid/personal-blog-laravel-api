<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        // validation input
        $request->validate([
           'name' => 'required',
        ]);

        $post = Category::create([
            'name' => $request->name
        ]);

        return response()->json($post, 201);
    }
}
