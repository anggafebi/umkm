<h1>Daftar Konsultasi</h1>

@foreach($consultations as $item)

<div>
    <h3>{{ $item->name }}</h3>
    <p>{{ $item->phone }}</p>
    <p>{{ $item->message }}</p>

    <form method="POST" action="/admin/consultations/{{ $item->id }}">
        @csrf
        @method('PUT')

        <select name="status">
            <option value="new">New</option>
            <option value="contacted">Contacted</option>
            <option value="proposal">Proposal</option>
            <option value="deal">Deal</option>
            <option value="closed">Closed</option>
        </select>

        <button>Simpan</button>
    </form>
</div>

@endforeach