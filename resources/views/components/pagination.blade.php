@if($paginator->hasPages())
<nav class="pagination-modern" role="navigation" aria-label="Navigasi halaman">
    @if($paginator->onFirstPage())
        <span class="disabled" aria-disabled="true">← Sebelumnya</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Sebelumnya</a>
    @endif

    <span class="pagination-status">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>

    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya →</a>
    @else
        <span class="disabled" aria-disabled="true">Berikutnya →</span>
    @endif
</nav>
@endif
