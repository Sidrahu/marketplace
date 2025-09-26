<div class="relative cursor-pointer" wire:click="goToCheckout">
    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="7" cy="21" r="1" />
        <circle cx="17" cy="21" r="1" />
    </svg>
    @if($cartCount > 0)
    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
        {{ $cartCount }}
    </span>
    @endif
</div>
