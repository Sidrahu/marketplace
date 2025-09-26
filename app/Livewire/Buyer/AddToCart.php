<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;
    protected $listeners = ['checkout' => 'processCheckout'];
    

    public function mount($productId)
    {
        $this->productId = $productId;
    }

 public function addToCart()
{
    $user = auth()->user();

    if (!$user) {
        session()->flash('error', 'Please login to add to cart.');
        return;
    }

    $product = Product::find($this->productId);

    if (!$product) {
        session()->flash('error', 'Product not found.');
        return;
    }

    $cartItem = $user->carts()->where('product_id', $this->productId)->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        $user->carts()->create([
            'product_id' => $this->productId,
            'quantity' => 1,
        ]);
    }

    session()->flash('success', "{$product->name} added to cart.");

    $this->dispatch('cartUpdated');  
}


    public function render()
    {
        return view('livewire.buyer.add-to-cart')
        ->layout('layouts.app');
    }
}
