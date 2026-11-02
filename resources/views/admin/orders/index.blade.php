@extends('admin.layouts.app')
@section('title','Pesanan Client')
@section('page_title','Pesanan Client')
@section('content')
<div class="page-actions">
    <div>
        <h2>Pesanan Client</h2>
        <p class="muted">Kelola checkout produk harga tetap dan pengajuan layanan custom.</p>
    </div>
</div>

<div class="panel">
    <div class="table-wrap">
        <form class="filter-form" method="GET" style="padding:20px 20px 0">
            <label>Status
                <select name="status">
                    <option value="">Semua status</option>
                    @foreach(['pending','review','awaiting_approval','approved','in_progress','completed','cancelled'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ str_replace('_', ' ', $status) }}
                        </option>
                    @endforeach
                </select>
            </label>
            <button class="secondary-button" type="submit">Filter</button>
        </form>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Client</th>
                        <th>Produk / Layanan</th>
                        <th>Jenis</th>
                        <th>Harga / Estimasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $statusPresentation = [
                                'pending' => ['label' => 'Baru', 'class' => 'new'],
                                'review' => ['label' => 'Ditinjau', 'class' => 'contacted'],
                                'awaiting_approval' => ['label' => 'Menunggu Persetujuan', 'class' => 'follow_up'],
                                'approved' => ['label' => 'Disetujui', 'class' => 'deal'],
                                'in_progress' => ['label' => 'Dalam Pengerjaan', 'class' => 'contacted'],
                                'completed' => ['label' => 'Selesai', 'class' => 'closed'],
                                'cancelled' => ['label' => 'Dibatalkan', 'class' => 'cancelled'],
                            ];
                            $statusInfo = $statusPresentation[$order->status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $order->status)),
                                'class' => 'closed',
                            ];
                        @endphp
                        <tr>
                            <td>
                                {{ $order->order_number }}
                                <small>{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                <strong>{{ $order->owner?->name ?? '-' }}</strong>
                                <small>{{ $order->owner?->email }}</small>
                            </td>
                            <td>{{ $order->product_name }}</td>
                            <td>{{ $order->order_type === 'fixed' ? 'Harga tetap' : 'Custom' }}</td>
                            <td>
                                {{ $order->price
                                    ? 'Rp'.number_format((float) $order->price, 0, ',', '.')
                                    : ($order->offer_price
                                        ? 'Rp'.number_format((float) $order->offer_price, 0, ',', '.')
                                        : 'Belum ditentukan') }}
                            </td>
                            <td>
                                <span
                                    class="status {{ $statusInfo['class'] }}"
                                    @if($order->status === 'cancelled')
                                        style="background:#fee2e2;color:#b91c1c;border:1px solid #fecaca"
                                    @endif
                                >{{ $statusInfo['label'] }}</span>
                            </td>
                            <td>
                                <a class="small-button" href="{{ route('admin.orders.show', $order) }}">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination"><x-pagination :paginator="$orders" /></div>
</div>
@endsection
