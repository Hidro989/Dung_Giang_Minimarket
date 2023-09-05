
<div class="product__pagination d-flex justify-content-end">
    <!-- Nút Trang trước -->
    @if ($paginator->onFirstPage())
        <a href="#"><i class="fa fa-long-arrow-left disabled"></i></a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-long-arrow-right"></i></a>
    @endif

    <!-- Các nút số trang -->
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <a class="{{ $paginator->currentPage() == $i ? 'active' : '' }}" href="{{ $paginator->url($i) }}">{{ $i }}</a>
    @endfor

    <!-- Nút Trang sau -->
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-long-arrow-right"></i></a>
    @else
        <a href="#"><i class="fa fa-long-arrow-right disabled"></i></a>
    @endif
</div>