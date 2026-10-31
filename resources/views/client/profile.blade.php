@extends('layouts.app')
@section('title','Profil Saya | Aditech Multisolusi')
@push('head')<link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">AREA CLIENT</span><h1>Profil Saya</h1><p>Perubahan identitas berlaku untuk konsultasi berikutnya.</p></div></section>
<section class="modern-section"><div class="container client-area">@include('client.partials.navigation')<div class="modern-card client-form-card"><h2>Perbarui Profil</h2>@if(session('success'))<div class="form-success" role="status">{{ session('success') }}</div>@endif
@if($errors->any())<div class="form-error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="POST" action="{{ route('client.profile.update') }}" class="contact-form">@csrf @method('PUT')
<label class="form-field">Nama lengkap<input name="name" value="{{ old('name',$user->name) }}" required></label>
<label class="form-field">Email<input name="email" type="email" value="{{ old('email',$user->email) }}" required></label>
<label class="form-field">Nomor WhatsApp<input name="phone" value="{{ old('phone',$user->phone) }}" required></label>
<label class="form-field">Password baru (kosongkan bila tidak diganti)<input name="password" type="password" autocomplete="new-password" minlength="8"></label>
<label class="form-field">Konfirmasi password baru<input name="password_confirmation" type="password" autocomplete="new-password"></label>
<button class="button-primary" type="submit">Simpan profil</button></form></div></div></section>
@endsection
