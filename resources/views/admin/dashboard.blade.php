@extends('admin.layouts.app')
@section('title','Dashboard')
@section('page_title','Dashboard')
@section('content')
<div class="dashboard-welcome">
    <div><span class="eyebrow">RINGKASAN BISNIS</span><h1>Selamat datang, {{ auth()->user()->name }}.</h1><p>Pantau konten, leads, dan aktivitas website dari satu tempat.</p></div>
    <a class="primary-button" href="{{ route('admin.settings.index') }}">Kelola Website</a>
</div>
<div class="metric-grid">
    <div class="metric-card"><span>Leads Baru</span><strong>{{ $newLeadCount }}</strong><small>dari {{ $consultationCount }} total lead</small></div>
    <div class="metric-card"><span>Visitor Bulan Ini</span><strong>{{ $visitorCount }}</strong><small>{{ $pageViewCount }} page view hari ini</small></div>
    <div class="metric-card"><span>Newsletter</span><strong>{{ $newsletterCount }}</strong><small>subscriber aktif</small></div>
    <div class="metric-card"><span>Artikel</span><strong>{{ $blogCount }}</strong><small>{{ $portfolioCount }} portfolio · {{ $serviceCount }} layanan</small></div>
</div>
<div class="dashboard-grid">
    <section class="panel span-2">
        <div class="panel-heading"><div><h2>Lead 6 Bulan Terakhir</h2><p>Volume konsultasi yang masuk melalui website.</p></div></div>
        @php($maxLead=max(1,(int)$monthlyLeads->max()))
        <div class="bar-chart">
            @forelse($monthlyLeads as $month=>$total)
                <div class="bar-item"><div class="bar" style="height:{{ max(10,round(($total/$maxLead)*180)) }}px"><span>{{ $total }}</span></div><small>{{ \Carbon\Carbon::createFromFormat('Y-m',$month)->translatedFormat('M y') }}</small></div>
            @empty
                <div class="empty-state">Belum ada data lead pada periode ini.</div>
            @endforelse
        </div>
    </section>
    <section class="panel">
        <div class="panel-heading"><div><h2>Pipeline Lead</h2><p>Status konsultasi saat ini.</p></div></div>
        @foreach(['new'=>'New','contacted'=>'Contacted','follow_up'=>'Follow Up','deal'=>'Deal','closed'=>'Closed'] as $key=>$label)
            @php($count=(int)($leadByStatus[$key]??0))
            <div class="pipeline-row"><span>{{ $label }}</span><div class="progress"><i style="width:{{ $consultationCount?round(($count/$consultationCount)*100):0 }}%"></i></div><strong>{{ $count }}</strong></div>
        @endforeach
    </section>
</div>
<div class="dashboard-grid">
<section class="panel span-2">
    <div class="panel-heading"><div><h2>Lead Terbaru</h2><p>Prospek yang paling baru masuk.</p></div><a href="{{ route('admin.consultations.index') }}">Lihat semua</a></div>
    <div class="table-wrap"><table class="admin-table"><thead><tr><th>Nama</th><th>Bisnis</th><th>Status</th><th>Tanggal</th></tr></thead><tbody>
    @forelse($recentLeads as $lead)<tr><td><strong>{{ $lead->name }}</strong><small>{{ $lead->phone }}</small></td><td>{{ $lead->business_name ?: '-' }}</td><td><span class="status {{ $lead->status }}">{{ str_replace('_',' ',ucwords($lead->status,'_')) }}</span></td><td>{{ $lead->created_at->format('d M Y') }}</td></tr>@empty<tr><td colspan="4">Belum ada lead.</td></tr>@endforelse
    </tbody></table></div>
</section>
<section class="panel">
    <div class="panel-heading"><div><h2>Aktivitas</h2><p>Perubahan terakhir di admin.</p></div></div>
    <div class="activity-list">@forelse($activityLogs as $log)<div class="activity-item"><i></i><div><strong>{{ $log->description ?: $log->action }}</strong><small>{{ $log->user?->name ?? 'System' }} · {{ $log->created_at->diffForHumans() }}</small></div></div>@empty<div class="empty-state">Belum ada aktivitas.</div>@endforelse</div>
</section>
</div>
@endsection
