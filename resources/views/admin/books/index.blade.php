<x-layouts.admin title="Daftar Buku">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header Section -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-12 mb-8 relative z-10 rounded-b-3xl shadow-sm">
            <div class="max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="flex flex-col gap-2">
                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Manajemen Katalog</span>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 p-0 leading-none">Daftar Buku</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mt-2">
                        Kelola inventaris perpustakaan, perbarui data buku, dan pantau ketersediaan koleksi.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.books.create') }}" class="flex items-center gap-2 bg-primary text-on-primary hover:bg-primary/90 px-5 py-2.5 rounded-lg transition-colors shadow-md font-body-sm text-body-sm font-semibold">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Tambah Buku
                    </a>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <form method="GET" action="{{ route('admin.books.index') }}" class="max-w-container-max mx-auto mt-8 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari berdasarkan judul, penulis, atau ISBN..."
                        class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-12 pr-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-shadow shadow-sm"
                    >
                </div>
                <div class="flex gap-4">
                    <div class="relative min-w-[200px]">
                        <select
                            name="kategori"
                            onchange="this.form.submit()"
                            class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-4 pr-10 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary appearance-none cursor-pointer shadow-sm"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                    @if(request('q') || request('kategori'))
                        <a href="{{ route('admin.books.index') }}" class="px-4 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Main Content Area -->
        <div class="px-8 max-w-container-max mx-auto w-full flex-1">
            <!-- Summary Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 -mt-2">
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-white">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">library_books</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Total Eksemplar</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\Book::sum('stock') }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Tersedia</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\Book::sum('available_stock') }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-tertiary-container/20 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">sync</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Dipinjam</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\Book::sum('stock') - \App\Models\Book::sum('available_stock') }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Judul Koleksi</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\Book::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Table Container -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1000px]">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/50">
                                <th class="py-4 px-6 font-semibold w-16">Buku</th>
                                <th class="py-4 px-6 font-semibold">Judul &amp; Penulis</th>
                                <th class="py-4 px-6 font-semibold">Kategori</th>
                                <th class="py-4 px-6 font-semibold">Penerbit &amp; Tahun</th>
                                <th class="py-4 px-6 font-semibold text-center w-24">Stok</th>
                                <th class="py-4 px-6 font-semibold text-center w-24">Tersedia</th>
                                <th class="py-4 px-6 font-semibold text-center">Status</th>
                                <th class="py-4 px-6 font-semibold text-right w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                            @forelse ($books as $book)
                                <tr class="hover:bg-surface-container-low/50 transition-colors group">
                                    <td class="py-4 px-6">
                                        @if ($book->cover_image)
                                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-12 h-16 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-12 h-16 bg-surface-container-high rounded flex items-center justify-center text-on-surface-variant shadow-sm">
                                                <span class="material-symbols-outlined text-xl">menu_book</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <a href="{{ route('admin.books.show', $book) }}" class="font-semibold text-primary hover:text-secondary truncate max-w-[280px]" title="{{ $book->title }}">
                                                {{ $book->title }}
                                            </a>
                                            <span class="text-on-surface-variant mt-0.5 text-[13px]">{{ $book->author }}</span>
                                            @if($book->shelf_location)
                                                <span class="text-secondary text-[11px] font-medium mt-0.5">Rak: {{ $book->shelf_location }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-surface-container text-on-surface-variant text-[12px] font-medium border border-outline-variant/30">
                                            {{ $book->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="text-on-surface">{{ $book->publisher }}</span>
                                            <span class="text-on-surface-variant mt-0.5 text-[13px]">Tahun {{ $book->publication_year }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center font-semibold text-on-surface">{{ $book->stock }}</td>
                                    <td class="py-4 px-6 text-center font-semibold {{ $book->available_stock > 0 ? 'text-secondary' : 'text-error' }}">
                                        {{ $book->available_stock }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($book->available_stock > 0)
                                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-secondary-fixed/60 text-on-secondary-fixed-variant">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-error-container text-error">
                                                Habis Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.books.show', $book) }}" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-secondary transition-colors" title="Lihat Detail">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <a href="{{ route('admin.books.edit', $book) }}" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-secondary transition-colors" title="Edit Buku">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari katalog?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-error hover:bg-error-container/30 transition-colors" title="Hapus Buku">
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">library_books</span>
                                        <p class="font-title-sm text-title-sm">Belum ada data buku ditemukan.</p>
                                        <p class="font-body-sm text-body-sm mt-1">Silakan sesuaikan kata kunci pencarian atau tambahkan buku baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($books->hasPages())
                    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low/40">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
