@extends('layouts.backend.main')

@section('title', 'Edit Diskon')

@section('css')
<link href="{{ asset('backend') }}/assets/plugins/flatpickr/flatpickr.min.css" rel="stylesheet" >
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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body mt-3">
                <form action="{{ route('discounts.update', $discount) }}" class="row gy-3 needs-validation" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-sm-12">
                        <label class="form-label">Nama Diskon</label>
                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $discount->name }}" placeholder="Nama Diskon">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Persen</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('percentage') is-invalid @enderror" name="percentage" value="{{ $discount->percentage }}" placeholder="Persen">
                            <span class="input-group-text">%</span>
                            @error('percentage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Tanggal Mulai</label>
                        <div class="form-group">
                            <input type="text" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" placeholder="Tanggal Mulai">
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Tanggal Selesai</label>
                        <div class="form-group">
                            <input type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" placeholder="Tanggal Selesai">
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Status</label>
                        <div class="form-group">
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Aktif" @selected($discount->status == 'Aktif')>Aktif</option>
                                <option value="Tidak Aktif" @selected($discount->status == 'Tidak Aktif')>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-3 mt-3">
                        <button class="btn btn-primary-600 w-100" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>      
</div>
@endsection

@section('js')
<script src="{{ asset('backend') }}/assets/plugins/flatpickr/flatpickr.min.js"></script>
<script>
    flatpickr("#start_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        placeholder: "yyyy-mm-dd --:--",
        time_24hr: true,
        defaultDate: "{{ date('Y-m-d H:i', strtotime($discount->start_date)) }}",
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            }
        }
    });

    flatpickr("#end_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        placeholder: "yyyy-mm-dd --:--",
        time_24hr: true,
        defaultDate: "{{ date('Y-m-d H:i', strtotime($discount->start_date)) }}",
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            }
        }
    });
</script>
@endsection