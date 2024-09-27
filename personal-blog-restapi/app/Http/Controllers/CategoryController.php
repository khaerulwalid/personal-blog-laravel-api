<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);
        $categories = Category::paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'current_page' => $categories->currentPage(),
            'last_page' => $categories->lastPage(),
            'per_page' => $categories->perPage(),
            'total' => $categories->total(),
            'from' => $categories->firstItem(),
            'to' => $categories->lastItem(),
            'first_page_url' => $categories->url(1),
            'last_page_url' => $categories->url($categories->lastPage()),
            'next_page_url' => $categories->nextPageUrl(),
            'prev_page_url' => $categories->previousPageUrl(),
            'path' => $categories->path(),
            'data' => $categories->items()
        ]);
    }

    public function getAll()
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

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if(!$category)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::find($id);

        if(!$category)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        }

        $category->name = $request->input('name');
        $category->save();

        return response()->json([
            'status' => 'success',
            'data' => $category
        ], 201);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        }

        $category->destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => "Category $category->name deleted successfully"
        ], 200);
    }
}
