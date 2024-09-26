<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class OrderController extends Controller
{

    public function getUserOrders()
{
    $userId = Auth::id();

    // Fetch orders for the authenticated user
    $orders = Order::where('user_id', $userId)->with('items.product')->get();

    return response()->json([
        'orders' => $orders,
    ]);
}


    public function show($id)
    {
        // Retrieve the order by ID
        $order = Order::with('items.product')->find($id);

        // Check if the order exists
        if (!$order) {
            return response()->json([
                'message' => 'Order not found.'
            ], 404);
        }

        // Optionally, you might want to check if the user is authorized to view the order
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access to this order.'
            ], 403);
        }

        return response()->json([
            'order' => $order,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string|in:credit-card,paypal',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'items.*.image' => 'sometimes|string|max:255',
        ]);

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(), // Only if user is logged in
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'image' => $item['image'],
            ]);
        }

        // Handle payment based on the selected payment method
        try {
            if ($request->payment_method === 'credit-card') {
                      Stripe::setApiKey(config('services.stripe.secret'));
                // Create a payment intent
                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->total_price * 100, // Convert to cents
                    'currency' => 'mad',
                    'payment_method_types' => ['card'],
                ]);

                return response()->json([
                    'success' => true,
                    'paymentIntent' => $paymentIntent,
                    'order' => $order,
                ]);
            }

     
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'order' => $order]);
    }
}