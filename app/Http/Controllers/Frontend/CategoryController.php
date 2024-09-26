<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
     public function index()
    {
        return Category::with('products')->get(); // Return all products with their categories
    }
}
