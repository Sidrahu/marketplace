<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductUser;

class SubscriptionsList extends Component
{
    public $subscriptions;

    public function mount()
    {
        $this->loadSubscriptions();
    }

    public function loadSubscriptions()
    {
        // Load subscriptions with product and its images
        $this->subscriptions = ProductUser::with(['product.images'])
            ->where('user_id', Auth::id())
            ->orderBy('subscribed_at', 'desc')
            ->get();
    }

    public function unsubscribe($productId)
    {
        ProductUser::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        session()->flash('success', 'Unsubscribed successfully!');
        $this->loadSubscriptions();
    }

    public function render()
    {
        return view('livewire.buyer.subscriptions-list')
               ->layout('layouts.app');
    }
}
