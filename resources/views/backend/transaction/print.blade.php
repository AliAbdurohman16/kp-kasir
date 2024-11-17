<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @page {
            size: 80mm 200mm;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 10px;
        }

        .receipt {
            width: 280px;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
            border: 1px solid #ccc;
            font-size: 12px;
            text-align: center;
        }

        .header {
            font-size: 10px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
        }

        .details {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .details p {
            margin: 5px 0;
        }

        .items {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
        }

        .item-title {
            display: flex;
            padding: 5px 0;
            font-weight: 800;
        } 
        
        .item-product {
            display: flex;
            padding: 5px 0;
        }

        .item-title p, .item-product p {
            margin: 0;
            padding: 0;
            width: 33%;
        }

        .item-title p:nth-child(2), .item-product p:nth-child(2) {
            text-align: center;
        }

        .item-title p:last-child, .item-product p:last-child {
            text-align: right;
        }

        .total {
            /* display: flex;
            flex-direction: column; */
            font-weight: bold;
            border-bottom: 1px dashed #000;
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
        }

        .footer .thank-you {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .footer p {
            margin: 2px 0;
        }

        @media print {
            .receipt {
                width: 280px;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>Sinar Utama Furniture</h1>
            <p>Jl. Contoh Alamat No. 123</p>
            <p>Telp: (021) 12345678</p>
            <p>{{ date('d-m-Y H:i:s') }}</p>
        </div>

        <div class="details">
            <p><strong>Kasir:</strong> {{ Auth::user()->name }}</p>
        </div>

        <div class="items">
            <div class="item-title">
                <p>Produk</p>
                <p>Qty</p>
                <p>Harga</p>
            </div>
            @foreach ($transaction->Cart->CartDetails as $detail)
                <div class="item-product">
                    <p>{{ $detail->Product->name }}</p>
                    <p>{{ $detail->qty }}</p>
                    <p>Rp {{ number_format($detail->amount, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>

        <div class="total">
            <p>Total: Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
            <p>Uang Tunai: Rp {{ number_format($transaction->money, 0, ',', '.') }}</p>
            <p>Kembalian: Rp {{ number_format($transaction->change_money, 0, ',', '.') }}</p>
        </div>

        <div class="footer">
            <div class="thank-you">Terima Kasih Telah Belanja!</div>
            <p>Kunjungi Kami Lagi!</p>
        </div>
    </div>

    <script>
        window.print(); // Automatically trigger print when the page is loaded
    </script>
</body>
</html>
