<?php

namespace App\Livewire\Buyer;

use App\Models\ProductUser;
use App\Models\Product;
use App\Notifications\NewSubscriptionNotification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SubscribeProduct extends Component
{
    public Product $product;

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);

       
    }

    public function subscribe()
{
    if ($this->isSubscribed()) {
        session()->flash('info', 'Already subscribed.');
        return;
    }

    $subscription = ProductUser::create([
        'user_id' => Auth::id(),
        'product_id' => $this->product->id,
        'subscribed_at' => now(),
        'next_billing_date' => now()->addMonth(),
    ]);

    $vendor = $this->product->shop->user;

    if ($vendor) {
        $vendor->notify(new NewSubscriptionNotification(Auth::user(), $this->product));
    }

    session()->flash('success', 'Subscribed successfully!');
}


    public function unsubscribe()
    {
        ProductUser::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->delete();

        session()->flash('success', 'Unsubscribed successfully!');
    }

    public function isSubscribed()
    {
        return ProductUser::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->exists();
    }

    public function render()
    {
        return view('livewire.buyer.subscribe-product')->layout('layouts.app');
    }
}
