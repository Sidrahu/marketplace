<div class="max-w-7xl mx-auto py-12 px-6">

    {{-- Heading and Create Button --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <h2 class="text-3xl font-bold text-gray-800">📦 My Products</h2>
        <a href="{{ route('vendor.products.create') }}"
           class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg transition-all duration-300">
            + Add Product
        </a>
    </div>

    {{-- 🖼️ Card View --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @foreach($products as $product)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all flex flex-col h-full">

                {{-- Product Image --}}
                @if ($product->images->count())
                    <div class="relative rounded-t-2xl overflow-hidden h-48 flex items-center justify-center bg-gray-100">
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                             class="w-full h-full object-cover" />
                        @if($product->status)
                            <span class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full font-semibold">Active</span>
                        @else
                            <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full font-semibold">Inactive</span>
                        @endif
                    </div>
                @endif

                {{-- Card Content --}}
                <div class="p-5 flex flex-col flex-1">

                    {{-- Shop Info --}}
                    <div class="flex items-center gap-3 mb-3">
                        @if($product->shop && $product->shop->logo)
                            <img src="{{ asset('storage/' . $product->shop->logo) }}"
                                 alt="Shop Logo"
                                 class="w-10 h-10 rounded-full border object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full border bg-gray-200 flex items-center justify-center text-gray-500">🏪</div>
                        @endif
                        <span class="font-semibold text-gray-900">{{ $product->shop->name ?? 'No Shop' }}</span>
                    </div>

                    {{-- Product Name & Description --}}
                    <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3 line-clamp-3">{{ $product->description }}</p>

                    {{-- Price & Stock --}}
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-blue-600 font-bold text-lg">${{ $product->price }}</span>
                        @if($product->quantity > 0)
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">{{ $product->quantity }} in stock</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Out of stock</span>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-2 mb-3">
                        <a href="{{ route('vendor.products.edit', $product->id) }}"
                           class="flex-1 px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 font-medium text-sm text-center transition">Edit</a>
                        <button wire:click="delete({{ $product->id }})"
                                onclick="return confirm('Are you sure?')"
                                class="flex-1 px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 font-medium text-sm transition">Delete</button>
                    </div>

                    {{-- Expanded Details Section --}}
                    <div class="mt-auto pt-3 border-t border-gray-200 text-sm space-y-1">
                        <div>
                            <span class="font-semibold">Status:</span>
                            @if($product->status)
                                <span class="text-green-600 font-medium">Active</span>
                            @else
                                <span class="text-red-600 font-medium">Inactive</span>
                            @endif
                        </div>
                        <div>
                            <span class="font-semibold">SKU / ID:</span> #{{ $product->id }}
                        </div>
                        <div>
                            <span class="font-semibold">Full Description:</span> {{ $product->description }}
                        </div>
                        <div class="flex gap-2 items-center">
                            <span class="font-semibold">All Images:</span>
                            <div class="flex gap-1 overflow-x-auto">
                                @foreach($product->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         class="w-10 h-10 object-cover rounded border" />
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
