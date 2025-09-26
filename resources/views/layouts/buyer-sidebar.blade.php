<div class="bg-gray-800 text-white w-64 min-h-screen p-4 flex flex-col">
    <h2 class="text-2xl font-bold mb-6 text-center">Buyer Panel</h2>

    <nav class="flex-1 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('buyer.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Dashboard
        </a>

        <!-- Products -->
        <a href="{{ route('buyer.product.list') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Products
        </a>

        <!-- Subscriptions -->
        <a href="{{ route('buyer.subscriptions') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Subscriptions
        </a>

        <!-- Cart & Checkout -->
        <a href="{{ route('buyer.cart') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Cart
        </a>
        <a href="{{ route('buyer.checkout') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Checkout
        </a>

        <!-- Orders -->
        <a href="{{ route('buyer.orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Orders
        </a>

        <!-- Invoices -->
        <a href="{{ route('buyer.invoices') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Invoices
        </a>
 

        <!-- Profile -->
        <a href="{{ route('buyer.avater') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
            Profile
        </a>
    </nav>

    <!-- Logout -->
    <form method="POST" action=" #" class="mt-4">
        @csrf
        <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-gray-700">
            Logout
        </button>
    </form>

    <!-- Footer -->
    <div class="mt-auto text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} {{ config('app.name') }}
    </div>
</div>
