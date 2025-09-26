<div class="max-w-7xl mx-auto py-10 px-6">
    {{-- 💼 Dashboard Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Vendor Dashboard</h1>
            <p class="text-sm text-gray-500">Manage your shops, products, and sales.</p>
        </div>
        <button wire:click="toggleForm"
            class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            ➕ Create Shop
        </button>
    </div>

    {{-- ✅ Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- 📊 Stats Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-5 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Total Shops</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $shops->count() }}</h2>
        </div>
        <div class="bg-white p-5 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Products</p>
            <h2 class="text-2xl font-bold text-gray-800">{{ $shops->flatMap->products->count() }}</h2>
        </div>
        <div class="bg-white p-5 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Orders</p>
            <h2 class="text-2xl font-bold text-gray-800">120</h2>
        </div>
        <div class="bg-white p-5 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Revenue</p>
            <h2 class="text-2xl font-bold text-green-600">$5,430</h2>
        </div>
    </div>

    {{-- ✏️ Create / Edit Shop Form --}}
    @if($showForm)
    <div class="bg-white shadow rounded-lg p-6 mb-10">
        <h2 class="text-xl font-bold text-gray-700 mb-4">
            {{ $shop_id ? '✏️ Edit Shop' : '➕ Create New Shop' }}
        </h2>

        <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block font-medium text-gray-600">Shop Name</label>
                <input type="text" wire:model.defer="name" class="mt-1 w-full border px-3 py-2 rounded">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block font-medium text-gray-600">Description</label>
                <textarea wire:model.defer="description" rows="3" class="mt-1 w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div>
                <label class="block font-medium text-gray-600">Shop Logo</label>
                @if ($existingLogo && !$logo)
                    <img src="{{ asset('storage/' . $existingLogo) }}" class="w-20 h-20 rounded-full mb-2">
                @elseif ($logo)
                    <img src="{{ $logo->temporaryUrl() }}" class="w-20 h-20 rounded-full mb-2">
                @endif
                <input type="file" wire:model="logo" class="w-full border px-2 py-1 rounded">
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Save</button>
                <button type="button" wire:click="resetForm" class="text-sm text-gray-500">Cancel</button>
            </div>
        </form>
    </div>
    @endif

    {{-- 🏪 Shops Listing --}}
    @if ($shops && $shops->count())
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">🗂 Your Shops</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($shops as $shop)
                    <div class="bg-white shadow border rounded-lg p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ $shop->logo ? asset('storage/' . $shop->logo) : 'https://via.placeholder.com/50' }}" 
                                 class="w-12 h-12 rounded-full">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $shop->name }}</p>
                                <p class="text-xs text-gray-500">{{ $shop->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mb-3">{{ $shop->description ?? 'No description' }}</p>
                        <div class="flex gap-4 mb-4">
                            <button wire:click="edit({{ $shop->id }})" class="text-sm text-blue-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $shop->id }})" class="text-sm text-red-600 hover:underline">Delete</button>
                        </div>
                        {{-- Products --}}
                        @if($shop->products->count())
                            <div class="border-t pt-3">
                                <h4 class="font-semibold text-gray-800 mb-2">Products:</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($shop->products as $product)
                                        <div class="bg-gray-50 p-3 rounded-lg shadow-sm">
                                            <p class="font-medium">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-600">${{ $product->price }}</p>
                                            <p class="text-xs {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $product->quantity > 0 ? $product->quantity.' in stock' : 'Out of stock' }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-gray-500">No products yet for this shop.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500">You have no shops yet. Click "Create Shop" to get started!</p>
    @endif
</div>
