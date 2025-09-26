<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrdersList extends Component
{
    public $orders;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $this->orders = Order::where('buyer_id', Auth::id())
            ->with(['product.images', 'vendor']) // eager load product images
            ->latest()
            ->get()
            ->map(function ($order) {
                // fallback total amount
                $order->total_amount = $order->total_amount ?? ($order->product->price ?? 0);

                // ✅ Get first product image URL from storage
                $order->product->image_url = $order->product->images->first()
                    ? asset('storage/' . $order->product->images->first()->image_path)
                    : 'https://via.placeholder.com/150';

                return $order;
            });
    }

    public function render()
    {
        return view('livewire.buyer.orders-list', [
            'orders' => $this->orders,
        ])->layout('layouts.app');
    }
}
