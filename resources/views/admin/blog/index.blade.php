@extends('admin.layouts.app')
@section('title','Artikel')
@section('page_title','Artikel & Content Marketing')
@section('content')
<div class="page-actions">
    <div><h1 class="content-title">Artikel</h1><p class="muted">Publikasikan konten yang relevan untuk membangun traffic organik.</p></div>
    <button class="primary-button" type="button" data-modal-open="new-post">+ Artikel Baru</button>
</div>

<div class="panel">
    <div class="table-wrap">
        <table class="admin-table">
            <thead><tr><th>Artikel</th><th>Kategori</th><th>Status</th><th>Publikasi</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($posts as $post)
                <tr>
                    <td><strong>{{ $post->title }}</strong><small>/blog/{{ $post->slug }}</small></td>
                    <td>{{ $post->category?->name ?: '-' }}</td>
                    <td><span class="status {{ $post->status==='published'?'deal':'new' }}">{{ $post->status === 'published' ? 'Terbit' : 'Draft' }}</span></td>
                    <td>{{ $post->published_at?->format('d M Y') ?: '-' }}</td>
                    <td class="actions">
                        <button class="small-button" type="button" data-modal-open="post-{{ $post->id }}">Edit</button>
                        <form method="POST" action="{{ route('admin.blog.destroy',$post) }}" onsubmit="return confirm('Hapus artikel ini?')">@csrf @method('DELETE')<button class="danger-button" type="submit">Hapus</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada artikel.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination"><x-pagination :paginator="$posts" /></div>
</div>

@foreach($posts as $post)
<div class="modal" id="post-{{ $post->id }}" aria-hidden="true">
    <div class="modal-card large">
        <button class="modal-close" type="button" data-modal-close aria-label="Tutup">×</button>
        <h2>Edit Artikel</h2>
        @include('admin.blog.partials.form',['post'=>$post,'action'=>route('admin.blog.update',$post),'method'=>'PUT'])
    </div>
</div>
@endforeach

<div class="modal" id="new-post" aria-hidden="true">
    <div class="modal-card large">
        <button class="modal-close" type="button" data-modal-close aria-label="Tutup">×</button>
        <h2>Artikel Baru</h2>
        @include('admin.blog.partials.form',['post'=>null,'action'=>route('admin.blog.store'),'method'=>'POST'])
        <hr>
        <form method="POST" action="{{ route('admin.blog.category.store') }}">
            @csrf
            <label>Kategori Baru<input name="name" placeholder="Tips Bisnis"></label>
            <button class="secondary-button" type="submit">Tambah Kategori</button>
        </form>
    </div>
</div>
@endsection
