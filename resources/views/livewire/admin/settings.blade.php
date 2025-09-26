<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">⚙️ Site Settings</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSettings" class="space-y-4 bg-white p-6 rounded shadow">
        <div>
            <label class="block mb-1 font-semibold">Site Name</label>
            <input type="text" wire:model="site_name" class="w-full border p-2 rounded">
            @error('site_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Site Email</label>
            <input type="email" wire:model="site_email" class="w-full border p-2 rounded">
            @error('site_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Currency</label>
            <input type="text" wire:model="currency" class="w-full border p-2 rounded">
            @error('currency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Timezone</label>
            <input type="text" wire:model="timezone" class="w-full border p-2 rounded">
            @error('timezone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Settings</button>
    </form>

    @if($currentSettings)
    <div class="mt-6 bg-gray-50 p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Current Settings</h3>
        <p><strong>Site Name:</strong> {{ $currentSettings->site_name }}</p>
        <p><strong>Site Email:</strong> {{ $currentSettings->site_email }}</p>
        <p><strong>Currency:</strong> {{ $currentSettings->currency }}</p>
        <p><strong>Timezone:</strong> {{ $currentSettings->timezone }}</p>
    </div>
    @endif
</div>
