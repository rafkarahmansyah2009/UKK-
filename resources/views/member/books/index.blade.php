<x-layouts.member title="Katalog Koleksi Buku">
    <div class="space-y-8">
        <!-- Header & Search -->
        <div class="bg-surface-container-low rounded-3xl p-6 sm:p-10 border border-outline-variant/40 shadow-sm">
            <div class="max-w-2xl">
                <span class="font-label-caps text-label-caps text-secondary font-bold uppercase tracking-wider">Perpustakaan Digital</span>
                <h1 class="font-display-lg text-display-lg text-primary font-bold mt-1 mb-2">Katalog Buku SMKN 5</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Temukan referensi kejuruan, literatur teknologi, fiksi, dan sains. Anda dapat meminjam buku langsung melalui sistem ini.
                </p>
            </div>

            <!-- Search Bar & Filters -->
            <form method="GET" action="{{ route('member.books.index') }}" class="mt-8 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari judul buku, nama penulis, atau ISBN..."
                        class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-12 pr-4 py-3.5 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary shadow-sm"
                    >
                </div>
                <div class="flex gap-4">
                    <div class="relative min-w-[200px]">
                        <select
                            name="kategori"
                            onchange="this.form.submit()"
                            class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-4 pr-10 py-3.5 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary appearance-none cursor-pointer shadow-sm"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->books_count }})
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                    @if(request('q') || request('kategori'))
                        <a href="{{ route('member.books.index') }}" class="px-5 py-3.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm flex items-center justify-center font-semibold">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Books Grid -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <p class="text-body-sm text-on-surface-variant">
                    Menampilkan <strong class="text-on-surface">{{ $books->total() }}</strong> judul koleksi buku
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($books as $book)
                    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/50 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-outline transition-all">
                        <!-- Cover Image -->
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
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-secondary/90 text-white shadow-sm">
                                        Tersedia ({{ $book->available_stock }})
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-error/90 text-white shadow-sm">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4 flex flex-col flex-1">
                            <span class="text-[11px] font-semibold text-secondary uppercase mb-1 truncate">
                                {{ $book->category->name ?? 'Umum' }}
                            </span>
                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface line-clamp-2 mb-1" title="{{ $book->title }}">
                                {{ $book->title }}
                            </h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant truncate mb-2">{{ $book->author }}</p>
                            
                            <div class="text-xs text-on-surface-variant flex items-center justify-between mb-4">
                                <span>Tahun {{ $book->publication_year }}</span>
                                <span>Rak: {{ $book->shelf_location ?? '-' }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="mt-auto pt-3 border-t border-outline-variant/40 flex items-center gap-2">
                                <a href="{{ route('member.books.show', $book) }}" class="flex-1 py-2.5 text-center text-xs font-semibold bg-surface-container hover:bg-surface-container-high text-on-surface rounded-xl transition-colors">
                                    Detail
                                </a>
                                @if ($book->available_stock > 0)
                                    <form method="POST" action="{{ route('member.borrowings.store') }}" class="flex-1" onsubmit="return confirm('Ajukan peminjaman buku {{ $book->title }}?');">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" class="w-full py-2.5 text-center text-xs font-semibold bg-primary text-on-primary hover:bg-primary/90 rounded-xl shadow-sm transition-colors flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">outbound</span>
                                            Pinjam
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="flex-1 py-2.5 text-center text-xs font-semibold bg-surface-container text-on-surface-variant rounded-xl cursor-not-allowed opacity-75">
                                        Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">search_off</span>
                        <p class="font-title-sm text-title-sm font-bold">Tidak ada buku yang cocok dengan pencarian.</p>
                        <p class="text-body-sm mt-1">Coba gunakan kata kunci lain atau pilih semua kategori.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($books->hasPages())
                <div class="mt-10">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.member>
