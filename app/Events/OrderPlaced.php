<?php
namespace App\Events;

use App\Models\Order; 
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; // Import Log facade

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;  // Store the order details
        
        // Log order creation
        Log::info('Order placed event triggered', ['order_id' => $order->id, 'user_id' => $order->user_id]);
    }

    public function broadcastOn()
    {
        return new Channel('orders');  // Public channel for all admins to listen to
    }

    public function broadcastAs()
{
    return 'OrderPlaced';
}

}
