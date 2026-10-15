@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col sm:flex-row items-center justify-between gap-4 py-6 w-full">
        <!-- Results summary on the left -->
        <div class="text-sm text-on-surface-variant font-medium order-2 sm:order-1 text-center sm:text-left">
            Menampilkan
            <span class="font-bold text-on-surface">{{ $paginator->firstItem() }}</span>
            sampai
            <span class="font-bold text-on-surface">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-bold text-on-surface">{{ $paginator->total() }}</span>
            pengumuman
        </div>

        <!-- Pagination Controls with generous touch target & gaps -->
        <ul class="flex items-center gap-2 flex-wrap justify-center order-1 sm:order-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="inline-flex items-center gap-1.5 min-h-[42px] px-3.5 sm:px-4 py-2 bg-surface-container-low/60 text-outline border border-outline-variant/30 rounded-xl text-sm font-medium cursor-not-allowed opacity-50 select-none">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-1.5 min-h-[42px] px-3.5 sm:px-4 py-2 bg-surface-container-lowest text-on-surface border border-outline-variant/60 rounded-xl text-sm font-medium hover:bg-surface-container hover:text-secondary hover:border-secondary transition-all duration-200 shadow-sm hover:shadow active:scale-95" aria-label="@lang('pagination.previous')">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li aria-disabled="true">
                        <span class="min-w-[42px] h-[42px] flex items-center justify-center text-outline font-bold select-none">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page">
                                <span class="min-w-[42px] h-[42px] px-3.5 flex items-center justify-center bg-primary-container text-on-primary rounded-xl text-sm font-bold shadow-md ring-2 ring-primary/20 select-none">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" class="min-w-[42px] h-[42px] px-3.5 flex items-center justify-center bg-surface-container-lowest text-on-surface border border-outline-variant/60 rounded-xl text-sm font-medium hover:bg-surface-container hover:text-secondary hover:border-secondary transition-all duration-200 shadow-sm hover:shadow active:scale-95" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-1.5 min-h-[42px] px-3.5 sm:px-4 py-2 bg-surface-container-lowest text-on-surface border border-outline-variant/60 rounded-xl text-sm font-medium hover:bg-surface-container hover:text-secondary hover:border-secondary transition-all duration-200 shadow-sm hover:shadow active:scale-95" aria-label="@lang('pagination.next')">
                        <span class="hidden sm:inline">Berikutnya</span>
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </a>
                </li>
            @else
                <li aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="inline-flex items-center gap-1.5 min-h-[42px] px-3.5 sm:px-4 py-2 bg-surface-container-low/60 text-outline border border-outline-variant/30 rounded-xl text-sm font-medium cursor-not-allowed opacity-50 select-none">
                        <span class="hidden sm:inline">Berikutnya</span>
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
