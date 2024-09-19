<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::with('category', 'user')->get();
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string',
            'content' => 'required',
            'category_id' => 'exists:categories,id',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $request->image_url,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id
        ]);

        return response()->json($post, 201);
    }
}
