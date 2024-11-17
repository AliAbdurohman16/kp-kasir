@extends('layouts.backend.main')

@section('title', 'Log Aktivitas')

@section('css')
<link href="{{ asset('backend') }}/assets/css/lib/dataTables.min.css" rel="stylesheet">
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
            <table class="table bordered-table mb-0" id="log-activity">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Aktivitas</th>
                        <th>Tanggal & Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        @if ($activity->causer_id)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    </span><span class="package-name">
                                        {{ optional($activity->causer)->name }}
                                    </span>
                                </td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ date('d-m-Y H:i:s', strtotime($activity->created_at)) }}</td>
                            </tr>
                        @elseif($activity->causer_id)
                            <tr>
                                <td colspan="4">Akun sudah dihapus.</td>
                            </tr>
                        @endif
                    @empty
                    @endforelse 
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
        $('#log-activity').DataTable();
    });
</script>
@endsection