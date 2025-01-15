<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR | Sinar Utama Furniture</title>
    <link rel="icon" type="image/png" href="{{ asset('backend') }}/assets/images/logo-toko.png" sizes="16x16">
    <style>
        @page {
            size: 810px 460px;
            margin: 5px;
            background-color: rgb(211, 211, 211);
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 800px;
            height: 450px;
            background-image: url({{ asset('default/background.avif') }});
            background-size: cover;
            background-position: center;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .card-header {
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .card-body { */
            width: 100%;
            height: 100%;
            margin-top: 80px;
            margin-left: 40px;
        }

        .product-image {
            max-width: 400px;
            max-height: 300px;
            border-radius: 10px;
            object-fit: cover;
        }

        .product-details {
            margin-top: 15px;
            font-size: 18px;
        }

        .product-details h1 {
            margin: 0;
            font-size: 34px;
            font-weight: bold;
        }

        .product-details p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 0 0;
            color: #252424;
        }

        .qr-code {
            position: absolute;
            top: 280px;
            right: 20px;
        }
    </style>
</head>
<body onload="window.print();">
    <div class="card">
        <div class="card-header">
            <img src="{{ asset('backend') }}/assets/images/logo-toko.png" alt="Logo" class="logo">
        </div>
        <div class="card-body">
            <img src="{{ asset('storage/products/' . $product->image) }}" alt="Produk" class="product-image">
            <div class="product-details">
                <h1>{{ $product->name }}</h1>
                <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            <div class="qr-code">
                {!! QrCode::size(150)->generate($product->id) !!}
            </div>
        </div>
    </div>
</body>
</html>
