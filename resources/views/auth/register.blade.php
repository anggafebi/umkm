@extends('layouts.app')
@section('title','Daftar Akun Client | Aditech Multisolusi')
@push('head')<link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">AKUN CLIENT</span><h1>Daftar Akun</h1><p>Untuk memantau riwayat konsultasi dan balasan admin.</p></div></section>
<section class="modern-section"><div class="container client-area"><div class="modern-card client-form-card"><h2>Pendaftaran Client</h2>
@if($errors->any())<div class="form-error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
@if($remaining > 0)<form method="POST" action="{{ route('register.submit') }}" class="contact-form">@csrf
<label class="form-field">Nama lengkap *<input name="name" value="{{ old('name') }}" required autocomplete="name"></label>
<label class="form-field">Email *<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></label>
<label class="form-field">WhatsApp *<input name="phone" value="{{ old('phone') }}" required autocomplete="tel"></label>
<label class="form-field">Password (minimal 8 karakter) *<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
<label class="form-field">Konfirmasi password *<input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password"></label>
<button class="button-primary" type="submit">Daftar</button></form>
@else<div class="form-error" role="status">Pendaftaran akun sedang ditutup (maksimal 10 akun). Anda tetap dapat berkonsultasi tanpa login.</div>@endif
<p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a> · <a href="{{ route('consultation') }}">Konsultasi sebagai guest</a></p></div></div></section>
@endsection
