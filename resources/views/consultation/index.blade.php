@extends('layouts.app')
@section('title','Konsultasi Digital | '.($siteSettings['site_name'] ?? 'Aditech Multisolusi'))
@section('description','Diskusikan kebutuhan website, sistem bisnis, dan digitalisasi UMKM bersama tim Aditech.')
@push('head')
<style>
/* Tombol navigasi kontekstual, khusus halaman konsultasi. */
.consultation-inline-hint { display: block; margin-top: 9px; }
.consultation-action-link {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    max-width: 100%;
    min-height: 42px;
    margin-top: 10px;
    padding: 10px 14px;
    border: 1px solid var(--border-strong, #cbd5e1);
    border-radius: 10px;
    background: var(--surface, #fff);
    color: var(--primary, #315ff4);
    box-shadow: var(--shadow-xs, 0 1px 2px rgba(15, 23, 42, .06));
    font-size: 13px;
    font-weight: 700;
    line-height: 1.35;
    text-decoration: none;
    transition: border-color .18s ease, background-color .18s ease, transform .18s ease;
}
.consultation-action-link::after { content: "→"; font-size: 16px; line-height: 1; }
.consultation-action-link:hover {
    border-color: var(--primary, #315ff4);
    background: var(--primary-soft, #edf2ff);
    transform: translateY(-1px);
}
.consultation-action-link:focus-visible { outline: 2px solid var(--primary, #315ff4); outline-offset: 3px; }
@media (max-width: 480px) { .consultation-action-link { width: 100%; } }
</style>
@endpush
@section('content')
<section class="page-hero"><div class="container"><span class="section-kicker">KONSULTASI</span><h1>Ceritakan kebutuhan bisnis Anda.</h1><p>Kami membantu memetakan kebutuhan, memilih solusi yang relevan, dan menyusun langkah implementasi yang realistis.</p></div></section>
<section class="modern-section"><div class="container consultation-grid"><div class="modern-card"><span class="section-kicker">YANG BISA DIBAHAS</span><h2>Mulai dari kebutuhan, bukan dari teknologi.</h2><ul class="feature-list"><li>Website company profile dan landing page</li><li>Katalog produk dan presentasi digital</li><li>Sistem informasi dan dashboard internal</li><li>POS dan dukungan operasional</li><li>Maintenance, SEO, dan pengembangan lanjutan</li></ul><div class="info-box-public"><strong>Respons konsultasi</strong><p>Data Anda akan masuk ke dashboard lead internal dan hanya digunakan untuk menindaklanjuti permintaan konsultasi.</p></div></div>
<div class="modern-card"><h2>Form Konsultasi</h2>
@if(session('success'))<div class="form-success" role="status">{{ session('success') }}</div>@endif
@if($errors->any())<div class="form-error" role="alert">Periksa nama, email, WhatsApp, dan pesan. @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="POST" action="{{ route('consultation.store') }}" class="contact-form" data-once-submit>@csrf
<input type="hidden" name="submission_token" value="{{ $token }}">
@if($product)
<div class="info-box-public" role="status"><strong>Produk yang dikonsultasikan:</strong><p>{{ $product->name }}</p><small class="consultation-inline-hint">Untuk mengganti produk, gunakan:</small><a class="consultation-action-link" href="{{ route('consultation') }}">Form Konsultasi Umum</a></div>
<input type="hidden" name="product_id" value="{{ $product->id }}">
@else
<label class="form-field"><span>Produk yang diminati (opsional)</span><select name="product_id"><option value="">Umum / belum pilih produk</option>@foreach($products as $item)<option value="{{ $item->id }}" @selected((string) old('product_id') === (string) $item->id)>{{ $item->name }}</option>@endforeach</select>@error('product_id')<small class="field-error">{{ $message }}</small>@enderror</label>
@endif
@if(auth()->user()?->role === 'client' && auth()->user()->is_active)
<div class="info-box-public"><strong>Identitas dari profil</strong><p>{{ auth()->user()->name }} · {{ auth()->user()->email }} · {{ auth()->user()->phone }}</p><a class="consultation-action-link" href="{{ route('client.profile') }}">Edit Profil Jika Ada Perubahan</a></div>
@else
<label class="form-field"><span>Nama lengkap *</span><input name="name" value="{{ old('name') }}" autocomplete="name" required>@error('name')<small class="field-error">{{ $message }}</small>@enderror</label>
<label class="form-field"><span>WhatsApp *</span><input name="phone" value="{{ old('phone') }}" inputmode="tel" autocomplete="tel" required>@error('phone')<small class="field-error">{{ $message }}</small>@enderror</label>
<label class="form-field"><span>Email *</span><input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>@error('email')<small class="field-error">{{ $message }}</small>@enderror</label>
@endif
<label class="form-field"><span>Nama bisnis / perusahaan</span><input name="business_name" value="{{ old('business_name') }}" autocomplete="organization"></label>
<label class="form-field"><span>Kebutuhan</span><select name="service_interest" id="consultationServiceInterest"><option value="">Pilih kebutuhan</option>@foreach(['Website Company Profile','Landing Page','Katalog Digital','Sistem Informasi','POS / Sistem Operasional','Lainnya'] as $option)<option value="{{ $option }}" @selected(old('service_interest') === $option)>{{ $option === 'Lainnya' ? 'Lainnya (ketik sendiri)' : $option }}</option>@endforeach</select>@error('service_interest')<small class="field-error">{{ $message }}</small>@enderror</label>
<label class="form-field" id="customServiceField" @if(old('service_interest') !== 'Lainnya') hidden @endif><span>Jelaskan kebutuhan lainnya *</span><input id="customServiceInput" name="service_interest_other" maxlength="140" value="{{ old('service_interest_other') }}" placeholder="Contoh: Aplikasi reservasi pelanggan" @if(old('service_interest') === 'Lainnya') required @endif><small class="form-hint">Tuliskan kebutuhan yang belum ada dalam pilihan.</small>@error('service_interest_other')<small class="field-error">{{ $message }}</small>@enderror</label>
<label class="form-field"><span>Kisaran budget</span><select name="budget"><option value="">Belum ditentukan</option>@foreach(['< Rp 3 juta','Rp 3 - 7 juta','Rp 7 - 15 juta','> Rp 15 juta'] as $option)<option value="{{ $option }}" @selected(old('budget') === $option)>{{ $option }}</option>@endforeach</select></label>
<label class="form-field"><span>Kebutuhan / target *</span><textarea name="message" rows="6" required>{{ old('message') }}</textarea>@error('message')<small class="field-error">{{ $message }}</small>@enderror</label>
<p class="form-hint">Dengan mengirim formulir, Anda menyetujui data kontak digunakan untuk menindaklanjuti konsultasi ini.</p>
<button class="button-primary" type="submit">Kirim Konsultasi <x-icon name="arrow-right" size="17" /></button>
</form></div></div></section>
<script>document.addEventListener('DOMContentLoaded',()=>{const select=document.getElementById('consultationServiceInterest');const field=document.getElementById('customServiceField');const input=document.getElementById('customServiceInput');if(select&&field&&input){const sync=()=>{const show=select.value==='Lainnya';field.hidden=!show;input.required=show;if(!show)input.value='';};select.addEventListener('change',sync);sync();}document.querySelectorAll('[data-once-submit]').forEach(f=>f.addEventListener('submit',()=>{if(!f.checkValidity())return;const b=f.querySelector('[type=submit]');if(b){b.disabled=true;b.textContent='Mengirim konsultasi…';}}));});</script>
@endsection
