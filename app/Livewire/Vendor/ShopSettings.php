<?php
namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopSettings extends Component
{
    use WithFileUploads;

    public $shops;            // Vendor ke saare shops
    public $selectedShopId;   // Jo shop select hui
    public $shop;             // Current shop object

    public $name, $description, $logo, $existingLogo;
    public $phone, $email, $address, $currency, $opening_hours;
    public $facebook, $instagram, $twitter;

    public $allShops;         // Table me show karne ke liye

    public function mount()
    {
        $this->shops = Shop::where('vendor_id', Auth::id())->get();
        $this->allShops = $this->shops; // Table me initially show

        if ($this->shops->count()) {
            $this->selectedShopId = $this->shops->first()->id;
            $this->loadShop($this->selectedShopId);
        }
    }

    public function updatedSelectedShopId($shopId)
    {
        $this->loadShop($shopId);
    }

    private function loadShop($shopId)
    {
        $this->shop = Shop::where('vendor_id', Auth::id())
                          ->where('id', $shopId)
                          ->firstOrFail();

        $this->name = $this->shop->name;
        $this->description = $this->shop->description;
        $this->existingLogo = $this->shop->logo;
        $this->phone = $this->shop->phone;
        $this->email = $this->shop->email;
        $this->address = $this->shop->address;
        $this->currency = $this->shop->currency;
        $this->opening_hours = $this->shop->opening_hours;

        if ($this->shop->social_links) {
            $social = json_decode($this->shop->social_links, true);
            $this->facebook = $social['facebook'] ?? null;
            $this->instagram = $social['instagram'] ?? null;
            $this->twitter = $social['twitter'] ?? null;
        } else {
            $this->facebook = $this->instagram = $this->twitter = null;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'opening_hours' => 'nullable|string',
            'logo' => 'nullable|image|max:1024',
        ]);

        // Logo update
        if ($this->logo) {
            if ($this->shop->logo && Storage::disk('public')->exists($this->shop->logo)) {
                Storage::disk('public')->delete($this->shop->logo);
            }
            $this->shop->logo = $this->logo->store('logos', 'public');
        }

        $this->shop->update([
            'name' => $this->name,
            'description' => $this->description,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'currency' => $this->currency,
            'opening_hours' => $this->opening_hours,
            'social_links' => json_encode([
                'facebook' => $this->facebook,
                'instagram' => $this->instagram,
                'twitter' => $this->twitter,
            ])
        ]);

        session()->flash('success', 'Shop settings updated successfully!');

        // Table me turant reflect karne ke liye refresh
        $this->allShops = Shop::where('vendor_id', Auth::id())->get();
    }

    public function render()
    {
        return view('livewire.vendor.shop-settings')
            ->layout('layouts.app');
    }
}
