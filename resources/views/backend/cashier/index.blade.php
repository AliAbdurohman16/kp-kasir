@extends('layouts.backend.main')

@section('title', 'Kasir')

@section('css')
<link href="{{ asset('backend') }}/assets/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" >
@endsection

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">@yield('title')</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">@yield('title')</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="container mt-3">
                    <div class="icon-field">
                        <span class="icon">
                            <iconify-icon icon="f7:search"></iconify-icon>
                        </span>
                        <input type="text" id="search" class="form-control" placeholder="Cari Produk...">
                    </div>
                </div>
                <div class="table-responsive mt-3" style="height: 450px !important; overflow-y: auto;">
                    <table class="table basic-table mb-0">
                        <tbody>
                            @foreach ($products as $product)     
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/products/' . $product->image) }}" width="70px" alt="image" class="flex-shrink-0 me-12 radius-2 me-12">
                                        <div class="flex-grow-1">
                                            <h6 class="text-md mb-0 fw-normal">{{ $product->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="btn btn-success btn-select" data-id="{{ $product->id }}"><iconify-icon icon="ep:select"></iconify-icon></span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- card end -->
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mt-3" style="height: 258px !important; overflow-y: auto;">
                    <input type="hidden" name="cart_id" value="{{ $cart->id ?? '' }}">
                    <table class="table striped-table mb-0" id="cart">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Harga </th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($cart && $cart->CartDetails->count() > 0)
                                @foreach ($cart->CartDetails as $detail)       
                                <tr class="cart-row" data-id="{{ $detail->cart_id }}" data-amount="{{ $detail->amount }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/products/' . $detail->Product->image) }}" width="70px" alt="image" class="flex-shrink-0 me-12 radius-2 me-12">
                                            <div class="flex-grow-1">
                                                <h6 class="text-md mb-0 fw-normal">{{ $detail->Product->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>Rp {{ number_format($detail->amount, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="btn btn-sm btn-danger btn-delete" data-id="{{ $detail->id }}"><iconify-icon icon="ep:close-bold"></iconify-icon></span>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-3" style="border-top: 2px dashed #ccc; padding-top: 10px;">  
                    <div class="table-responsive">
                        <table class="table basic-table mb-0">
                            <tr>
                                <td class="fw-bold">Total</td>
                                <td class="fw-bold" id="total">Rp 0</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Bayar</td>
                                <td><input id="payInput" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kembalian</td>
                                <td class="fw-bold" id="changeMoney">Rp 0</td>
                            </tr>
                        </table>
                    </div>

                    <button class="btn btn-primary w-100 mt-3" id="btn-pay">Bayar</button>
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('backend') }}/assets/plugins/autoNumeric/autoNumeric.min.js"></script>
<script src="{{ asset('backend') }}/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    $(document).ready(function() {
        let totalAmount = 0;

        $(".cart-row").each(function() {
            const amount = $(this).data("amount");
            totalAmount += parseFloat(amount);
        });

        const formattedTotal = totalAmount.toFixed(0);

        $("#total").text('Rp ' + parseInt(formattedTotal).toLocaleString('id-ID'));

        $("#payInput").on("input", function() {
            const payment = $("#payInput").val().replace(/\./g, '').replace('Rp ', '').trim() || 0;
            const total = parseFloat($("#total").text().replace('Rp ', '').replace(/\./g, '').trim());

            const calculate = payment - total;

            const change = calculate.toFixed(0)

            $("#changeMoney").text('Rp ' + parseInt(change).toLocaleString('id-ID'));
        });
    });

    const payInput = new AutoNumeric('#payInput', {
        currencySymbol : 'Rp ',
        decimalCharacter : ',',
        digitGroupSeparator : '.',
        decimalPlaces: 0,
    });

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('.basic-table tbody tr');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const productName = row.querySelector('h6').textContent.toLowerCase();

                row.style.display = productName.includes(searchTerm) ? '' : 'none';
            });
        });
    });

    function calculateTotal(carts) {
        let totalAmount = 0;

        $.each(carts, function(index, cart) {
            totalAmount += parseFloat(cart.amount);
        });

        const formattedTotal = totalAmount.toFixed(0);

        $("#total").text('Rp ' + parseInt(formattedTotal).toLocaleString('id-ID'));
    }

    $(document).on("click", ".btn-select", function () {
        var id = $(this).data("id");

        $.ajax({
            url: "cashier/select/" + id,
            type: 'POST',
            data: {
                "id": id,
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.message) {
                    swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: response.message,
                    });
                } else {
                    var newCartRows = '';

                    $.each(response.cart.cart_details, function(index, cart_detail) {

                        const price = parseFloat(cart_detail.amount);
                        const formattedPrice = price.toFixed(0);

                        newCartRows += `
                            <tr class="cart-row">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/storage/products/${cart_detail.product.image}" width="70px" alt="image" class="flex-shrink-0 me-12 radius-2 me-12">
                                        <div class="flex-grow-1">
                                            <h6 class="text-md mb-0 fw-normal">${cart_detail.product.name}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>${cart_detail.qty}</td>
                                <td>Rp ${parseInt(formattedPrice).toLocaleString('id-ID')}</td>
                                <td class="text-center">
                                    <span class="btn btn-sm btn-danger btn-delete" data-id="${ cart_detail.id }"><iconify-icon icon="ep:close-bold"></iconify-icon></span>
                                </td>
                            </tr>
                        `;
                    });

                    $("#cart tbody").html(newCartRows);
                    payInput.clear();
                    $("#changeMoney").text('Rp 0');
                    $('input[name="cart_id"]').val(response.cart.id);

                    calculateTotal(response.cart.cart_details);
                }
            },
        });
    });

    $(document).on("click", ".btn-delete", function() {
        var id = $(this).data("id");
        Swal.fire({
            title: 'Hapus',
            text: "Apakah anda yakin ingin menghapus?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "cashier/" + id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        var newCartRows = '';
                        
                        $.each(response.cart.cart_details, function(index, cart_detail) {

                            const price = parseFloat(cart_detail.amount);
                            const formattedPrice = price.toFixed(0);

                            newCartRows += `
                                <tr class="cart-row">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="/storage/products/${cart_detail.product.image}" width="70px" alt="image" class="flex-shrink-0 me-12 radius-2 me-12">
                                            <div class="flex-grow-1">
                                                <h6 class="text-md mb-0 fw-normal">${cart_detail.product.name}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${cart_detail.qty}</td>
                                    <td>Rp ${parseInt(formattedPrice).toLocaleString('id-ID')}</td>
                                    <td class="text-center">
                                        <span class="btn btn-sm btn-danger btn-delete" data-id="${ cart_detail.id }"><iconify-icon icon="ep:close-bold"></iconify-icon></span>
                                    </td>
                                </tr>
                            `;
                        });

                        $("#cart tbody").html(newCartRows);
                        payInput.clear();
                        $("#changeMoney").text('Rp 0');
                        $('input[name="cart_id"]').val(response.cart.id);

                        calculateTotal(response.cart.cart_details);
                    },
                });
            }
        })
    });

    $(document).on("click", "#btn-pay", function () {
        const cartId = $('input[name="cart_id"]').val();
        const total = parseFloat($("#total").text().replace('Rp ', '').replace(/\./g, '').trim());
        const money = $("#payInput").val().replace(/\./g, '').replace('Rp ', '').trim() || 0;
        const changeMoney = parseFloat($("#changeMoney").text().replace('Rp ', '').replace(/\./g, '').trim());

        $.ajax({
            url: "cashier",
            type: 'POST',
            data: {
                "cart_id": cartId,
                "total": total,
                "money": money,
                "change_money": changeMoney,
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.message) {
                    swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Cetak Struk',
                                text: "Apakah anda ingin mencetak struk?",
                                icon: 'warning',
                                showCancelButton: true,
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Cetak!',
                                cancelButtonText: 'Batal',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.open(`/transactions/print/${response.transaction_id}`, '_blank');
                                    location.reload();
                                } else {
                                    location.reload();
                                }
                            });
                        }
                    });
                } else {
                    swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: response.error,
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('Response:', xhr.responseText);
            }
        });
    });
</script>
@endsection