<?php

// app/Http/Livewire/Buyer/CheckoutSuccess.php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Invoice;

class CheckoutSuccess extends Component
{
    public $invoice;

    public function mount()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $cartItems = $user->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('buyer.cart');
        }

        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Create Invoice
        $this->invoice = Invoice::create([
            'user_id' => $user->id,
            'amount' => $totalAmount,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'status' => 'paid',
        ]);

        // Create Orders
        foreach ($cartItems as $item) {
            Order::create([
                'buyer_id' => $user->id,
                'vendor_id' => $item->product->vendor_id,
                'product_id' => $item->product->id,
                'status' => 'pending',
                'quantity' => $item->quantity,
                'total_price' => $item->product->price * $item->quantity,
            ]);
        }

        // Clear Cart
        $user->carts()->delete();

        session()->flash('success', 'Payment successful! Your orders have been placed.');
    }

    public function render()
    {
        return view('livewire.buyer.checkout-success')->layout('layouts.app');
    }
}
