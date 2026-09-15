<script type="application/ld+json">{!! json_encode([
'@context'=>'https://schema.org','@type'=>'Organization','name'=>$siteSettings['site_name'] ?? 'Aditech Multisolusi','description'=>$siteSettings['meta_description'] ?? 'Solusi digital untuk UMKM','url'=>route('home'),'email'=>$siteSettings['email'] ?? null,'telephone'=>$siteSettings['phone'] ?? null
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
