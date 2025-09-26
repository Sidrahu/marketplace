<?php
namespace App\Livewire\Buyer;

use App\Models\Product;
use Livewire\Component;

class BuyerProductList extends Component
{
    public $buyer;

    public function mount()
    {
        $this->buyer = auth()->user()->load('subscriptions');
    }

    public function subscribe($productId)
    {
        $this->buyer->subscriptions()->attach($productId);
        $this->refreshBuyer();
    }

    public function unsubscribe($productId)
    {
        $this->buyer->subscriptions()->detach($productId);
        $this->refreshBuyer();
    }

    public function refreshBuyer()
    {
        $this->buyer = $this->buyer->fresh('subscriptions');
    }

    public function render()
{
    $products = Product::with(['subscribers', 'images'])->get(); 

    return view('livewire.buyer.buyer-product-list', [
        'products' => $products,
    ])->layout('layouts.app');
}

}
