<div class="max-w-3xl mx-auto py-12 px-6 bg-gray-50 rounded-2xl shadow-lg">

    {{-- Header --}}
    <div class="flex items-center gap-2 mb-8">
        <i class="fas fa-user-circle text-blue-600 text-2xl"></i>
        <h2 class="text-2xl font-bold text-gray-800">Profile & Shop</h2>
    </div>

    {{-- Success Message --}}
    @if(session()->has('success'))
        <div class="flex items-center gap-2 bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow mb-6">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Personal Info Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-6 rounded-xl shadow-sm">
            <div>
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-user text-gray-400"></i> Name</label>
                <input type="text" wire:model.defer="name" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-envelope text-gray-400"></i> Email</label>
                <input type="email" wire:model.defer="email" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-phone-alt text-gray-400"></i> Phone</label>
                <input type="text" wire:model.defer="phone" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-map-marker-alt text-gray-400"></i> Address</label>
                <input type="text" wire:model.defer="address" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
        </div>

        {{-- Profile Photo --}}
        <div class="flex items-center gap-4 bg-white p-6 rounded-xl shadow-sm">
            <div>
                @if ($existingProfilePhoto && !$profile_photo)
                    <img src="{{ asset('storage/' . $existingProfilePhoto) }}" class="w-20 h-20 rounded-full border shadow-sm">
                @elseif ($profile_photo)
                    <img src="{{ $profile_photo->temporaryUrl() }}" class="w-20 h-20 rounded-full border shadow-sm">
                @endif
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-image text-gray-400"></i> Profile Photo</label>
                <input type="file" wire:model="profile_photo" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm">
            </div>
        </div>

        <hr class="my-4 border-gray-300">

        {{-- Shop Details Header --}}
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-store text-green-600"></i>
            <h3 class="text-xl font-semibold text-gray-800">Shop Details</h3>
        </div>

        {{-- Shop Info Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-6 rounded-xl shadow-sm">
            <div>
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-store text-gray-400"></i> Shop Name</label>
                <input type="text" wire:model.defer="shop_name" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-map-marker-alt text-gray-400"></i> Shop Address</label>
                <input type="text" wire:model.defer="shop_address" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 transition">
            </div>
            <div class="col-span-2">
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-align-left text-gray-400"></i> Shop Description</label>
                <textarea wire:model.defer="shop_description" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-green-400 transition"></textarea>
            </div>
        </div>

        {{-- Shop Logo --}}
        <div class="flex items-center gap-4 bg-white p-6 rounded-xl shadow-sm">
            <div>
                @if ($existingShopLogo && !$shop_logo)
                    <img src="{{ asset('storage/' . $existingShopLogo) }}" class="w-20 h-20 rounded-full border shadow-sm">
                @elseif ($shop_logo)
                    <img src="{{ $shop_logo->temporaryUrl() }}" class="w-20 h-20 rounded-full border shadow-sm">
                @endif
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700 mb-1"><i class="fas fa-image text-gray-400"></i> Shop Logo</label>
                <input type="file" wire:model="shop_logo" class="w-full border border-gray-300 px-3 py-2 rounded-lg shadow-sm">
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-md font-semibold transition duration-200 flex items-center gap-2">
            <i class="fas fa-save"></i> Save Profile
        </button>

    </form>
</div>
