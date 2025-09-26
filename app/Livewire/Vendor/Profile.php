<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $name, $email, $phone, $address;
    public $profile_photo;

    public $shop_name, $shop_description, $shop_logo, $shop_address;
    public $existingProfilePhoto, $existingShopLogo;

    public function mount()
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;

        $this->shop_name = $user->shop_name;
        $this->shop_description = $user->shop_description;
        $this->shop_address = $user->shop_address;

        $this->existingProfilePhoto = $user->profile_photo;
        $this->existingShopLogo = $user->shop_logo;
    }

    public function save()
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|max:1024',
            'shop_name' => 'nullable|string|max:255',
            'shop_description' => 'nullable|string',
            'shop_logo' => 'nullable|image|max:1024',
            'shop_address' => 'nullable|string|max:255',
        ]);

        // Profile Photo Upload
        if ($this->profile_photo) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = $this->profile_photo->store('profile_photos', 'public');
        }

        // Shop Logo Upload
        if ($this->shop_logo) {
            if ($user->shop_logo && Storage::disk('public')->exists($user->shop_logo)) {
                Storage::disk('public')->delete($user->shop_logo);
            }
            $user->shop_logo = $this->shop_logo->store('shop_logos', 'public');
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'shop_name' => $this->shop_name,
            'shop_description' => $this->shop_description,
            'shop_address' => $this->shop_address,
        ]);

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.vendor.profile')->layout('layouts.app');
    }
}
