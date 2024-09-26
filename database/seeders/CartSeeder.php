<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\CartItem;

class CartSeeder extends Seeder
{
    public function run()
    {
        $cart = Cart::create(['user_id' => 1]); // Assuming user with ID 1 exists

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => 1,
            'quantity' => 2,
            'image' => 'path/to/smartphone.jpg', // Store image for the cart item
        ]);
        
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => 2,
            'quantity' => 1,
            'image' => 'path/to/tshirt.jpg', // Store image for the cart item
        ]);
    }
}
