@extends('layouts.auth.app')

@section('title', 'Masuk')

@section('content')
<section class="auth">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="container mt-5 mb-5">
                    <div class="mb-5 text-center">
                        <h4>MASUK</h4>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mage:email"></iconify-icon>
                            </span>
                            <input type="email" class="form-control h-56-px bg-neutral-50 radius-12 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="position-relative">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y">
                                    <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                </span>
                                <input type="password" class="form-control h-56-px bg-neutral-50 radius-12 @error('password') is-invalid @enderror" name="password" id="password" placeholder="Kata Sandi">
                                <span class="toggle-password" onclick="togglePassword()" style="position: absolute; right: 15px; top: 20px; cursor: pointer;">
                                    <iconify-icon icon="solar:eye-outline" id="eye-icon"></iconify-icon>
                                </span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#password"></span> --}}
                        </div>
        
                        <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32"> Masuk</button>
        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
</script>
@endsection
