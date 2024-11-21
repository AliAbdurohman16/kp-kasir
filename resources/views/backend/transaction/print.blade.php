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
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
        }

        .receipt {
            width: 280px;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header p {
            margin: 0;
        }

        .details,
        .items {
            margin-bottom: 1px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }

        .details {
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        .details p {
            display: flex;
            justify-content: space-between;
            margin: 0;
        }

        .bill {
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            text-align: center;
        }

        .items ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .items li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .mb-3 {
            margin-bottom: 15px !important;
        }


        .total {
            margin-top: 10px;
            font-size: 12px;
            text-align: left;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
        }

        .total table {
            width: 100%;
            border-collapse: collapse;
        }

        .total table td {
            padding: 5px 0;
        }

        .total table td:nth-child(2) {
            text-align: center;
            width: 10%;
        }

        .total table td:nth-child(3) {
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
        }

        .footer p {
            margin: 0;
        }

        @media print {
            .receipt {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <p>Sinar Utama Furniture</p>
            <p>Jl. Contoh Alamat No. 123</p>
            <p>Telp: (021) 12345678</p>
            <p>{{ date('d-m-Y H:i:s') }}</p>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td>Tgl & Jam</td>
                    <td>:</td>
                    <td>{{ date('d/m/Y H:i', strtotime($transaction->created_at)) }}</td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>:</td>
                    <td>{{ Auth::user()->name }}</td>
                </tr>
            </table>
        </div>

        <div class="bill">
            <p>TAGIHAN</p>
        </div>

        <div class="items">
            <ul>
                @foreach ($transaction->Cart->CartDetails as $detail)
                <li>{{ $detail->Product->name }}</li>
                <li class="mb-3">
                    <span>{{ $detail->qty }} x {{ number_format($detail->Product->price, 0, ',', '.') }}</span>
                    <span>{{ number_format($detail->amount, 0, ',', '.') }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="total">
            <table>
                <tr>
                    <td>Total</td>
                    <td>:</td>
                    <td style="text-align: right;">{{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Uang Tunai</td>
                    <td>:</td>
                    <td style="text-align: right;">{{ number_format($transaction->money, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kembalian</td>
                    <td>:</td>
                    <td style="text-align: right;">{{ number_format($transaction->change_money, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>TERIMA KASIH</p>
            <p>ATAS KUNJUNGAN ANDA!</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
