<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Dashboard extends Component
{
    use WithFileUploads;

    public $name, $description, $logo, $existingLogo;
    public $shops;
    public $shop_id = null;
    public $showForm = false; // 👈 New property for toggling form

    public function mount()
    {
        $this->loadShops();
    }

    private function loadShops()
    {
        $this->shops = Shop::where('vendor_id', Auth::id())
            ->with(['products.images']) // eager load products + images
            ->latest()
            ->get();
    }

    public function toggleForm()
    {
        $this->resetForm();
        $this->showForm = !$this->showForm;
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);

        if ($shop->vendor_id !== Auth::id()) {
            abort(403);
        }

        $this->shop_id = $shop->id;
        $this->name = $shop->name;
        $this->description = $shop->description;
        $this->existingLogo = $shop->logo;
        $this->showForm = true; // open form in edit mode
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if ($this->shop_id) {
            $shop = Shop::findOrFail($this->shop_id);
            if ($shop->vendor_id !== Auth::id()) {
                abort(403);
            }
        } else {
            $shop = new Shop();
            $shop->vendor_id = Auth::id();
            $shop->user_id = Auth::id();
        }

        $shop->name = $this->name;
        $shop->description = $this->description;

        if ($this->logo) {
            if ($shop->logo && Storage::disk('public')->exists($shop->logo)) {
                Storage::disk('public')->delete($shop->logo);
            }
            $shop->logo = $this->logo->store('logos', 'public');
        }

        $shop->save();

        session()->flash('success', $this->shop_id ? 'Shop updated successfully!' : 'New shop created successfully!');

        $this->resetForm();
    }

    public function delete($id)
    {
        $shop = Shop::findOrFail($id);

        if ($shop->vendor_id !== Auth::id()) {
            abort(403);
        }

        if ($shop->logo && Storage::disk('public')->exists($shop->logo)) {
            Storage::disk('public')->delete($shop->logo);
        }

        $shop->delete();

        session()->flash('success', 'Shop deleted successfully!');

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->shop_id = null;
        $this->name = '';
        $this->description = '';
        $this->logo = null;
        $this->existingLogo = null;
        $this->showForm = false;

        $this->loadShops();
    }

    public function render()
    {
        return view('livewire.vendor.dashboard')
            ->layout('layouts.app');
    }
}
