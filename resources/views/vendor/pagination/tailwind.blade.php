@if ($paginator->hasPages())
    <div class="flex justify-center gap-3 mt-8">

        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
            <span class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-gray-400 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="hover:bg-mustGreen flex items-center justify-center w-10 h-10 rounded-full border border-mustGreen hover:text-white text-mustBlue cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="flex items-center justify-center w-10 h-10 text-gray-500">...</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="bg-mustGreen flex items-center justify-center w-10 h-10 rounded-full border border-mustGreen text-white cursor-pointer font-medium">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="hover:bg-mustGreen flex items-center justify-center w-10 h-10 rounded-full border border-mustGreen hover:text-white text-mustBlue cursor-pointer font-medium">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="hover:bg-mustGreen flex items-center justify-center w-10 h-10 rounded-full border border-mustGreen hover:text-white text-mustBlue cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        @else
            <span class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 text-gray-400 cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>
        @endif
    </div>
@endif
