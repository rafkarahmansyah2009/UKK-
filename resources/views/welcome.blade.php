<x-layouts.public title="Library SMKN 5 - Perpustakaan Digital Sekolah Kejuruan">
    <!-- Hero Section -->
    <section class="relative bg-surface-container-low/60 border-b border-outline-variant/40 py-20 px-4 sm:px-8 overflow-hidden">
        <div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-container/15 text-secondary font-label-caps text-label-caps font-bold uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[16px]">school</span>
                    Sistem Perpustakaan Modern
                </div>
                <h1 class="font-display-lg text-display-lg text-primary font-bold leading-tight">
                    Akses Literasi & Referensi Kejuruan SMKN 5
                </h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                    Jelajahi ribuan koleksi buku kejuruan, modul praktik, literatur teknologi, fiksi, dan sains. Pantau masa peminjaman dan ketersediaan buku secara real-time.
                </p>
                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('katalog') }}" class="px-6 py-3.5 bg-primary-container text-on-primary rounded-xl font-title-sm text-title-sm font-semibold hover:bg-primary-container/90 transition-all shadow-md flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                        Cari Buku Sekarang
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="px-6 py-3.5 bg-surface-container-lowest text-primary border border-outline-variant rounded-xl font-title-sm text-title-sm font-semibold hover:bg-surface-container transition-all shadow-sm">
                            Daftar Anggota
                        </a>
                    @endguest
                </div>

                <!-- Live Quick Stats -->
                <div class="grid grid-cols-3 gap-6 pt-6 border-t border-outline-variant/40 max-w-lg">
                    <div>
                        <p class="font-display-lg text-display-lg text-primary font-bold">{{ number_format($stats['total_books']) }}</p>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Total Eksemplar</p>
                    </div>
                    <div>
                        <p class="font-display-lg text-display-lg text-secondary font-bold">{{ number_format($stats['total_titles']) }}</p>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Judul Buku</p>
                    </div>
                    <div>
                        <p class="font-display-lg text-display-lg text-tertiary font-bold">{{ number_format($stats['total_members']) }}</p>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Anggota Terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-outline-variant/50 bg-primary-container aspect-[4/3] flex items-center justify-center">
                    <img
                        src="https://lh3.googleusercontent.com/aida/AEtjO1ViBVzUdN9lFntFA6NpywFhnDFEAPCdKJqz02hvcSuvQVLQkAwY2MRXn656DPkWQ5NNXKw4IdEKCkisgTHD5qdg44mbw_xCddvkbbaHs_G7DAnLPg4Jm0-oI0TOJqowNmHsqVnsbpEWNuXPbUkQ9kKVjCnYSBZpw0ytwJEf-Fw28gVgFdaoslqNiJj8OM7EARZksx_0CvL0QoOYjKl29mhfnudD4h5MBhA-YX7Pa5X2HZt4f9gKvn8-Fg"
                        alt="Perpustakaan SMKN 5"
                        class="w-full h-full object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-2">SMK Negeri 5</span>
                        <h3 class="text-xl font-bold">Ruang Baca & Referensi Digital</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 px-4 sm:px-8 max-w-container-max mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="font-label-caps text-label-caps text-secondary font-bold uppercase tracking-wider">Koleksi Terstruktur</span>
                <h2 class="font-display-lg text-display-lg text-primary font-bold">Kategori Keahlian & Pengetahuan</h2>
            </div>
            <a href="{{ route('katalog') }}" class="font-body-sm text-body-sm text-secondary font-semibold hover:underline flex items-center gap-1">
                Lihat Semua <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach ($categories as $cat)
                <a href="{{ route('katalog', ['kategori' => $cat->id]) }}" class="p-6 bg-surface-container-lowest hover:bg-surface-container-low rounded-xl border border-outline-variant/60 hover:border-secondary transition-all text-center group shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-secondary-container/15 text-secondary flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl">category</span>
                    </div>
                    <h3 class="font-title-sm text-title-sm font-bold text-on-surface mb-1 truncate">{{ $cat->name }}</h3>
                    <p class="font-label-caps text-label-caps text-on-surface-variant">{{ $cat->books_count }} Judul</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Featured Books Section -->
    <section class="bg-surface-container-low/40 py-16 px-4 sm:px-8 border-y border-outline-variant/40">
        <div class="max-w-container-max mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="font-label-caps text-label-caps text-secondary font-bold uppercase tracking-wider">Koleksi Pilihan</span>
                    <h2 class="font-display-lg text-display-lg text-primary font-bold">Buku Populer & Terbaru</h2>
                </div>
                <a href="{{ route('katalog') }}" class="font-body-sm text-body-sm text-secondary font-semibold hover:underline flex items-center gap-1">
                    Jelajahi Katalog <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach ($featuredBooks as $book)
                    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/60 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-shadow">
                        <div class="aspect-[3/4] bg-surface-container-high relative overflow-hidden flex items-center justify-center">
                            @if ($book->cover_image)
                                <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-primary-container/10 flex flex-col items-center justify-center p-4 text-center">
                                    <span class="material-symbols-outlined text-4xl text-outline mb-2">menu_book</span>
                                    <span class="text-xs font-bold text-on-surface-variant">{{ $book->title }}</span>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2">
                                @if ($book->available_stock > 0)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary/90 text-white shadow-sm">Tersedia</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-error/90 text-white shadow-sm">Habis</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-1">
                            <span class="text-[11px] font-semibold text-secondary uppercase mb-1 truncate">{{ $book->category->name }}</span>
                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface line-clamp-2 mb-1" title="{{ $book->title }}">{{ $book->title }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant truncate mb-3">{{ $book->author }}</p>
                            
                            <div class="mt-auto pt-3 border-t border-outline-variant/40 flex items-center justify-between text-xs text-on-surface-variant">
                                <span>Tahun {{ $book->publication_year }}</span>
                                <span class="font-bold text-primary">{{ $book->available_stock }} sisa</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>
