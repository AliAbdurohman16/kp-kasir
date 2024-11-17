@extends('layouts.backend.main')

@section('title', 'Kata Sandi')

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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body mt-3">
                <form action="{{ route('password-change.store') }}" class="row gy-3 needs-validation" method="post" novalidate>
                    @csrf
                    <div class="col-sm-12">
                        <div class="form-group" style="position: relative;">
                            <label class="form-label">Kata Sandi Lama</label>
                            <input id="password-old" type="password" class="form-control @error('password_old') is-invalid @enderror" name="password_old" placeholder="Kata Sandi Lama" style="padding-right: 40px;">
                            <span class="toggle-password" onclick="togglePasswordOld()" style="position: absolute; right: 15px; top: 40px; cursor: pointer;">
                                <iconify-icon icon="solar:eye-outline" id="eye-icon-old"></iconify-icon>
                            </span>
                            @error('password_old')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>                        
                    <div class="col-sm-12">
                        <div class="form-group" style="position: relative;">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata Sandi Baru" style="padding-right: 40px;">
                            <span class="toggle-password" onclick="togglePassword()" style="position: absolute; right: 15px; top: 40px; cursor: pointer;">
                                <iconify-icon icon="solar:eye-outline" id="eye-icon"></iconify-icon>
                            </span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group" style="position: relative;">
                            <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input id="password-confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Kata Sandi Baru" style="padding-right: 40px;">
                            <span class="toggle-password" onclick="togglePasswordConfirm()" style="position: absolute; right: 15px; top: 40px; cursor: pointer;">
                                <iconify-icon icon="solar:eye-outline" id="eye-icon-confirm"></iconify-icon>
                            </span>
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
<script src="{{ asset('backend') }}/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
    @if (Session::has('success'))
    swal.fire({
        icon: "success",
        title: "Berhasil",
        text: "{{ Session::get('success') }}",
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
    @endif

    function togglePasswordOld() {
    var passwordField = document.getElementById("password-old");
    var eyeIcon = document.getElementById("eye-icon-old");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.setAttribute("icon", "mdi:eye-off-outline");
    } else {
        passwordField.type = "password";
        eyeIcon.setAttribute("icon", "solar:eye-outline");
    }
}

function togglePassword() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.setAttribute("icon", "mdi:eye-off-outline");
    } else {
        passwordField.type = "password";
        eyeIcon.setAttribute("icon", "solar:eye-outline");
    }
}

function togglePasswordConfirm() {
    var passwordField = document.getElementById("password-confirmation");
    var eyeIcon = document.getElementById("eye-icon-confirm");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.setAttribute("icon", "mdi:eye-off-outline");
    } else {
        passwordField.type = "password";
        eyeIcon.setAttribute("icon", "solar:eye-outline");
    }
}


</script>
@endsection