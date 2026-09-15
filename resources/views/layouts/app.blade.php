<!DOCTYPE html>
<html lang="id" class="theme-preload">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteSettings['meta_title'] ?? 'Aditech Multisolusi UMKM')</title>
    <meta name="description" content="@yield('description', $siteSettings['meta_description'] ?? 'Solusi website dan sistem digital untuk UMKM')">
    <meta name="keywords" content="{{ $siteSettings['meta_keywords'] ?? 'website UMKM, sistem informasi, digitalisasi bisnis, Laravel' }}">
    <meta name="author" content="{{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <meta name="theme-color" content="{{ $siteSettings['primary_color'] ?? '#2563eb' }}">
    <link rel="canonical" href="{{ request()->url() }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'Aditech Multisolusi' }}">
    <meta property="og:title" content="@yield('og_title', $siteSettings['meta_title'] ?? 'Aditech Multisolusi UMKM')">
    <meta property="og:description" content="@yield('og_description', $siteSettings['meta_description'] ?? 'Solusi digital untuk UMKM')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="{{ \App\Support\Media::url($siteSettings['og_image'] ?? null, 'images/hero/hero-mockup.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $siteSettings['meta_title'] ?? 'Aditech Multisolusi UMKM')">
    <meta name="twitter:description" content="@yield('og_description', $siteSettings['meta_description'] ?? 'Solusi digital untuk UMKM')">
    <meta name="twitter:image" content="{{ \App\Support\Media::url($siteSettings['og_image'] ?? null, 'images/hero/hero-mockup.png') }}">
    <script>
      (()=>{const allowDark=@json(($siteSettings['dark_mode_enabled'] ?? '1') === '1');const def=@json($siteSettings['default_theme'] ?? 'system');const saved=localStorage.getItem('aditech-theme');const sys=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';let theme='light';if(allowDark){theme=saved||(def==='system'?sys:def);if(!['light','dark'].includes(theme)) theme=sys;}document.documentElement.dataset.theme=theme;document.documentElement.style.colorScheme=theme;})();
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <style>:root{--primary:{{ $siteSettings['primary_color'] ?? '#2563eb' }};}</style>
    @if(!empty($siteSettings['google_analytics_id']))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['google_analytics_id'] }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());gtag('config',@json($siteSettings['google_analytics_id']));</script>
    @endif
    @stack('head')

<link rel="stylesheet" href="{{ asset('assets/css/refactor-modern.css') }}">
</head>
<body>
<a class="skip-link" href="#main-content">Lewati ke konten utama</a>
@include('layouts.navbar')
<div class="nav-backdrop" data-nav-backdrop aria-hidden="true"></div>
<main id="main-content">@yield('content')</main>
@php($wa=preg_replace('/\D+/','',$siteSettings['phone'] ?? '6287848127894'))
<a href="https://wa.me/{{ str_starts_with($wa,'0')?'62'.substr($wa,1):$wa }}?text=Halo%20Aditech,%20saya%20ingin%20konsultasi" class="whatsapp-floating" target="_blank" rel="noopener" aria-label="Konsultasi melalui WhatsApp">
    <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M19.11 17.39c-.27-.14-1.58-.78-1.83-.87-.24-.09-.42-.14-.6.14-.18.27-.69.87-.85 1.05-.16.18-.31.2-.58.07-.27-.14-1.13-.42-2.15-1.33-.8-.71-1.33-1.58-1.49-1.85-.16-.27-.02-.42.12-.55.12-.12.27-.31.4-.47.13-.16.18-.27.27-.45.09-.18.04-.34-.02-.47-.07-.14-.6-1.44-.82-1.97-.22-.52-.44-.45-.6-.46h-.51c-.18 0-.47.07-.71.34-.24.27-.93.91-.93 2.22s.95 2.57 1.09 2.75c.13.18 1.87 2.86 4.53 4.01.63.27 1.13.44 1.51.56.64.2 1.22.17 1.68.1.51-.08 1.58-.65 1.8-1.27.22-.62.22-1.15.16-1.27-.07-.11-.25-.18-.52-.31Z"/><path d="M16.03 3.2a12.8 12.8 0 0 0-10.98 19.4L3.2 28.8l6.37-1.82A12.8 12.8 0 1 0 16.03 3.2Zm0 23.27c-2.05 0-4.04-.6-5.75-1.73l-.41-.24-3.78 1.08 1.1-3.68-.27-.43a10.48 10.48 0 1 1 9.11 5Z"/></svg>
    <span class="wa-tooltip">Konsultasi via WhatsApp</span>
</a>
@include('layouts.footer')
@include('components.schema')
<script src="{{ asset('assets/js/app.js') }}" defer></script>
<script>requestAnimationFrame(()=>document.documentElement.classList.remove('theme-preload'));</script>
</body>
</html>
