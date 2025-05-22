<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        if ($items->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "No items found"
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => Item::all(),
        ]);
        // return Item::with('category')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en'     => 'required|string|max:100',
            'name_ar'     => 'required|string|max:100',
            'desc_en'     => 'required|string|max:255',
            'desc_ar'     => 'required|string|max:255',
            'image'       => 'nullable|string|max:255',
            'count'       => 'required|integer|min:0',
            'active'      => 'boolean',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        return response()->json([
            'status' => true,
            'data' => Item::create(
                $request->all(),
                201
            ),
        ]);
    }

    public function show(string $id)
    {
        return Item::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_en'     => 'required|string|max:100',
            'name_ar'     => 'required|string|max:100',
            'desc_en'     => 'required|string|max:255',
            'desc_ar'     => 'required|string|max:255',
            'image'       => 'nullable|string|max:255',
            'count'       => 'required|integer|min:0',
            'active'      => 'boolean',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        $item = Item::findOrFail($id);
        $item->update($request->all());

        return response()->json($item, 200);
    }

    public function destroy(string $id)
    {
        Item::destroy($id);
        return response()->json(['message' => 'item_deleted_successfully'], 204);
    }
}
