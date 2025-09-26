<?php

namespace App\Livewire\Vendor\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name, $description, $price, $quantity, $images = [];
    public $shops = [];   
    public $shopId;       // selected shop id
    public $selectedShop; // selected shop object

    public function mount()
    {
        // Sirf current vendor ke shops
        $this->shops = Shop::where('vendor_id', Auth::id())->get();

        // Agar vendor ke paas ek hi shop hai to default select kar do aur logo set karo
        if ($this->shops->count() === 1) {
            $this->shopId = $this->shops->first()->id;
            $this->selectedShop = $this->shops->first();
        }
    }

    public function updatedShopId($value)
    {
        // Shop select hote hi update karo (logo ke saath)
        $this->selectedShop = Shop::find($value);
    }

    public function save()
    {
        $this->validate([
            'shopId'      => 'required|exists:shops,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'images.*'    => 'nullable|image|max:1024',
        ]);

        // Product create
        $product = Product::create([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'quantity'    => $this->quantity,
            'shop_id'     => $this->shopId,
            'vendor_id'   => Auth::id(),
            'user_id'     => Auth::id(), // ✅ Fix for NOT NULL error
        ]);

        // Images upload
        foreach ($this->images as $img) {
            $path = $img->store('products', 'public');
            $product->images()->create([
                'image_path' => $path
            ]);
        }

        session()->flash('success', 'Product created successfully!');
        return redirect()->route('vendor.products.index');
    }

    public function render()
    {
        return view('livewire.vendor.products.create', [
            'shops'         => $this->shops,
            'selectedShop'  => $this->selectedShop // ✅ logo display ke liye
        ])->layout('layouts.app');
    }
}
