@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}

        @if ($paginator->onFirstPage())
            <li class=" disabled">
                <a href="#!"><i class="material-icons">chevron_left</i></a>
            </li>
        @else
            <li class="waves-effect">
                <a  href="{{ $paginator->previousPageUrl() }}" ><i class="material-icons">chevron_left</i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span >{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{-- <li class="active orange darken-2" >{{ $page }}</li> --}}
                        <li class="active bg-primary darken-2"><a href="#!">{{ $page }}</a></li>
                    @else
                        <li class="waves-effect"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="waves-effect">
                <a  href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="material-icons">chevron_right</i></a>
            </li>
        @else
            <li class="disabled" aria-disabled="true" >
                <a href="#!"><i class="material-icons">chevron_right</i></a>
            </li>
        @endif

    </ul>
@endif
