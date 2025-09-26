<?php

namespace App\Livewire\Admin;

use App\Models\Subscription;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Subscriptions extends Component
{
    public $plan_name, $price, $start_date, $end_date;

    public function createSubscription()
    {
        Subscription::create([
            'user_id'   => Auth::id(),
            'plan_name' => $this->plan_name,
            'price'     => $this->price,
            'start_date'=> $this->start_date,
            'end_date'  => $this->end_date,
            'status'    => 'active',
        ]);

        session()->flash('message', 'Subscription created successfully!');
        $this->reset(['plan_name','price','start_date','end_date']);
    }

    public function render()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->get();
        return view('livewire.admin.subscriptions', compact('subscriptions')) ->layout('layouts.app');
    }
}
