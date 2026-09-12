<x-layouts.member title="Detail Buku - {{ $book->title }}">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Breadcrumb & Back -->
        <div class="flex items-center justify-between">
            <nav class="flex items-center gap-2 text-xs font-semibold text-on-surface-variant">
                <a href="{{ route('member.books.index') }}" class="hover:text-primary transition-colors">Katalog Buku</a>
                <span>/</span>
                <span class="text-primary truncate max-w-xs">{{ $book->title }}</span>
            </nav>
            <a href="{{ route('member.books.index') }}" class="text-xs font-semibold text-secondary hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Katalog
            </a>
        </div>

        <!-- Book Detail Card -->
        <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-10 border border-outline-variant/50 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                <!-- Cover Column -->
                <div class="md:col-span-4 flex flex-col items-center">
                    <div class="w-full max-w-[240px] aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-surface-container-high relative flex items-center justify-center border border-outline-variant/50">
                        @if ($book->cover_image)
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center text-on-surface-variant p-4 text-center">
                                <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">menu_book</span>
                                <span class="text-xs font-bold">{{ $book->title }}</span>
                            </div>
                        @endif

                        <div class="absolute top-3 right-3">
                            @if ($book->available_stock > 0)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary text-white shadow-sm">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-error text-white shadow-sm">
                                    Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Borrowing Action Form -->
                    <div class="w-full max-w-[240px] mt-6">
                        @if ($hasActiveBorrowing)
                            <div class="p-3 bg-secondary-container/15 border border-secondary/30 rounded-xl text-center">
                                <span class="material-symbols-outlined text-secondary text-2xl mb-1">info</span>
                                <p class="text-xs font-bold text-secondary">Buku Sedang Anda Pinjam</p>
                                <a href="{{ route('member.borrowings.current') }}" class="text-[11px] text-primary underline mt-1 block font-semibold">
                                    Lihat di Peminjaman Saya
                                </a>
                            </div>
                        @elseif ($book->available_stock <= 0)
                            <div class="p-3 bg-error-container/20 border border-error/30 rounded-xl text-center">
                                <p class="text-xs font-bold text-error">Stok Buku Sedang Kosong</p>
                                <p class="text-[11px] text-on-surface-variant mt-1">Silakan cek kembali beberapa hari lagi.</p>
                            </div>
                        @elseif (! $canBorrow)
                            <div class="p-3 bg-error-container/20 border border-error/30 rounded-xl text-center">
                                <p class="text-xs font-bold text-error">Batas Peminjaman Tercapai</p>
                                <p class="text-[11px] text-on-surface-variant mt-1">Anda sudah mencapai batas maksimal 3 buku pinjaman aktif.</p>
                            </div>
                        @else
                            <form method="POST" action="{{ route('member.borrowings.store') }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div>
                                    <input
                                        type="text"
                                        name="notes"
                                        placeholder="Catatan keperluan pinjam..."
                                        class="w-full bg-surface-container-lowest text-on-surface text-xs px-3 py-2 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary"
                                    >
                                </div>
                                <button
                                    type="submit"
                                    class="w-full py-3.5 px-4 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold flex items-center justify-center gap-2 shadow-md transition-all"
                                >
                                    <span class="material-symbols-outlined text-[20px]">outbound</span>
                                    Pinjam Buku Ini
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Metadata Column -->
                <div class="md:col-span-8 space-y-6">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-secondary-container/15 text-secondary text-xs font-bold uppercase tracking-wider mb-2">
                            {{ $book->category->name ?? 'Koleksi Umum' }}
                        </span>
                        <h1 class="font-display-lg text-display-lg text-primary font-bold leading-tight">{{ $book->title }}</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Oleh <strong class="text-on-surface">{{ $book->author }}</strong></p>
                    </div>

                    <!-- Key Spec Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-body-sm">
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-xs text-on-surface-variant block mb-1">Penerbit</span>
                            <span class="font-semibold text-on-surface">{{ $book->publisher }}</span>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-xs text-on-surface-variant block mb-1">Tahun Terbit</span>
                            <span class="font-semibold text-on-surface">{{ $book->publication_year }}</span>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-xs text-on-surface-variant block mb-1">ISBN</span>
                            <span class="font-semibold text-on-surface">{{ $book->isbn ?? '-' }}</span>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-xs text-on-surface-variant block mb-1">Lokasi Rak</span>
                            <span class="font-semibold text-secondary">{{ $book->shelf_location ?? 'Perpustakaan' }}</span>
                        </div>
                    </div>

                    <!-- Stock Counter -->
                    <div class="p-4 bg-surface-container-low rounded-xl border border-outline-variant/30 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-2xl text-secondary">inventory_2</span>
                            <div>
                                <p class="text-xs font-semibold text-on-surface-variant uppercase">Ketersediaan Koleksi</p>
                                <p class="font-bold text-base text-primary">Tersedia {{ $book->available_stock }} dari total {{ $book->stock }} eksemplar</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-on-surface-variant">Durasi Standar:</span>
                            <span class="font-semibold text-secondary block">7 Hari</span>
                        </div>
                    </div>

                    <!-- Synopsis -->
                    <div>
                        <h2 class="font-title-sm text-title-sm text-primary font-bold mb-2">Deskripsi & Sinopsis</h2>
                        <div class="text-body-sm text-on-surface-variant leading-relaxed bg-surface-container-low/40 p-5 rounded-2xl border border-outline-variant/20">
                            {{ $book->description ?? 'Deskripsi detail untuk buku ini belum tersedia.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.member>
