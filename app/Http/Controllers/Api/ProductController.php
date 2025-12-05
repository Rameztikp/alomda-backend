<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'products/' . Str::random(20) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public', $imageName);
            $validated['image_url'] = $imageName; // This will be processed by the accessor
        }

        $product = Product::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $product,
            'message' => 'تم إنشاء المنتج بنجاح.'
        ], 201);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name_ar' => 'string|max:255',
            'name_en' => 'string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'exists:categories,id',
            'is_active' => 'boolean',
        ]);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image_url) {
                Storage::delete('public/' . $product->image_url);
            }

            $image = $request->file('image');
            $imageName = 'products/' . Str::random(20) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public', $imageName);
            $validated['image_url'] = $imageName; // This will be processed by the accessor
        }

        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $product,
            'message' => 'تم تحديث المنتج بنجاح.'
        ]);
    }
}
