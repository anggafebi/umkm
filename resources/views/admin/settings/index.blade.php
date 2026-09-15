@extends('admin.layouts.app')
@section('title','Website & SEO')
@section('page_title','Website, SEO & Theme')
@section('content')
<div class="dashboard-welcome"><div><span class="eyebrow">CMS WEBSITE</span><h1>Pengaturan global.</h1><p>Ubah homepage, kontak, SEO, social media, dan default theme tanpa menyentuh source code.</p></div></div>
<form method="POST" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
<div class="settings-grid">
@foreach($settings as $group=>$items)
<section class="panel"><div class="panel-heading"><div><h2>{{ ucfirst($group) }}</h2><p>{{ ['general'=>'Identitas dan kontak bisnis.','home'=>'Konten utama halaman depan.','social'=>'Tautan kanal sosial.','seo'=>'Metadata untuk mesin pencari dan social sharing.','theme'=>'Preferensi tampilan default.'][$group] ?? 'Pengaturan website.' }}</p></div></div>
<div class="form-grid single">
@foreach($items as $item)
<label>{{ ucwords(str_replace('_',' ',$item->key)) }}
@if($item->type==='textarea')<textarea name="settings[{{ $item->key }}]" rows="3">{{ $item->value }}</textarea>
@elseif($item->type==='select')<select name="settings[{{ $item->key }}]"><option value="system" @selected($item->value==='system')>System</option><option value="light" @selected($item->value==='light')>Light</option><option value="dark" @selected($item->value==='dark')>Dark</option></select>
@elseif($item->type==='color')<input type="color" name="settings[{{ $item->key }}]" value="{{ $item->value ?: '#2563eb' }}">
@elseif($item->type==='boolean')<select name="settings[{{ $item->key }}]"><option value="1" @selected($item->value==='1')>Aktif</option><option value="0" @selected($item->value==='0')>Nonaktif</option></select>
@else<input name="settings[{{ $item->key }}]" value="{{ $item->value }}">@endif
</label>
@endforeach
</div></section>
@endforeach
</div><div class="sticky-save"><button class="primary-button">Simpan Semua Pengaturan</button></div></form>
@endsection
