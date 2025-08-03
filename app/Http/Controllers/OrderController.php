<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with(['serviceCategory', 'vehicleType', 'driver', 'merchant'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return Inertia::render('orders/index', [
            'orders' => $orders
        ]);
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['serviceCategory', 'vehicleType', 'driver', 'merchant', 'items.product']);

        return Inertia::render('orders/show', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified order status.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:cancelled',
            'cancellation_reason' => 'required_if:status,cancelled|string|max:255',
        ]);

        if ($validated['status'] === 'cancelled' && $order->status === 'pending') {
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $validated['cancellation_reason'],
            ]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order cancelled successfully.');
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'Cannot cancel this order.');
    }
}