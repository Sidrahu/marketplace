<?php

namespace App\Livewire\Buyer;

use Livewire\Component;

class CartIcon extends Component
{
    protected $listeners = ['cartUpdated' => '$refresh'];

    public function render()
    {
        $cartCount = auth()->user()->carts->count();
        return view('livewire.buyer.cart-icon', compact('cartCount'));
    }
}
