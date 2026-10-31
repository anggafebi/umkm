@extends('layouts.app')
@section('title','Akun Saya | Aditech Multisolusi')
@push('head')<link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">AREA CLIENT</span><h1>Halo, {{ auth()->user()->name }}</h1><p>Pantau konsultasi, status, dan balasan dari tim Aditech.</p></div></section>
<section class="modern-section"><div class="container client-area">
@include('client.partials.navigation')
@if(session('success'))<div class="form-success" role="status">{{ session('success') }}</div>@endif
<div class="client-grid"><div class="modern-card"><h2>{{ $total }} konsultasi</h2><p>Jumlah konsultasi yang terhubung ke akun ini.</p><a class="button-primary" href="{{ route('client.consultations.index') }}">Lihat riwayat</a></div><div class="modern-card"><h2>{{ $unread }} notifikasi belum dibaca</h2><p>Perubahan status dan balasan admin akan tampil di bawah.</p>@if($latest)<p>Terbaru: <a href="{{ route('client.consultations.show', $latest) }}">{{ $latest->reference }}</a> ({{ $latest->product_label }})</p>@endif</div></div>
<div class="modern-card"><h2>Notifikasi Akun</h2>@forelse($notifications as $notice)<div class="client-list-item"><div><strong>{{ $notice->title }} @if(!$notice->read_at)<span class="client-badge">Baru</span>@endif</strong><p>{{ $notice->body }}</p><small>{{ $notice->created_at->format('d M Y H:i') }}</small></div><form method="POST" action="{{ route('client.notifications.read', $notice) }}">@csrf<button class="client-link" type="submit">{{ $notice->read_at ? 'Lihat detail' : 'Tandai dibaca & lihat' }}</button></form></div>@empty<p>Belum ada notifikasi.</p>@endforelse</div>
</div></section>
@endsection
