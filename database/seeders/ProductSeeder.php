<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Smartphone',
            'description' => 'Latest model smartphone.',
            'price' => 699.99,
            'stock' => 100,
            'category_id' => 1,
            'image' => 'path/to/smartphone.jpg',
        ]);

        Product::create([
            'name' => 'T-Shirt',
            'description' => 'Stylish cotton T-shirt.',
            'price' => 19.99,
            'stock' => 200,
            'category_id' => 2,
            'image' => 'path/to/tshirt.jpg',
        ]);
        
        // Add more products as needed
    }
}
