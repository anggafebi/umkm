@extends('layouts.app')
@section('title','Riwayat Konsultasi | Aditech Multisolusi')
@push('head')<link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">AREA CLIENT</span><h1>Riwayat Konsultasi</h1><p>Hanya konsultasi yang dikirim dari akun Anda yang ditampilkan.</p></div></section>
<section class="modern-section"><div class="container client-area">@include('client.partials.navigation')
<div class="modern-card"><h2>Daftar konsultasi</h2>@forelse($consultations as $lead)<div class="client-list-item"><div><strong>{{ $lead->reference }} · {{ $lead->product_label }}</strong><p>{{ \Illuminate\Support\Str::limit($lead->message, 130) }}</p><small>{{ $lead->created_at->format('d M Y H:i') }} · {{ $lead->replies_count }} pesan percakapan</small>@if($lead->unread_replies_count)<span class="client-badge">{{ $lead->unread_replies_count }} balasan baru</span>@endif</div><div><span class="client-badge">{{ ['new'=>'Baru','contacted'=>'Dihubungi','follow_up'=>'Tindak lanjut','deal'=>'Disepakati','closed'=>'Selesai'][$lead->status] ?? $lead->status }}</span><a class="client-link" href="{{ route('client.consultations.show', $lead) }}">Lihat detail</a></div></div>@empty<p>Belum ada konsultasi. <a href="{{ route('consultation') }}">Mulai konsultasi</a></p>@endforelse
<div class="pagination"><x-pagination :paginator="$consultations" /></div></div></div></section>
@endsection
