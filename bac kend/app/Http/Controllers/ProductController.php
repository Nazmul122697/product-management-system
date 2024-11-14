<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',  // Each category id must exist in the categories table
            'features' => 'nullable|array',  // Features are optional but must be an array if present
        ]);

        // Handle image upload
        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'title' => $request->title,
            'image' => $imagePath,
        ]);

        // Attach categories
        $product->categories()->attach($request->categories);

        // Add features if available
        if ($request->features) {
            foreach ($request->features as $feature) {
                $product->features()->create(['description' => $feature]);
            }
        }

        return response()->json($product, 201);
    }

}
