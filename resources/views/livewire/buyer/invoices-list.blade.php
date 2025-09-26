<div class="max-w-7xl mx-auto py-10 px-6">
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800">📄 My Invoices</h2>
        <span class="text-gray-500 mt-2 md:mt-0">Total Invoices: {{ $invoices->count() }}</span>
    </div>

    @if($invoices->isEmpty())
        {{-- Empty State --}}
        <div class="text-center py-16 bg-white shadow rounded-lg border border-gray-100">
            <svg class="mx-auto w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 3h18v18H3V3z" />
            </svg>
            <p class="text-gray-500 text-lg font-medium">You have no invoices generated yet.</p>
            <a href="/" 
               class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
               🛍️ Continue Shopping
            </a>
        </div>
    @else
        {{-- Invoices Table --}}
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-medium">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">${{ number_format($invoice->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('invoice.download', $invoice->id) }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                                    Download
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
