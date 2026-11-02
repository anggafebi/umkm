@extends('layouts.app')
@section('title','Checkout '.$product->name.' | Aditech')
@push('head')<link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">CHECKOUT</span><h1>Konfirmasi Pesanan</h1><p>Periksa produk dan informasi pesanan sebelum dikirim ke Aditech.</p></div></section>
<section class="modern-section"><div class="container client-area"><div class="modern-card client-form-card">
@if($errors->any())<div class="form-error">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<h2>{{ $product->name }}</h2><p>{{ $product->description }}</p><div class="info-box-public"><strong>Harga tetap</strong><h2>{{ \App\Support\ProductPricing::label($product) }}</h2><p>Ini merupakan pengajuan pesanan, bukan pembayaran. Admin akan menindaklanjuti pesanan melalui akun Anda.</p></div>
<form method="POST" action="{{ route('orders.store-fixed', $product) }}" class="contact-form">@csrf
<p><strong>Nama:</strong> {{ auth()->user()->name }}<br><strong>Email:</strong> {{ auth()->user()->email }}<br><strong>WhatsApp:</strong> {{ auth()->user()->phone }}</p>
<label class="form-field">Catatan tambahan (opsional)<textarea name="client_notes" rows="4">{{ old('client_notes') }}</textarea></label>
<button class="button-primary" type="submit">Konfirmasi Pesanan <x-icon name="arrow-right" size="17" /></button>
</form></div></div></section>
@endsection
