<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with('category')->get(); // Return all products with their categories
    }

    public function show($id)
    {
        return Product::with('category')->findOrFail($id); // Return a specific product
    }
}
