<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow mt-8 text-center">
        <h1 class="text-3xl font-bold mb-4">Payment Canceled</h1>
        <p>Your payment was canceled. You can try again anytime.</p>
        <a href="{{ route('buyer.cart') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">Go Back to Cart</a>
    </div>
</x-app-layout>
