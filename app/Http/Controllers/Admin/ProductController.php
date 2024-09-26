<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0', // Added stock validation
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public'); // Specify disk
        }

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    public function show($id)
    {
        return Product::with('category')->findOrFail($id);
    }

   public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Log the incoming request
    \Log::info('Incoming update request data:', $request->all());

    $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|required|string',
        'price' => 'sometimes|required|numeric',
        'stock' => 'sometimes|required|integer|min:0', 
        'category_id' => 'sometimes|required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        if ($product->image) {
            \Storage::disk('public')->delete($product->image); 
        }
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    // Log validated data before updating
    \Log::info('Validated data to update:', $validated);

    try {
        $product->update($validated);
        return response()->json($product);
    } catch (\Exception $e) {
        \Log::error('Error updating product:', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Failed to update product'], 500);
    }
}


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Optionally delete image file from storage
        if ($product->image) {
            \Storage::disk('public')->delete($product->image); // Delete the image
        }
        
        $product->delete();
        return response()->json(null, 204);
    }
}
