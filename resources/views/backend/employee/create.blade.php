@extends('layouts.backend.main')

@section('title', 'Tambah Data Pegawai')

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
                <form action="{{ route('employees.store') }}" class="row gy-3 needs-validation" method="post">
                    @csrf
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>                        
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group" style="position: relative;">
                            <label class="form-label">Kata Sandi</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata Sandi" style="padding-right: 40px;">
                            <span class="toggle-password" onclick="togglePassword()" style="position: absolute; right: 15px; top: 48px; cursor: pointer;">
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
                            <label class="form-label">Konfirmasi Kata Sandi</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" style="padding-right: 40px;">
                            <span class="toggle-password" onclick="togglePasswordConfirm()" style="position: absolute; right: 15px; top: 48px; cursor: pointer;">
                                <iconify-icon icon="solar:eye-outline" id="eye-icon-confirm"></iconify-icon>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Toko</label>
                        <div class="form-group">
                            <select class="form-control @error('branch_id') is-invalid @enderror" name="branch_id">
                                <option value="" selected disabled>Pilih Toko</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ ucwords($role->name) }}</option>
                                @endforeach
                            </select>
                            @error('role')
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
<script>
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
        var passwordField = document.getElementById("password_confirmation");
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