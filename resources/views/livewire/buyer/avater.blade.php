<div class="max-w-3xl mx-auto py-10">
    <h2 class="text-2xl font-bold mb-6">👤 My Profile</h2>

    @if(session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">

        {{-- Personal Info Grid --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Name</label>
                <input type="text" wire:model.defer="name" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Email</label>
                <input type="email" wire:model.defer="email" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Phone</label>
                <input type="text" wire:model.defer="phone" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Address</label>
                <input type="text" wire:model.defer="address" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        {{-- Profile Photo --}}
        <div class="flex items-center gap-4">
            <div>
                @if ($existingProfilePhoto && !$profile_photo)
                    <img src="{{ asset('storage/' . $existingProfilePhoto) }}" class="w-16 h-16 rounded-full">
                @elseif ($profile_photo)
                    <img src="{{ $profile_photo->temporaryUrl() }}" class="w-16 h-16 rounded-full">
                @endif
            </div>
            <div class="flex-1">
                <label class="block font-medium">Profile Photo</label>
                <input type="file" wire:model="profile_photo" class="w-full border px-2 py-1 rounded">
            </div>
        </div>

        {{-- Password --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Password (Leave blank to keep current)</label>
                <input type="password" wire:model.defer="password" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Confirm Password</label>
                <input type="password" wire:model.defer="password_confirmation" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow-md transition duration-200">
            Save Profile
        </button>
    </form>
</div>
