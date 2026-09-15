@extends('admin.layouts.app')
@section('title','Profil') @section('page_title','Profil Admin')
@section('content')
<div class="dashboard-grid"><section class="panel"><div class="panel-heading"><div><h2>Informasi Akun</h2><p>Perbarui identitas dan password akun yang sedang digunakan.</p></div></div><form method="POST" action="{{ route('admin.profile.update') }}">@csrf @method('PUT')<label>Nama<input name="name" value="{{ $user->name }}" required></label><label>Email<input type="email" name="email" value="{{ $user->email }}" required></label><label>Password Baru<input type="password" name="password" placeholder="Kosongkan bila tidak diubah"></label><button class="primary-button">Simpan Profil</button></form></section></div>
@endsection
