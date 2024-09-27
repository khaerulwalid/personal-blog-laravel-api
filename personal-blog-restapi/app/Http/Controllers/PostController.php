<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);
        $post = Post::with(['user', 'category'])->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'current_page' => intval($page),
            'last_page' => $post->lastPage(),
            'per_page' => $post->perPage(),
            'total' => $post->total(),
            'from' => $post->firstItem(),
            'to' => $post->lastItem(),
            'first_page_url' => $post->url(1),
            'last_page_url' => $post->url($post->lastPage()),
            'next_page_url' => $post->nextPageUrl(),
            'prev_page_url' => $post->previousPageUrl(),
            'path' => $post->path(),
            'data' => $post->items(),
        ], 200);
    }

    public function getAllPosts()
    {
        return response()->json(Post::with(['user', 'category'])->get(), 200);
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

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 201);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'category'])->find($id);

        if(!$post)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 200);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string',
            'slug' => 'unique:posts,slug' . ($post ? ",{$post->id}" : ''),
            'content' => 'required',
            'category_id' => 'exists:categories,id',
        ]);

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->image_url = $request->input('image_url');
        $post->category_id = $request->input('category_id');

        $post->save();

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 200);
    }

    public function destroy(Post $post)
    {
        $title = $post->title;
        $post->delete();

        return response()->json([
            'status' => 'success',
            'data' => "Post $title deleted successfully"
        ], 200);
    }
}
