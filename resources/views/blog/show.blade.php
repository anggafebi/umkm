@extends('layouts.app')
@section('title', $post->meta_title ?: $post->title)
@section('description', $post->meta_description ?: $post->excerpt)
@section('content')
<article class="article-page"><header class="article-header container"><a class="back-link" href="{{ route('blog.index') }}">← Semua insight</a><span class="section-kicker">{{ $post->category?->name ?? 'INSIGHT' }}</span><h1>{{ $post->title }}</h1><p>{{ $post->excerpt }}</p><small>{{ $post->published_at?->translatedFormat('d F Y') }}</small></header>@if($post->image)<div class="article-cover container"><img loading="lazy" decoding="async" src="{{ \App\Support\Media::url($post->image, 'images/placeholder.svg') }}" alt="{{ $post->title }}"></div>@endif<div class="article-content container">{!! nl2br(e($post->content)) !!}</div></article>
@if($related->isNotEmpty())<section class="section soft-section"><div class="container"><div class="section-heading left"><h2>Artikel terkait</h2></div><div class="blog-grid">@foreach($related as $item)<article class="blog-card"><div><small>{{ $item->published_at?->format('d M Y') }}</small><h3>{{ $item->title }}</h3><p>{{ $item->excerpt }}</p><a href="{{ route('blog.show',$item->slug) }}">Baca →</a></div></article>@endforeach</div></div></section>@endif
@endsection
