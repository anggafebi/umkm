@extends('layouts.app')
@section('title','Kontak | '.($siteSettings['site_name'] ?? 'Aditech Multisolusi'))
@section('description','Hubungi '.($siteSettings['site_name'] ?? 'Aditech Multisolusi').' untuk kebutuhan website, sistem digital, dan konsultasi bisnis.')
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">CONTACT</span><h1>Mari diskusikan peluang digital bisnis Anda.</h1><p>Hubungi kami untuk kebutuhan website, sistem digital, pengembangan lanjutan, atau konsultasi awal.</p></div></section>
<section class="modern-section"><div class="container contact-grid"><div class="modern-card"><span class="section-kicker">HUBUNGI KAMI</span><h2>{{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}</h2><p><strong>WhatsApp</strong><br>{{ $siteSettings['phone'] ?? '087848127894' }}</p><p><strong>Email</strong><br>{{ $siteSettings['email'] ?? 'info@aditech.id' }}</p><p><strong>Lokasi</strong><br>{{ $siteSettings['location'] ?? 'Indonesia' }}</p></div><div class="modern-card"><h2>Kirim Pesan</h2>@if(session('success'))<div class="form-success" role="status">{{ session('success') }}</div>@endif @if($errors->any())<div class="form-error" role="alert">Periksa kembali data yang Anda masukkan.</div>@endif<form method="POST" action="{{ route('contact.store') }}" class="contact-form">@csrf
<label class="form-field"><span>Nama *</span><input name="name" value="{{ old('name') }}" autocomplete="name" required>@error('name')<small class="field-error">{{ $message }}</small>@enderror</label>
<label class="form-field"><span>Bisnis / Perusahaan</span><input name="business_name" value="{{ old('business_name') }}" autocomplete="organization"></label>
<label class="form-field"><span>WhatsApp *</span><input name="phone" value="{{ old('phone') }}" inputmode="tel" autocomplete="tel" required>@error('phone')<small class="field-error">{{ $message }}</small>@enderror</label>
<label class="form-field"><span>Email</span><input type="email" name="email" value="{{ old('email') }}" autocomplete="email">@error('email')<small class="field-error">{{ $message }}</small>@enderror</label>
<label class="form-field"><span>Kebutuhan</span><input name="service_interest" value="{{ old('service_interest') }}"></label>
<label class="form-field"><span>Pesan</span><textarea name="message" rows="5">{{ old('message') }}</textarea>@error('message')<small class="field-error">{{ $message }}</small>@enderror</label>
<button class="button-primary" type="submit">Kirim Pesan</button></form></div></div></section>
@endsection
