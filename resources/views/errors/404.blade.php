@extends('layouts.app')
@section('title','Halaman Tidak Ditemukan | '.($siteSettings['site_name'] ?? 'Aditech Multisolusi'))
@section('description','Halaman yang Anda cari tidak ditemukan.')
@section('content')
<section class="error-page">
    <div class="error-card">
        <strong>404</strong>
        <h1>Halaman tidak ditemukan.</h1>
        <p>Alamat mungkin sudah berubah, salah diketik, atau halaman tidak lagi tersedia.</p>
        <a class="button-primary" href="{{ route('home') }}">Kembali ke Beranda <x-icon name="arrow-right" size="17" /></a>
    </div>
</section>
@endsection
