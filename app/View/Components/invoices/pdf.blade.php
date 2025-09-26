<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            line-height: 24px;
            font-size: 14px;
            color: #555;
        }
        .heading { font-size: 24px; margin-bottom: 20px; }
        .details { margin-bottom: 15px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="heading">Invoice: {{ $invoice->invoice_number }}</div>
        <div class="details">
            <strong>Date:</strong> {{ $invoice->created_at->format('d M Y') }}<br>
            <strong>Status:</strong> {{ ucfirst($invoice->status) }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->details['products'] ?? [] as $product)
                <tr>
                    <td>{{ $product['name'] }} (x{{ $product['qty'] }})</td>
                    <td>${{ number_format($product['price'] * $product['qty'], 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="total">Total</td>
                    <td class="total">${{ number_format($invoice->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p>Thank you for your purchase!</p>
    </div>
</body>
</html>
