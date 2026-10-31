@extends('layouts.app')
@section('title','Konsultasi '.$consultation->reference.' | Aditech Multisolusi')
@push('head')<link rel="stylesheet" href="{{ asset('assets/css/client.css') }}">@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">KONSULTASI SAYA</span><h1>{{ $consultation->reference }}</h1><p>{{ $consultation->product_label }} · {{ $consultation->created_at->format('d M Y H:i') }}</p></div></section>
<section class="modern-section"><div class="container client-area">@include('client.partials.navigation')
@if(session('success'))<div class="form-success" role="status">{{ session('success') }}</div>@endif
<div class="modern-card"><h2>Status: {{ ['new'=>'Baru','contacted'=>'Dihubungi','follow_up'=>'Tindak lanjut','deal'=>'Disepakati','closed'=>'Selesai'][$consultation->status] ?? $consultation->status }}</h2><p><strong>Produk:</strong> {{ $consultation->product_label }}</p><p><strong>Nama saat dikirim:</strong> {{ $consultation->name }} · {{ $consultation->email }}</p><p><strong>Budget:</strong> {{ $consultation->budget ?: 'Belum ditentukan' }}</p></div>
<div class="modern-card"><h2>Percakapan Konsultasi</h2><p class="muted">Pesan tersimpan di nomor konsultasi yang sama. Muat ulang halaman untuk melihat balasan terbaru.</p>
<div class="ticket-timeline" aria-label="Riwayat percakapan">
<article class="ticket-message ticket-message-client"><div class="ticket-message-heading"><strong>Anda · Pesan awal</strong><time datetime="{{ $consultation->created_at->toIso8601String() }}">{{ $consultation->created_at->format('d M Y H:i') }}</time></div><p class="client-preserve">{{ $consultation->message }}</p></article>
@foreach($consultation->replies as $reply)
<article class="ticket-message {{ $reply->sender_role === 'client' ? 'ticket-message-client' : 'ticket-message-staff' }}"><div class="ticket-message-heading"><strong>{{ $reply->sender_role === 'client' ? 'Anda' : ($reply->sender?->name ?: 'Tim Aditech') }}</strong><time datetime="{{ $reply->created_at->toIso8601String() }}">{{ $reply->created_at->format('d M Y H:i') }}</time></div><p class="client-preserve">{{ $reply->body }}</p></article>
@endforeach
</div>
@if($consultation->status === 'closed')
<div class="info-box-public" role="status"><strong>Konsultasi telah selesai.</strong><p>Riwayat tetap dapat dibaca. Hubungi admin apabila tiket perlu dibuka kembali.</p></div>
@else
<form method="POST" action="{{ route('client.consultations.reply', $consultation) }}" class="contact-form ticket-reply-form" data-once-submit>@csrf
<input type="hidden" name="submission_token" value="{{ $replyToken }}">
<label class="form-field" for="clientReplyBody"><span>Balas Pesan *</span><textarea id="clientReplyBody" name="body" rows="4" maxlength="2000" required placeholder="Tulis pertanyaan atau informasi tambahan...">{{ old('body') }}</textarea>@error('body')<small class="field-error">{{ $message }}</small>@enderror</label>
<button type="submit" class="button-primary">Kirim Balasan</button>
</form>
@endif
</div>
<div class="modern-card"><h2>Riwayat Status</h2>@forelse($consultation->statusLogs as $log)<p>{{ $log->created_at->format('d M Y H:i') }} — {{ ['new'=>'Baru','contacted'=>'Dihubungi','follow_up'=>'Tindak lanjut','deal'=>'Disepakati','closed'=>'Selesai'][$log->new_status] ?? $log->new_status }}</p>@empty<p>Belum ada perubahan status.</p>@endforelse</div>
</div></section>
<script>document.addEventListener('DOMContentLoaded',()=>{document.querySelectorAll('[data-once-submit]').forEach(form=>form.addEventListener('submit',()=>{if(!form.checkValidity())return;const button=form.querySelector('[type=submit]');if(button){button.disabled=true;button.textContent='Mengirim…';}}));});</script>
@endsection
