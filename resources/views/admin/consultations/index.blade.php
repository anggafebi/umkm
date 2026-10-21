@extends('admin.layouts.app')
@section('title','Leads')
@section('page_title','Leads & Konsultasi')
@section('content')
<div class="page-actions">
    <form class="filter-form" method="GET">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama, bisnis, atau telepon">
        <select name="status">
            <option value="">Semua status</option>
            @foreach(['new'=>'Baru','contacted'=>'Dihubungi','follow_up'=>'Follow Up','deal'=>'Deal','closed'=>'Selesai'] as $key=>$label)
                <option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="secondary-button" type="submit"><x-icon name="search" size="16" /> Filter</button>
    </form>
    <a class="primary-button" href="{{ route('admin.consultations.export') }}">Export CSV <x-icon name="arrow-up-right" size="16" /></a>
</div>

<div class="panel">
    <div class="table-wrap">
        <table class="admin-table">
            <thead><tr><th>Prospek</th><th>Kebutuhan</th><th>Status</th><th>Masuk</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($consultations as $lead)
                <tr>
                    <td><strong>{{ $lead->name }}</strong><small>{{ $lead->business_name ?: 'Tanpa nama bisnis' }} · {{ $lead->phone }}</small></td>
                    <td>{{ $lead->service_interest ?: '-' }}<small>{{ \Illuminate\Support\Str::limit($lead->message,70) }}</small></td>
                    <td><span class="status {{ $lead->status }}">{{ ucwords(str_replace('_',' ',$lead->status)) }}</span></td>
                    <td>{{ $lead->created_at->format('d M Y H:i') }}</td>
                    <td><button class="small-button" type="button" data-modal-open="lead-{{ $lead->id }}">Kelola</button></td>
                </tr>
            @empty
                <tr><td colspan="5">Tidak ada data.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination"><x-pagination :paginator="$consultations" /></div>
</div>

@foreach($consultations as $lead)
<div class="modal" id="lead-{{ $lead->id }}" aria-hidden="true">
    <div class="modal-card">
        <button class="modal-close" type="button" data-modal-close aria-label="Tutup">×</button>
        <h2>{{ $lead->name }}</h2>
        <p>{{ $lead->email ?: '-' }} · {{ $lead->phone }}</p>
        <div class="info-box"><strong>Pesan</strong><p>{{ $lead->message ?: 'Tidak ada pesan.' }}</p></div>
        <form method="POST" action="{{ route('admin.consultations.update',$lead) }}">
            @csrf @method('PUT')
            <label>Status
                <select name="status">
                    @foreach(['new'=>'Baru','contacted'=>'Dihubungi','follow_up'=>'Follow Up','deal'=>'Deal','closed'=>'Selesai'] as $key=>$label)
                        <option value="{{ $key }}" @selected($lead->status===$key)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label>Catatan Admin<textarea name="admin_notes" rows="5">{{ $lead->admin_notes }}</textarea></label>
            <button class="primary-button" type="submit">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endforeach
@endsection
