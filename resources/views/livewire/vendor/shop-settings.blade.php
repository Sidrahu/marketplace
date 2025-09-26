<div class="max-w-6xl mx-auto py-12 px-6">

    {{-- 🔹 Header --}}
    <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">⚙️ Shop Settings</h2>

    {{-- 🔹 Success Message --}}
    @if(session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🔹 Shop Selector --}}
    <div class="mb-6">
        <label class="block font-semibold text-gray-700 mb-2">Select Shop</label>
        <select wire:model="selectedShopId" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            @foreach($shops as $shopItem)
                <option value="{{ $shopItem->id }}">{{ $shopItem->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- 🔹 Settings Form --}}
    <form wire:submit.prevent="save" class="space-y-6 bg-gray-50 p-6 rounded-2xl shadow-lg">

        <div>
            <label class="block font-medium text-gray-700 mb-1">Shop Name</label>
            <input type="text" wire:model.defer="name" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Description</label>
            <textarea wire:model.defer="description" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" wire:model.defer="phone" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="email" wire:model.defer="email" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Currency</label>
                <input type="text" wire:model.defer="currency" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Address</label>
            <input type="text" wire:model.defer="address" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Opening Hours</label>
            <textarea wire:model.defer="opening_hours" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-1">Shop Logo</label>
            <div class="flex items-center gap-4 mb-2">
                @if ($existingLogo && !$logo)
                    <img src="{{ asset('storage/' . $existingLogo) }}" class="w-20 h-20 rounded-full border shadow-sm">
                @elseif ($logo)
                    <img src="{{ $logo->temporaryUrl() }}" class="w-20 h-20 rounded-full border shadow-sm">
                @endif
                <input type="file" wire:model="logo" class="border border-gray-300 px-3 py-2 rounded-lg shadow-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-medium text-gray-700 mb-1">Facebook</label>
                <input type="text" wire:model.defer="facebook" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Instagram</label>
                <input type="text" wire:model.defer="instagram" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Twitter</label>
                <input type="text" wire:model.defer="twitter" class="w-full border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 transition">
            </div>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md font-semibold transition">Save Settings</button>
    </form>

    {{-- 🔹 Shops Table --}}
    <div class="mt-12">
        <h3 class="text-2xl font-bold mb-6">All Shops Details</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow-lg divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Logo</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Name</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Email</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Phone</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Address</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Currency</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Opening Hours</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Facebook</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Instagram</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold text-sm">Twitter</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($allShops as $shop)
                        @php
                            $social = $shop->social_links ? json_decode($shop->social_links, true) : [];
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                @if($shop->logo)
                                    <img src="{{ asset('storage/' . $shop->logo) }}" class="w-12 h-12 rounded-full border shadow-sm">
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-800 font-medium">{{ $shop->name }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $shop->email ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $shop->phone ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $shop->address ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $shop->currency ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $shop->opening_hours ?? '-' }}</td>
                            <td class="px-4 py-3 text-blue-600">
                                @if(!empty($social['facebook']))
                                    <a href="{{ $social['facebook'] }}" target="_blank" class="hover:underline">{{ $social['facebook'] }}</a>
                                @else - @endif
                            </td>
                            <td class="px-4 py-3 text-pink-600">
                                @if(!empty($social['instagram']))
                                    <a href="{{ $social['instagram'] }}" target="_blank" class="hover:underline">{{ $social['instagram'] }}</a>
                                @else - @endif
                            </td>
                            <td class="px-4 py-3 text-blue-400">
                                @if(!empty($social['twitter']))
                                    <a href="{{ $social['twitter'] }}" target="_blank" class="hover:underline">{{ $social['twitter'] }}</a>
                                @else - @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
