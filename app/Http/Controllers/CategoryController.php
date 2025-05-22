<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "No categories found"
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100',
            'image'   => 'nullable|string|max:255',
        ]);

        return response()->json([
            'status' => true,
            'data' => Category::create($request->all()),
        ],201);
    }

    public function show(string $id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100',
            'image'   => 'nullable|string|max:255',
        ]);
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json($category, 200);
    }

    public function destroy(string $id)
    {
        Category::destroy($id);
        return response()->json(['message' => 'category_deleted_successfully'], 204);
    }
}
