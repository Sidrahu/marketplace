<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderStatusUpdated;

class OrdersIndex extends Component
{
    public $orders;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $this->orders = Order::where('vendor_id', Auth::id())
            ->with(['buyer', 'product', 'vendor'])
            ->latest()
            ->get();
    }

   public function updateStatus($orderId, $status)
{
    $order = Order::with(['buyer','product','vendor'])->findOrFail($orderId);
    $order->status = $status;
    $order->save();

    // Custom message
    $message = match($status) {
        'completed' => "Your order #{$order->id} for \"{$order->product->name}\" has been completed by {$order->vendor->name}.",
        'cancelled' => "Your order #{$order->id} for \"{$order->product->name}\" was cancelled by {$order->vendor->name}.",
        default => "Order #{$order->id} status changed to {$status}."
    };

    if ($order->buyer) {
        $order->buyer->notify(new OrderStatusUpdated($order, $message)); // ✅ notify buyer
    }

    $this->loadOrders();
    session()->flash('message', 'Order status updated and buyer notified.');
}


    public function render()
    {
        return view('livewire.vendor.orders-index')->layout('layouts.app');
    }
}
