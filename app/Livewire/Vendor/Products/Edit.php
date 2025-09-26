<?php

namespace App\Livewire\Vendor\Products;

use App\Models\Product;
use App\Models\Shop;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;


class Edit extends Component
{
    public Product $product;

    public $name, $description, $price, $quantity, $status;
    public $shops = [];
    public $shopId;
    public $selectedShop;

    public function mount(Product $product)
{
    $this->product = $product;

    // Prefill form
    $this->name = $product->name;
    $this->description = $product->description;
    $this->price = $product->price;
    $this->quantity = $product->quantity;
    $this->status = $product->status;
    $this->shopId = $product->shop_id;

    // Vendor ke shops load karo (agar vendor_id column hai)
    // Agar vendor_id column nahi hai to sari shops load karo
    if (Schema::hasColumn('shops', 'vendor_id')) {
        $this->shops = Shop::where('vendor_id', Auth::id())->get();
    } else {
        $this->shops = Shop::all();
    }

    $this->selectedShop = $this->shops->firstWhere('id', $this->shopId);
}


    public function updatedShopId($value)
    {
        $this->selectedShop = $this->shops->firstWhere('id', $value);
    }

    public function update()
    {
        $this->validate([
            'shopId'      => 'required|exists:shops,id',
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer',
            'status'      => 'required|boolean',
        ]);

        $this->product->update([
            'shop_id'     => $this->shopId,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'quantity'    => $this->quantity,
            'status'      => $this->status,
        ]);

        session()->flash('success', 'Product updated successfully.');
        return redirect()->route('vendor.products.index');
    }

    public function render()
    {
        return view('livewire.vendor.products.edit', [
            'shops' => $this->shops
        ])->layout('layouts.app');
    }
}
