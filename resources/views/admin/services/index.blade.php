<h1>Kelola Layanan</h1>

@foreach($services as $service)
<p>
{{ $service->name }}

<form method="POST" action="/admin/services/{{ $service->id }}">
@csrf
@method('DELETE')
<button>Hapus</button>
</form>

</p>
@endforeach