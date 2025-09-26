<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
        🛒 <span>Subscribe to {{ $product->name }}</span>
    </h2>

    {{-- ✅ Product Image --}}
    @if ($product->images && $product->images->count())
        <img src="{{ asset('storage/' . $product->images[0]->image_path) }}" 
             alt="{{ $product->name }}" 
             class="w-full h-64 object-cover rounded mb-4">
    @endif

    {{-- ✅ Description --}}
    <p class="mb-2 text-gray-800">{{ $product->description }}</p>

    {{-- ✅ Price --}}
    <p class="text-gray-700 mb-4 font-semibold">Price: ${{ $product->price }}</p>

    {{-- ✅ Subscribe / Unsubscribe Buttons --}}
    @if ($this->isSubscribed())
        <button wire:click="unsubscribe" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
            Unsubscribe
        </button>
    @else
        <button wire:click="subscribe" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Subscribe Now
        </button>
    @endif

    {{-- ✅ Flash Messages --}}
    @if (session()->has('success'))
        <div class="text-green-500 mt-4 font-medium">{{ session('success') }}</div>
    @endif
    @if (session()->has('info'))
        <div class="text-blue-500 mt-4 font-medium">{{ session('info') }}</div>
    @endif
</div>
