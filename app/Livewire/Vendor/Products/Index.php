<?php

namespace App\Livewire\Vendor\Products;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        session()->flash('success', 'Product deleted successfully.');
    }

    public function render()
    {
        // Vendor ke saare products + shop + images eager load karke
        $products = Product::where('vendor_id', Auth::id())
            ->with(['images', 'shop'])
            ->get();

        return view('livewire.vendor.products.index', compact('products'))
            ->layout('layouts.app');
    }
}
