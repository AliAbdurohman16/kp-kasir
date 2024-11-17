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
                                <input type="password" class="form-control h-56-px bg-neutral-50 radius-12 @error('password') is-invalid @enderror" name="password" id="your-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                        </div>
        
                        <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32"> Masuk</button>
        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
