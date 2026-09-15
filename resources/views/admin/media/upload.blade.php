@extends('admin.layouts.app')
@section('title','Media Manager')
@section('page_title','Media Manager')
@section('content')
<div class="dashboard-grid">
<section class="panel"><div class="panel-heading"><div><h2>Upload Gambar</h2><p>JPG, PNG, WEBP, maksimum 4 MB.</p></div></div><form method="POST" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data">@csrf<label>Pilih file<input type="file" name="image" accept="image/*" required></label><button class="primary-button">Upload Media</button></form>@if(session('path'))<div class="info-box"><strong>Path siap dipakai:</strong><code>{{ session('path') }}</code></div>@endif</section>
<section class="panel span-2"><div class="panel-heading"><div><h2>Library</h2><p>Gunakan path pada field image di CMS.</p></div></div><div class="media-grid">@forelse($files as $file)<article class="media-card"><img src="{{ asset('storage/'.$file) }}" alt="Media"><div><code>storage/{{ $file }}</code><form method="POST" action="{{ route('admin.media.destroy') }}" onsubmit="return confirm('Hapus media ini?')">@csrf @method('DELETE')<input type="hidden" name="path" value="{{ $file }}"><button class="danger-button">Hapus</button></form></div></article>@empty<div class="empty-state">Belum ada media. Jalankan <code>php artisan storage:link</code> setelah instalasi.</div>@endforelse</div></section>
</div>
@endsection
