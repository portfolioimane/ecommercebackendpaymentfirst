<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products or any specific logic for the homepage
        $products = Product::with('category')->take(10)->get(); // Adjust the limit as needed
        return response()->json($products);
    }
}
