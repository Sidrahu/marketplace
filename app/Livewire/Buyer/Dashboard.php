<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $subscriptions;
    public $cartCount;
    public $nextBillingDate;
    public $activeSubscriptionsCount;
    public $totalSpent;

    public function mount()
    {
        $user = auth()->user();

        // Subscriptions (sorted by next billing date)
        $this->subscriptions = $user->subscriptions()
            ->orderBy('pivot_next_billing_date')
            ->get();

        // Active subscriptions count
        $this->activeSubscriptionsCount = $this->subscriptions->count();

        // Next upcoming billing date (first subscription)
        $this->nextBillingDate = $this->subscriptions->first()
            ? Carbon::parse($this->subscriptions->first()->pivot->next_billing_date)
            : null;

        // Cart items count
        $this->cartCount = $user->cartItems()->count();

        // ✅ Total Spent (sum of invoices amount)
        $this->totalSpent = $user->invoice()->sum('amount');
    }

    public function render()
    {
        return view('livewire.buyer.dashboard', [
            'subscriptions' => $this->subscriptions,
            'cartCount' => $this->cartCount,
            'nextBillingDate' => $this->nextBillingDate,
            'activeSubscriptionsCount' => $this->activeSubscriptionsCount,
            'totalSpent' => $this->totalSpent,
        ])->layout('layouts.app');
    }
}
