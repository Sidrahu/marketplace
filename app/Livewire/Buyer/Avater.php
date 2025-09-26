<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Avater extends Component
{
   use WithFileUploads;

    public $name, $email, $phone, $address, $password, $password_confirmation;
    public $profile_photo, $existingProfilePhoto;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->existingProfilePhoto = $user->profile_photo;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'profile_photo' => 'nullable|image|max:1024', 
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->address = $this->address;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        if ($this->profile_photo) {
            if ($this->existingProfilePhoto && Storage::exists($this->existingProfilePhoto)) {
                Storage::delete($this->existingProfilePhoto);
            }
            $path = $this->profile_photo->store('profile-photos', 'public');
            $user->profile_photo = $path;
            $this->existingProfilePhoto = $path;
        }

        $user->save();

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.buyer.avater')
        ->layout('layouts.app');
    }
}