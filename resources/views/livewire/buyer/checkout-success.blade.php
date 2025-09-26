<div class="max-w-4xl mx-auto p-10 bg-white shadow-2xl rounded-2xl border border-gray-100 mt-10">
    
    {{-- ✅ Header / Logo --}}
    <div class="flex justify-between items-center border-b pb-6 mb-6">
        <h2 class="text-2xl font-extrabold text-gray-800">🧾 Invoice Confirmation</h2>
        <span class="text-sm text-gray-500">Issued: {{ now()->format('M d, Y') }}</span>
    </div>

    {{-- ✅ Success Alert --}}
    @if(session()->has('success'))
        <div class="flex items-center bg-green-50 text-green-800 p-4 rounded-lg mb-8 shadow-sm">
            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ✅ Invoice Details --}}
    <div class="bg-gray-50 p-8 rounded-xl shadow-inner mb-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Invoice Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <p class="text-gray-600">Invoice Number: 
                <span class="font-bold text-gray-900">{{ $invoice->invoice_number }}</span>
            </p>
            <p class="text-gray-600">Total Paid: 
                <span class="font-bold text-green-600">${{ number_format($invoice->amount, 2) }}</span>
            </p>
            <p class="text-gray-600">Payment Status: 
                <span class="px-3 py-1 rounded-lg bg-green-100 text-green-700 font-semibold text-sm">Paid</span>
            </p>
            <p class="text-gray-600">Payment Method: 
                <span class="font-medium text-gray-800">Stripe</span>
            </p>
        </div>
    </div>

    
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-gray-900">🎉 Thank You for Your Purchase!</h1>
        <p class="text-gray-600 mt-2">Your order has been processed successfully. A copy of your invoice has been sent to your email.</p>
    </div>

    
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('buyer.dashboard') }}" 
           class="px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 font-medium rounded-xl shadow hover:from-gray-200 hover:to-gray-300 transition">
           ⬅ Back to Dashboard
        </a>
        <a href="{{ route('invoice.download', $invoice->id) }}" 
           class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow hover:from-blue-700 hover:to-indigo-700 transition">
            Download Invoice PDF
        </a>
        <a href="/" 
           class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow hover:from-green-700 hover:to-emerald-700 transition">
           🛍 Continue Shopping
        </a>
    </div>
</div>
