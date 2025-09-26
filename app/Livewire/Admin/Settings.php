<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class Settings extends Component
{
    public $site_name;
    public $site_email;
    public $currency;
    public $timezone;

    public $currentSettings; // Neeche show karne ke liye

    public function mount()
    {
        $settings = Setting::first(); // Pehli record fetch karo
        if($settings) {
            $this->site_name = $settings->site_name;
            $this->site_email = $settings->site_email;
            $this->currency = $settings->currency;
            $this->timezone = $settings->timezone;

            $this->currentSettings = $settings;
        }
    }

    public function saveSettings()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:50',
        ]);

        $settings = Setting::first();

        if(!$settings) {
            // Agar pehle create nahi hui toh create karo
            $settings = Setting::create([
                'site_name' => $this->site_name,
                'site_email' => $this->site_email,
                'currency' => $this->currency,
                'timezone' => $this->timezone,
            ]);
        } else {
            // Agar already exist karti hai toh update karo
            $settings->update([
                'site_name' => $this->site_name,
                'site_email' => $this->site_email,
                'currency' => $this->currency,
                'timezone' => $this->timezone,
            ]);
        }

        $this->currentSettings = $settings;

        session()->flash('message', 'Settings saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings')
         ->layout('layouts.app');
    }
}
