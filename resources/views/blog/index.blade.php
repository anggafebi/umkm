@extends('layouts.app')
@section('title','Artikel & Insight | '.($siteSettings['site_name'] ?? 'Aditech Multisolusi'))
@section('description','Insight seputar website, digitalisasi UMKM, dan pengembangan sistem bisnis.')
@section('content')
<section class="page-hero-premium"><div class="container"><span class="section-kicker">ARTIKEL</span><h1>Artikel untuk membantu bisnis tumbuh lebih digital.</h1><p>Strategi, praktik, dan insight seputar website, pemasaran digital, serta sistem bisnis UMKM.</p></div></section>
<section class="section"><div class="container"><div class="blog-grid">@forelse($posts as $post)<article class="blog-card reveal"><div class="blog-image">@if($post->image)<img loading="lazy" decoding="async" src="{{ \App\Support\Media::url($post->image, 'images/placeholder.svg') }}" alt="{{ $post->title }}">@else<span>Insight</span>@endif</div><div><small>{{ $post->category?->name ?? 'Bisnis Digital' }} · {{ $post->published_at?->format('d M Y') }}</small><h2>{{ $post->title }}</h2><p>{{ $post->excerpt }}</p><a href="{{ route('blog.show',$post->slug) }}">Baca selengkapnya <x-icon name="arrow-right" size="16" /></a></div></article>@empty<div class="empty-state-public">Belum ada artikel yang dipublikasikan.</div>@endforelse</div><x-pagination :paginator="$posts" /></div></section>
@endsection
