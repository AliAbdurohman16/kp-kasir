@extends('layouts.auth.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="login-page" style="background-image: url({{ asset('backend') }}/assets/images/mekkah.jpeg);">
    <div class="login-from-wrap">
        <h1 class="site-title">
            <a href="#">
                <img src="{{ asset('backend') }}/assets/images/logo.png" alt="logo">
            </a>
        </h1>
        
        @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
        </div>
        @endif

        {{ __('Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.') }}
        {{ __('Jika Anda tidak menerima email') }},

        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik di sini untuk meminta yang lain') }}</button>.
        </form>
    </div>
</div>
@endsection