<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 28px;
            color: #111827;
        }
        .header .status {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status.completed { background: #d1fae5; color: #065f46; }
        .status.pending { background: #fef3c7; color: #92400e; }
        .status.cancelled { background: #fee2e2; color: #991b1b; }

        .details {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .details div {
            margin-bottom: 10px;
        }
        .details strong {
            display: inline-block;
            width: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table thead tr {
            background-color: #f3f4f6;
        }
        table th, table td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        table th {
            color: #6b7280;
            font-weight: 600;
            font-size: 14px;
        }
        table tbody tr:hover {
            background-color: #f9fafb;
        }

        .total-row td {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #e5e7eb;
        }

        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        {{-- Header --}}
        <div class="header">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <span class="status {{ strtolower($invoice->status) }}">{{ ucfirst($invoice->status) }}</span>
        </div>

        {{-- Details --}}
        <div class="details">
            <div><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</div>
            <div><strong>Customer:</strong> {{ $invoice->buyer->name ?? 'Customer' }}</div>
            <div><strong>Email:</strong> {{ $invoice->buyer->email ?? '-' }}</div>
        </div>

        {{-- Products Table --}}
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->details['products'] ?? [] as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['qty'] }}</td>
                    <td>${{ number_format($product['price'], 2) }}</td>
                    <td>${{ number_format($product['price'] * $product['qty'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align:right;">Total</td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="footer">
            Thank you for your purchase!<br>
            &copy; {{ date('Y') }} Marketplace website
        </div>
    </div>
</body>
</html>
