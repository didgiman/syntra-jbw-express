@if ($paginator->hasPages())
    <nav>
        <div class="flex justify-between items-center">
            {{-- Custom pagination info --}}
            <p class="text-sm text-purple-700 leading-5">
                Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
            </p>
            
            {{-- Pagination elements --}}
            <div class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5">
                        Previous
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                        Previous
                    </a>
                @endif

                {{-- Pagination Numbers --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <a href="{{ $url }}"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium border border-gray-300 
                                    {{ $page === $paginator->currentPage() 
                                        ? 'z-10 bg-purple-50 border-purple-500 text-purple-600' 
                                        : 'bg-white text-gray-500 hover:bg-gray-50' }}"
                            >
                                {{ $page }}
                            </a>
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
                        Next
                    </a>
                @else
                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5">
                        Next
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif