<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-8">
        <h1 class="text-3xl font-bold mb-6">Your Invoices</h1>

        @if($invoices->isEmpty())
            <p>No invoices found.</p>
        @else
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Invoice Number</th>
                        <th class="border border-gray-300 px-4 py-2">Date</th>
                        <th class="border border-gray-300 px-4 py-2">Amount</th>
                        <th class="border border-gray-300 px-4 py-2">Download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $invoice->invoice_number }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $invoice->created_at->format('d M Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2">${{ number_format($invoice->amount, 2) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="{{ route('buyer.invoice.download', $invoice->id) }}" class="inline-block bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Download PDF</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
