<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-10">
        <div class="max-w-3xl w-full bg-white rounded-2xl shadow-xl p-10 text-center border border-gray-100">

            <!-- Success Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center shadow-inner">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Title & Message -->
            <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Payment Successful 🎉</h1>
            <p class="text-lg text-gray-600 mb-10">Thank you for your purchase! Your order is being processed and you’ll receive updates shortly.</p>

            <!-- Invoice Details -->
            @if(isset($recentInvoice))
                <div class="bg-gray-50 border rounded-xl p-6 mb-10 text-left shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-700 mb-3">🧾 Invoice Details</h2>
                    <p class="text-gray-600 mb-2">Invoice Number: 
                        <span class="font-medium text-gray-800">{{ $recentInvoice->invoice_number }}</span>
                    </p>

                    <div class="mt-5 flex flex-wrap gap-4">
                        <a href="{{ route('buyer.invoice.download', $recentInvoice->id) }}" 
                           class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow transition w-full sm:w-auto text-center">
                            📄 Download Invoice
                        </a>
                        <a href="{{ route('buyer.invoices.index') }}"  
                           class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow transition w-full sm:w-auto text-center">
                            📚 View All Invoices
                        </a>
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('buyer.dashboard') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow hover:from-blue-700 hover:to-indigo-700 transition w-full sm:w-auto">
                   🏠 Go to Dashboard
                </a>
                <a href="/" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl shadow hover:bg-gray-200 transition w-full sm:w-auto">
                   🛍️ Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
