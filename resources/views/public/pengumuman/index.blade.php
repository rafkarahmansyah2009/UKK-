<x-layouts.public title="Pengumuman Perpustakaan - Library SMKN 5">
    <!-- Header & Search Section -->
    <div class="bg-surface-container-low/50 py-10 px-4 sm:px-8 border-b border-outline-variant/40">
        <div class="max-w-container-max mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-4" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-secondary font-semibold">Pengumuman</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 text-secondary font-label-caps text-label-caps font-bold uppercase tracking-wider mb-2">
                        <span class="material-symbols-outlined text-[16px]">campaign</span>
                        Warta & Pengumuman Resmi
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary font-bold mb-2">Pengumuman Perpustakaan</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                        Pusat warta resmi perpustakaan mengenai penyesuaian jadwal operasional, informasi koleksi kejuruan baru, agenda literasi, serta prosedur layanan bagi siswa dan guru SMKN 5.
                    </p>
                </div>

                @if (request()->filled('q') || request()->filled('kategori'))
                <div>
                    <a href="{{ route('pengumuman') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface-container-lowest text-on-surface-variant hover:text-error border border-outline-variant rounded-xl text-sm font-semibold transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                        Reset Pencarian & Filter
                    </a>
                </div>
                @endif
            </div>

            <!-- Search & Filter Bar -->
            <form id="announcementSearchForm" action="{{ route('pengumuman') }}" method="GET" class="mt-8 flex flex-col md:flex-row gap-3">
                <div class="w-full md:w-72 relative">
                    <select
                        id="kategoriSelect"
                        name="kategori"
                        class="w-full pl-4 pr-10 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl text-body-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected(request('kategori')===$cat)>
                            {{ $cat }} ({{ $categoryCounts[$cat] ?? 0 }})
                        </option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                </div>

                <button
                    type="submit"
                    id="btnApplyFilter"
                    class="px-6 py-3 bg-primary-container text-on-primary rounded-xl font-title-sm text-title-sm font-semibold hover:bg-primary-container/90 active:scale-[0.98] shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer select-none shrink-0">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    <span>Terapkan</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Category Filter Chips & Main Content -->
    <div class="max-w-container-max mx-auto px-4 sm:px-8 py-10">
        <!-- Quick Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 scrollbar-none">
            <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider shrink-0 mr-1 flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">category</span>
                Kategori:
            </span>

            <a
                href="{{ route('pengumuman', request()->only('q')) }}"
                class="px-4 py-2 rounded-xl text-sm font-medium shrink-0 transition-all duration-200 {{ !request('kategori') ? 'bg-primary-container text-on-primary font-semibold shadow-sm' : 'bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container border border-outline-variant/60' }}">
                Semua ({{ $announcements->total() }})
            </a>

            @foreach ($categories as $categoryName)
            @php
            $isActive = request('kategori') === $categoryName;
            $query = array_merge(request()->only('q'), ['kategori' => $categoryName]);
            @endphp
            <a
                href="{{ route('pengumuman', $query) }}"
                class="px-4 py-2 rounded-xl text-sm font-medium shrink-0 transition-all duration-200 {{ $isActive ? 'bg-primary-container text-on-primary font-semibold shadow-sm' : 'bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container border border-outline-variant/60' }}">
                {{ $categoryName }}
                <span class="ml-1 text-xs opacity-75">({{ $categoryCounts[$categoryName] ?? 0 }})</span>
            </a>
            @endforeach
        </div>

        <!-- Filter Status Alert (if active) -->
        @if (request()->filled('q') || request()->filled('kategori'))
        <div class="mb-6 p-4 rounded-xl bg-surface-container border border-outline-variant/60 flex flex-wrap items-center justify-between gap-3 text-sm">
            <div class="flex items-center gap-2 text-on-surface">
                <span class="material-symbols-outlined text-secondary text-[20px]">info</span>
                <span>
                    Menampilkan hasil untuk:
                    @if (request('q'))
                    kata kunci <strong>"{{ request('q') }}"</strong>
                    @endif
                    @if (request('q') && request('kategori'))
                    dalam
                    @endif
                    @if (request('kategori'))
                    kategori <strong>"{{ request('kategori') }}"</strong>
                    @endif
                    ({{ $announcements->total() }} pengumuman ditemukan)
                </span>
            </div>
            <a href="{{ route('pengumuman') }}" class="text-xs font-semibold text-secondary hover:underline flex items-center gap-1">
                Hapus Filter
            </a>
        </div>
        @endif

        <!-- Announcement Cards Grid -->
        @if ($announcements->isEmpty())
        <div class="p-12 text-center bg-surface-container-lowest rounded-2xl border border-outline-variant/60 max-w-lg mx-auto my-8 shadow-sm">
            <div class="w-16 h-16 bg-surface-container-low rounded-2xl mx-auto flex items-center justify-center text-outline mb-4">
                <span class="material-symbols-outlined text-4xl">search_off</span>
            </div>
            <h3 class="font-title-sm text-title-sm font-bold text-on-surface mb-2">Pengumuman Tidak Ditemukan</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-sm mx-auto mb-6">
                Maaf, tidak ada pengumuman yang sesuai dengan kata kunci pencarian atau kategori yang Anda tentukan.
            </p>
            <a href="{{ route('pengumuman') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-secondary text-white rounded-xl text-sm font-semibold hover:bg-secondary-container transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px]">refresh</span>
                Lihat Semua Pengumuman
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach ($announcements as $item)
            @php
            // Determine Category Style
            $categoryClass = match($item['category']) {
            'Layanan & Operasional' => 'bg-amber-50 text-amber-900 border-amber-200/80',
            'Koleksi & Referensi' => 'bg-blue-50 text-blue-900 border-blue-200/80',
            'Kegiatan & Literasi' => 'bg-emerald-50 text-emerald-900 border-emerald-200/80',
            'Fasilitas & Sistem' => 'bg-purple-50 text-purple-900 border-purple-200/80',
            default => 'bg-surface-container text-on-surface-variant border-outline-variant/60',
            };

            $iconClass = match($item['category']) {
            'Layanan & Operasional' => 'text-amber-700 bg-amber-100',
            'Koleksi & Referensi' => 'text-blue-700 bg-blue-100',
            'Kegiatan & Literasi' => 'text-emerald-700 bg-emerald-100',
            'Fasilitas & Sistem' => 'text-purple-700 bg-purple-100',
            default => 'text-secondary bg-secondary/10',
            };
            @endphp

            <article class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group overflow-hidden">
                <!-- Card Header Accent -->
                <div class="p-6 pb-4 flex flex-col flex-1">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $categoryClass }}">
                            <span class="material-symbols-outlined text-[15px]">{{ $item['icon'] ?? 'campaign' }}</span>
                            {{ $item['category'] }}
                        </span>
                        <span class="text-xs text-on-surface-variant font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">timer</span>
                            {{ $item['read_time'] }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="font-title-sm text-title-sm font-bold text-on-surface group-hover:text-secondary transition-colors line-clamp-2 mb-3 leading-snug">
                        <a href="{{ route('pengumuman.show', $item['slug']) }}">
                            {{ $item['title'] }}
                        </a>
                    </h2>

                    <!-- Excerpt -->
                    <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3 mb-6 leading-relaxed flex-1">
                        {{ $item['excerpt'] }}
                    </p>

                    <!-- Meta & CTA -->
                    <div class="pt-4 border-t border-outline-variant/40 flex items-center justify-between gap-3 text-xs text-on-surface-variant">
                        <div class="flex items-center gap-1.5 truncate">
                            <span class="material-symbols-outlined text-[16px] text-outline">calendar_today</span>
                            <span>{{ $item['published_at'] }}</span>
                        </div>

                        <a
                            href="{{ route('pengumuman.show', $item['slug']) }}"
                            class="inline-flex items-center gap-1 font-bold text-secondary group-hover:text-secondary-container transition-colors shrink-0 group-hover:underline">
                            Baca Selengkapnya
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination Container -->
        <div class="mt-12 pt-6 border-t border-outline-variant/30 flex justify-center w-full">
            {{ $announcements->links() }}
        </div>
        @endif
    </div>

    <!-- JavaScript Filter & Search Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('announcementSearchForm');
            const searchInput = document.getElementById('searchInput');
            const kategoriSelect = document.getElementById('kategoriSelect');
            const btnApplyFilter = document.getElementById('btnApplyFilter');

            if (!form) return;

            function executeFilter(e) {
                if (e) {
                    e.preventDefault();
                }

                const queryVal = searchInput ? searchInput.value.trim() : '';
                const categoryVal = kategoriSelect ? kategoriSelect.value.trim() : '';

                const params = new URLSearchParams();

                if (queryVal !== '') {
                    params.set('q', queryVal);
                }

                if (categoryVal !== '') {
                    params.set('kategori', categoryVal);
                }

                // Reset pagination to page 1 on search or filter change
                const baseUrl = "{{ route('pengumuman') }}";
                const queryString = params.toString();
                const targetUrl = queryString ? `${baseUrl}?${queryString}` : baseUrl;

                window.location.href = targetUrl;
            }

            // 1. Handle Form Submit (default submit, form.submit(), or button click)
            form.addEventListener('submit', executeFilter);

            // 2. Handle Terapkan Button Click explicitly
            if (btnApplyFilter) {
                btnApplyFilter.addEventListener('click', function(e) {
                    executeFilter(e);
                });
            }

            // 3. Handle Enter Key on Search Input
            if (searchInput) {
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        executeFilter(e);
                    }
                });
            }

            // 4. Handle Category Dropdown Change (instant filtering)
            if (kategoriSelect) {
                kategoriSelect.addEventListener('change', function(e) {
                    executeFilter(e);
                });
            }
        });
    </script>
</x-layouts.public>