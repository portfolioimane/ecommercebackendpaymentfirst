<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $order = Order::create(['user_id' => 1, 'total_price' => 719.97, 'status' => 'pending']); // Total price calculated

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => 1,
            'quantity' => 1,
            'price' => 699.99,
            'image' => 'path/to/smartphone.jpg', // Store image for the order item
        ]);
        
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => 2,
            'quantity' => 1,
            'price' => 19.99,
            'image' => 'path/to/tshirt.jpg', // Store image for the order item
        ]);
    }
}
