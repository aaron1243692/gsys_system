@if($paginator->total() > 0)
<div class="gs-pagination">
    <p>Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}</p>
    @if($paginator->hasPages())
    <nav aria-label="Pagination">
        @if($paginator->onFirstPage())<span class="gs-page" aria-disabled="true">‹</span>@else<a aria-label="Previous page" href="{{ $paginator->previousPageUrl() }}">‹</a>@endif
        @foreach($paginator->getUrlRange(max(1, $paginator->currentPage()-1), min($paginator->lastPage(), $paginator->currentPage()+1)) as $page => $url)
            <a href="{{ $url }}" @if($page === $paginator->currentPage()) aria-current="page" @endif aria-label="Page {{ $page }}">{{ $page }}</a>
        @endforeach
        @if($paginator->hasMorePages())<a aria-label="Next page" href="{{ $paginator->nextPageUrl() }}">›</a>@else<span class="gs-page" aria-disabled="true">›</span>@endif
    </nav>
    @endif
</div>
@endif
