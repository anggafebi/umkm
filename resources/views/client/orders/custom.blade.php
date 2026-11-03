@extends('layouts.app')
@section('title','Ajukan Pemesanan Custom | Aditech')
@push('head')<link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">PENGAJUAN PEMESANAN</span><h1>Ceritakan kebutuhan proyek Anda.</h1><p>Admin akan meninjau kebutuhan dan menyiapkan penawaran yang sesuai.</p></div></section>
<section class="modern-section"><div class="container client-area"><div class="modern-card client-form-card">
@if($errors->any())<div class="form-error">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="POST" action="{{ route('orders.store-custom') }}" class="contact-form">@csrf
@guest
<label class="form-field">Nama lengkap *<input name="guest_name" value="{{ old('guest_name') }}" required maxlength="120"></label>
<label class="form-field">Email *<input type="email" name="guest_email" value="{{ old('guest_email') }}" required maxlength="160"></label>
<label class="form-field">Nomor WhatsApp *<input name="guest_phone" value="{{ old('guest_phone') }}" required maxlength="40"></label>
<p class="form-hint">Anda dapat mengirim pengajuan tanpa login. Setelah berhasil, Anda akan diarahkan membuat akun klien untuk memantau pesanan.</p>
@endguest
@if($product)<div class="info-box-public"><strong>Produk / layanan terkait</strong><p>{{ $product->name }}</p></div><input type="hidden" name="product_id" value="{{ $product->id }}">@endif
<label class="form-field">Jenis layanan *<input name="service_type" value="{{ old('service_type', $serviceName) }}" required maxlength="160"></label>
<label class="form-field">Nama proyek *<input name="project_name" value="{{ old('project_name') }}" required maxlength="160"></label>
<label class="form-field">Deskripsi kebutuhan *<textarea name="description" rows="5" required>{{ old('description') }}</textarea></label>
<label class="form-field">Fitur yang diinginkan<textarea name="requested_features" rows="4">{{ old('requested_features') }}</textarea></label>
<label class="form-field">Estimasi budget (opsional)<select name="budget"><option value="">Belum ditentukan</option>@foreach(['< Rp 3 juta','Rp 3 - 7 juta','Rp 7 - 15 juta','> Rp 15 juta'] as $budget)<option @selected(old('budget')===$budget)>{{ $budget }}</option>@endforeach</select></label>
<label class="form-field">Catatan tambahan<textarea name="client_notes" rows="3">{{ old('client_notes') }}</textarea></label>
<p class="form-hint">Pengajuan ini belum memerlukan pembayaran. Admin akan meninjau kebutuhan dan memberikan penawaran melalui akun Anda.</p>
<button class="button-primary" type="submit">Kirim Pengajuan <x-icon name="arrow-right" size="17" /></button>
</form></div></div></section>
@endsection
