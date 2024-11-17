@extends('layouts.auth.app')

@section('title', 'Lupa Kata Sandi')

@section('content')
<div class="login-page" style="background-image: url({{ asset('backend') }}/assets/images/mekkah.jpeg);">
    <div class="login-from-wrap">
        <form method="POST" action="{{ route('password.email') }}" class="login-from">
            @csrf
            <h1 class="site-title">
                <a href="#">
                    <img src="{{ asset('backend') }}/assets/images/logo.png" alt="logo">
                </a>
            </h1>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="validate @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn button-primary text-dark w-100">Kirim</button>
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}" class="for-pass">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection