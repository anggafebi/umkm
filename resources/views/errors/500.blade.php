@extends('layouts.app')
@section('title','Terjadi Kesalahan | '.($siteSettings['site_name'] ?? 'Aditech Multisolusi'))
@section('description','Terjadi gangguan saat memproses halaman.')
@section('content')
<section class="error-page">
    <div class="error-card">
        <strong>500</strong>
        <h1>Terjadi gangguan pada sistem.</h1>
        <p>Halaman belum dapat diproses. Muat ulang halaman atau kembali ke beranda.</p>
        <a class="button-primary" href="{{ route('home') }}">Kembali ke Beranda <x-icon name="arrow-right" size="17" /></a>
    </div>
</section>
@endsection
