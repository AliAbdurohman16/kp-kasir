@extends('layouts.backend.main')

@section('title', 'Transaksi')

@section('css')
<link href="{{ asset('backend') }}/assets/css/lib/dataTables.min.css" rel="stylesheet" >
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

<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table id="transaction" class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Uang</th>
                        <th>Kembalian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->translatedFormat('d/m/Y H:i') }}</td>
                        <td>
                            @foreach ($transaction->Cart->CartDetails as $detail)
                                {{ $detail->Product->name }} x {{ $detail->qty }} <br>
                            @endforeach
                        </td>
                        <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaction->money, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($transaction->change_money, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('transactions.print', $transaction->id) }}" target="_blank" class="btn btn-primary"><iconify-icon icon="material-symbols:print-outline"></iconify-icon></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('backend') }}/assets/js/lib/dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transaction').DataTable();
    });
</script>
@endsection