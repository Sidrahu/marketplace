<?php

namespace App\Livewire\Admin;
use App\Models\Product;
use Livewire\Component;

class ProductShow extends Component
{

     public $products;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::with('shop')->latest()->get();
    }

    public function approve($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'approved';
        $product->save();

        session()->flash('message', '✅ Product approved successfully.');
        $this->loadProducts();
    }

    public function reject($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'rejected';
        $product->save();

        session()->flash('message', '❌ Product rejected.');
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.admin.product-show')
         ->layout('layouts.app');
    }
}
