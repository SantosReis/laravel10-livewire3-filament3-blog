@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center my-4">
        <ul class="inline-flex items-center -space-x-px">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-1 ml-0 leading-tight text-gray-400 bg-gray-200 border border-gray-300 rounded-l-lg cursor-not-allowed">«</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 ml-0 leading-tight text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-900">«</a>
                </li>
            @endif

            {{-- Page Links --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="px-3 py-1 leading-tight text-gray-500 bg-gray-200 border border-gray-300">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="px-3 py-1 leading-tight text-white bg-blue-500 border border-gray-300">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="px-3 py-1 leading-tight text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-900">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 leading-tight text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-900">»</a>
                </li>
            @else
                <li>
                    <span class="px-3 py-1 leading-tight text-gray-400 bg-gray-200 border border-gray-300 rounded-r-lg cursor-not-allowed">»</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
