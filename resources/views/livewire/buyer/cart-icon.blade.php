<div>
@php
    $cartCount = auth()->user()->carts?->count() ?? 0;
@endphp

@if($cartCount > 0)
    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
        {{ $cartCount }}
    </span>
@endif


</div>
