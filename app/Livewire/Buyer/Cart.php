<?php
namespace App\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public $cartItems;

    protected $listeners = [
        'cartUpdated' => 'loadCarts',
    ];

    public function mount()
    {
        $this->loadCarts();
    }

    public function loadCarts()
    {
        $user = Auth::user();

        if ($user) {
            $this->cartItems = $user->carts()->with('product')->get();
        } else {
            $this->cartItems = collect();
        }
    }

    public function removeItem($cartId)
    {
        $user = Auth::user();

        if ($user) {
            $user->carts()->where('id', $cartId)->delete();
            $this->loadCarts();
            session()->flash('success', 'Item removed from cart.');
        }
    }

    // ✅ Increase quantity
    public function increaseQuantity($cartId)
    {
        $user = Auth::user();

        if ($user) {
            $item = $user->carts()->where('id', $cartId)->first();
            if ($item) {
                $item->quantity++;
                $item->save();
                $this->loadCarts();
            }
        }
    }

    // ✅ Decrease quantity (min 1)
    public function decreaseQuantity($cartId)
    {
        $user = Auth::user();

        if ($user) {
            $item = $user->carts()->where('id', $cartId)->first();
            if ($item && $item->quantity > 1) {
                $item->quantity--;
                $item->save();
                $this->loadCarts();
            }
        }
    }

    // Checkout
    public function checkout()
    {
        return redirect()->route('buyer.checkout'); // replace with your actual checkout route
    }

    public function render()
    {
        return view('livewire.buyer.cart')->layout('layouts.app');
    }
}
