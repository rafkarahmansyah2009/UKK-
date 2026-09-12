<x-layouts.public title="Katalog Buku - Library SMKN 5">
    <div class="bg-surface-container-low/50 py-10 px-4 sm:px-8 border-b border-outline-variant/40">
        <div class="max-w-container-max mx-auto">
            <h1 class="font-display-lg text-display-lg text-primary font-bold mb-2">Katalog Buku Perpustakaan</h1>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                Cari dan temukan buku berdasarkan judul, pengarang, nomor ISBN, atau kategori keahlian.
            </p>

            <!-- Search & Filter Bar -->
            <form action="{{ route('katalog') }}" method="GET" class="mt-6 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari judul buku, penulis, atau ISBN..."
                        class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl text-body-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none shadow-sm"
                    >
                </div>
                <div class="w-full md:w-64 relative">
                    <select
                        name="kategori"
                        onchange="this.form.submit()"
                        class="w-full pl-4 pr-10 py-3 bg-surface-container-lowest border border-outline-variant rounded-xl text-body-md focus:border-secondary focus:ring-1 focus:ring-secondary outline-none shadow-sm appearance-none"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('kategori') == $cat->id)>
                                {{ $cat->name }} ({{ $cat->books_count }})
                            </option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                </div>
                <button type="submit" class="px-6 py-3 bg-primary-container text-on-primary rounded-xl font-title-sm text-title-sm font-semibold hover:bg-primary-container/90 shadow-sm transition-colors">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="max-w-container-max mx-auto px-4 sm:px-8 py-12">
        @if ($books->isEmpty())
            <div class="p-12 text-center bg-surface-container-lowest rounded-2xl border border-outline-variant/60 max-w-lg mx-auto">
                <span class="material-symbols-outlined text-5xl text-outline mb-3">menu_book</span>
                <h3 class="font-title-sm text-title-sm font-bold text-on-surface mb-1">Buku Tidak Ditemukan</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Coba gunakan kata kunci pencarian lain atau reset filter kategori.</p>
                <a href="{{ route('katalog') }}" class="mt-4 inline-block px-4 py-2 bg-secondary text-white rounded-lg text-sm font-semibold">
                    Reset Filter
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($books as $book)
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
                                    <span class="px-2.5 py-1 rounded text-xs font-bold bg-secondary text-white shadow">
                                        {{ $book->available_stock }} Tersedia
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded text-xs font-bold bg-error text-white shadow">
                                        Sedang Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <span class="text-xs font-bold text-secondary uppercase mb-1 truncate">{{ $book->category->name }}</span>
                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface line-clamp-2 mb-1" title="{{ $book->title }}">{{ $book->title }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant truncate mb-2">Oleh: {{ $book->author }}</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 mb-4 text-xs">{{ $book->description ?? 'Tidak ada sinopsis tersedia.' }}</p>

                            <div class="mt-auto pt-4 border-t border-outline-variant/40 flex items-center justify-between text-xs text-on-surface-variant">
                                <span>Penerbit: {{ $book->publisher }}</span>
                                <span>Lokasi: <strong>{{ $book->shelf_location ?? '-' }}</strong></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</x-layouts.public>
