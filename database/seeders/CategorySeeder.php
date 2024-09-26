<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
        Category::create(['name' => 'Fashion', 'slug' => 'fashion']);
        Category::create(['name' => 'Home Appliances', 'slug' => 'home-appliances']);
    }
}
