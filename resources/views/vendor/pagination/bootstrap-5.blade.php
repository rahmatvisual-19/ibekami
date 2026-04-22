@if ($paginator->hasPages())
    <div class="pro-pagination-style text-center mb-md-30px mb-lm-30px mt-30px" data-aos="fade-up">
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span class="prev"><i class="ion-ios-arrow-left"></i></span>
                </li>
            @else
                <li>
                    <a class="prev" href="{{ $paginator->previousPageUrl() }}"><i class="ion-ios-arrow-left"></i></a>
                </li>
            @endif

            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $showEllipsis = $lastPage > 2; 
                $startPage = max($currentPage - 1, 1);
                $endPage = min($currentPage + 1, $lastPage);
            @endphp

            @if ($showEllipsis && $startPage > 1)
                <li><a href="{{ $paginator->url(1) }}">1</a></li>
                @if ($startPage > 2)
                    <li class="disabled"><span>...</span></li>
                @endif
            @endif

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page == $currentPage)
                    <li><a class="active" href="#">{{ $page }}</a></li>
                @else
                    <li><a href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            @if ($showEllipsis && $endPage < $lastPage)
                @if ($endPage < $lastPage - 1)
                    <li class="disabled"><span>...</span></li>
                @endif
                <li><a href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="next" href="{{ $paginator->nextPageUrl() }}"><i class="ion-ios-arrow-right"></i></a>
                </li>
            @else
                <li class="disabled" aria-disabled="true">
                    <span class="next"><i class="ion-ios-arrow-right"></i></span>
                </li>
            @endif
        </ul>
    </div>
@endif