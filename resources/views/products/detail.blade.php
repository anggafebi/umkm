@extends('layouts.app')

@section('content')

<h1>
{{ $product->name }}
</h1>

<p>
{{ $product->description }}
</p>

<p>
Harga:
{{ $product->price }}
</p>


<a href="/konsultasi">
Inquiry WhatsApp
</a>

@endsection