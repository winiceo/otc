@if ($paginator->hasPages())


<div class="text-center">

    <nav aria-label="Page navigation example">

        <ul class="pagination  ">

            @if ($paginator->onFirstPage())
                <li class=" page-item ">
                    <span class="page-link"   aria-label="Previous">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </span>
                 </li>
            @else

                <li class="page-item ">

                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                    </a>

                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))

                    <li class="page-item  ">
                        <span class="page-link">{{ $element }}</span>


                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link"  >{{ $page }}</span>
                            </li>
                         @else
                             <li class="page-item ">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item ">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                    </a>
                 </li>
            @else
                <li class="page-item disabled">
                         <span  ><i class="fa fa-angle-double-right"  ></i></span>
                 </li>
             @endif


        </ul>
    </nav>



</div>
@endif
