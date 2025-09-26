<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;
use App\Models\Order;   // Order model import karna zaroori hai
use App\Models\Invoice;
use PDF;

class Checkout extends Component
{
    public $cartItems;
    public $totalAmount;

    protected $listeners = ['checkout' => 'processCheckout'];

    public function mount()
    {
        $this->loadCarts();
    }

    public function loadCarts()
    {
        $user = Auth::user();

        if ($user) {
            $this->cartItems = $user->carts()->with('product')->get();
            $this->totalAmount = $this->cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        } else {
            $this->cartItems = collect();
            $this->totalAmount = 0;
        }
    }

    public function success()
    {
        $user = Auth::user();
        $cartItems = $user->carts()->with('product')->get();
        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Invoice create karna
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'amount' => $totalAmount,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'status' => 'paid',
        ]);

       
        foreach ($cartItems as $item) {
            $vendorId = $item->product->vendor_id;

            if (!$vendorId) {
                \Log::error("Vendor ID missing for product ID {$item->product->id}");
                continue;   
            }

            Order::create([
                'user_id'     => auth()->id(), 
                'buyer_id' => $user->id,
                'vendor_id' => $vendorId,
                'product_id' => $item->product->id,
                'status' => 'pending',
                'quantity' => $item->quantity,
                'total_price' => $item->product->price * $item->quantity,
            ]);
        }

        // PDF generate karna (agar chahiye)
        $pdf = PDF::loadView('invoices.template', compact('invoice', 'cartItems'));
        $pdf->save(storage_path('app/public/invoices/' . $invoice->invoice_number . '.pdf'));

        // Cart clear karna
        $user->carts()->delete();

        return view('buyer.checkout-success', compact('invoice'));
    }

    public function processCheckout()
    {
        $user = Auth::user();

        if (!$user) {
            session()->flash('error', 'Please login to checkout.');
            return redirect()->route('login');
        }

        if ($this->totalAmount <= 0) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        $lineItems = [];

        foreach ($this->cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => intval($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        try {
            $checkoutSession = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('buyer.checkout.success'),
                'cancel_url' => route('buyer.checkout.cancel'),
                'customer_email' => $user->email,
                'metadata' => [
                    'user_id' => $user->id
                ],
            ]);

            return redirect()->away($checkoutSession->url);

        } catch (\Exception $e) {
            session()->flash('error', 'Error in creating Stripe Checkout session: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.buyer.checkout')
            ->layout('layouts.app');
    }
}
