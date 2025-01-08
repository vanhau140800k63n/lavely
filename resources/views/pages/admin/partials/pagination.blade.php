@if ($paginator->hasPages())
<div class="pull-right pagination" style="float: right">
    <ul class="pagination">
        @if (!$paginator->onFirstPage())
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" >
                    <span class="btn btn-outline-secondary" style="margin-right: 5px;"> Previous </span>
                </a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="btn btn-outline-secondary active" style="margin-right: 5px;">{{ $page }}</span></li>
                    @elseif (($page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() + 2) || $page == $paginator->lastPage())
                        <li><a href="{{ $url }}" class="btn btn-outline-secondary" style="margin-right: 5px;">{{ $page }}</a></li>
                    @elseif ($page == $paginator->lastPage() - 1)
                        <li class="disabled"><span class="btn btn-outline-secondary" style="margin-right: 5px;" > ... </span></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-secondary">
                    <span> Next </span>
                </a>
            </li>
        @endif
    </ul>
</div>
@endif