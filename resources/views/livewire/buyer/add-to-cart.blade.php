<div>
    <input type="number" min="1" wire:model="quantity" class="w-16 border rounded px-2" />
    <button wire:click="addToCart" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Add to Cart
    </button>

    @if(session()->has('success'))
        <div class="text-green-600 mt-2">{{ session('success') }}</div>
    @endif

    @if(session()->has('error'))
        <div class="text-red-600 mt-2">{{ session('error') }}</div>
    @endif
</div>
