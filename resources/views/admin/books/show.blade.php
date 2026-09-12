<x-layouts.admin title="Detail Buku - {{ $book->title }}">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-10 mb-8 rounded-b-3xl shadow-sm">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant text-body-sm mb-1">
                        <a href="{{ route('admin.books.index') }}" class="hover:text-primary transition-colors">Daftar Buku</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Detail Buku</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 leading-tight">{{ $book->title }}</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Oleh <strong class="text-on-surface">{{ $book->author }}</strong> &bull; Kategori: <span class="text-secondary font-medium">{{ $book->category->name ?? '-' }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.books.edit', $book) }}" class="px-5 py-2.5 bg-secondary text-on-secondary hover:bg-secondary/90 rounded-xl font-body-sm text-body-sm font-semibold flex items-center gap-2 shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Data
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="px-4 py-2.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold flex items-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="max-w-5xl mx-auto w-full px-4 sm:px-8 space-y-8">
            <!-- Book Info Card -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <!-- Cover -->
                    <div class="md:col-span-4 flex flex-col items-center">
                        <div class="w-full max-w-[240px] aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-surface-container-high relative flex items-center justify-center border border-outline-variant/50">
                            @if ($book->cover_image)
                                <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-6xl mb-2 text-outline-variant">menu_book</span>
                                    <span class="text-xs font-semibold">Tidak ada sampul</span>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                @if ($book->available_stock > 0)
                                    <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-secondary-fixed/90 text-on-secondary-fixed-variant shadow-sm">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-error-container/90 text-error shadow-sm">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Action -->
                        <div class="w-full max-w-[240px] mt-6">
                            @if($book->available_stock > 0)
                                <a href="{{ route('admin.borrowings.create', ['book_id' => $book->id]) }}" class="w-full py-3 px-4 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold flex items-center justify-center gap-2 shadow-sm transition-all">
                                    <span class="material-symbols-outlined text-[20px]">outbound</span>
                                    Buat Peminjaman
                                </a>
                            @else
                                <button disabled class="w-full py-3 px-4 bg-surface-container text-on-surface-variant rounded-xl font-body-sm text-body-sm font-semibold flex items-center justify-center gap-2 cursor-not-allowed opacity-75">
                                    <span class="material-symbols-outlined text-[20px]">block</span>
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="md:col-span-8 space-y-6">
                        <!-- Key Stat Counters -->
                        <div class="grid grid-cols-3 gap-4 p-4 bg-surface-container-low rounded-xl border border-outline-variant/30">
                            <div>
                                <p class="text-xs text-on-surface-variant uppercase font-semibold">Total Stok</p>
                                <p class="text-2xl font-bold text-on-surface mt-0.5">{{ $book->stock }} <span class="text-xs font-normal text-on-surface-variant">eks</span></p>
                            </div>
                            <div>
                                <p class="text-xs text-secondary uppercase font-semibold">Tersedia</p>
                                <p class="text-2xl font-bold text-secondary mt-0.5">{{ $book->available_stock }} <span class="text-xs font-normal text-on-surface-variant">eks</span></p>
                            </div>
                            <div>
                                <p class="text-xs text-tertiary-container uppercase font-semibold">Dipinjam</p>
                                <p class="text-2xl font-bold text-on-surface mt-0.5">{{ $book->borrowed_count }} <span class="text-xs font-normal text-on-surface-variant">eks</span></p>
                            </div>
                        </div>

                        <!-- Specifications Grid -->
                        <div class="grid grid-cols-2 gap-4 text-body-sm">
                            <div class="p-3 bg-surface-container-lowest border border-outline-variant/40 rounded-xl">
                                <span class="text-xs text-on-surface-variant block mb-1">Penerbit</span>
                                <span class="font-semibold text-on-surface">{{ $book->publisher }}</span>
                            </div>
                            <div class="p-3 bg-surface-container-lowest border border-outline-variant/40 rounded-xl">
                                <span class="text-xs text-on-surface-variant block mb-1">Tahun Terbit</span>
                                <span class="font-semibold text-on-surface">{{ $book->publication_year }}</span>
                            </div>
                            <div class="p-3 bg-surface-container-lowest border border-outline-variant/40 rounded-xl">
                                <span class="text-xs text-on-surface-variant block mb-1">ISBN</span>
                                <span class="font-semibold text-on-surface">{{ $book->isbn ?? '-' }}</span>
                            </div>
                            <div class="p-3 bg-surface-container-lowest border border-outline-variant/40 rounded-xl">
                                <span class="text-xs text-on-surface-variant block mb-1">Lokasi Rak</span>
                                <span class="font-semibold text-secondary">{{ $book->shelf_location ?? 'Belum ditentukan' }}</span>
                            </div>
                        </div>

                        <!-- Synopsis -->
                        <div>
                            <h3 class="font-title-sm text-title-sm text-primary mb-2">Sinopsis / Deskripsi</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed bg-surface-container-low/40 p-4 rounded-xl border border-outline-variant/20">
                                {{ $book->description ?? 'Tidak ada ringkasan atau sinopsis yang tercatat untuk buku ini.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History of This Book -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/40 flex items-center justify-between">
                    <div>
                        <h3 class="font-title-sm text-title-sm text-primary">Riwayat Sirkulasi Buku</h3>
                        <p class="text-xs text-on-surface-variant mt-0.5">Daftar peminjaman terbaru untuk judul buku ini</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/40">
                                <th class="py-3 px-6 text-xs font-semibold">Kode Transaksi</th>
                                <th class="py-3 px-6 text-xs font-semibold">Nama Peminjam</th>
                                <th class="py-3 px-6 text-xs font-semibold">Tgl Pinjam</th>
                                <th class="py-3 px-6 text-xs font-semibold">Batas Kembali</th>
                                <th class="py-3 px-6 text-xs font-semibold">Tgl Dikembalikan</th>
                                <th class="py-3 px-6 text-xs font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-body-sm divide-y divide-outline-variant/30">
                            @forelse ($book->borrowings as $b)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-3 px-6 font-mono font-medium text-secondary">{{ $b->transaction_code }}</td>
                                    <td class="py-3 px-6 font-medium text-on-surface">{{ $b->user->name }}</td>
                                    <td class="py-3 px-6 text-on-surface-variant">{{ $b->borrow_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-6 text-on-surface-variant">{{ $b->due_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-6 text-on-surface-variant">{{ $b->return_date ? $b->return_date->format('d/m/Y') : '-' }}</td>
                                    <td class="py-3 px-6 text-center">
                                        @if ($b->status === 'returned')
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant">Selesai</span>
                                        @elseif ($b->status === 'overdue' || $b->isOverdue())
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-error-container text-error">Terlambat</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-secondary-container/20 text-secondary">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-on-surface-variant text-body-sm">
                                        Belum ada riwayat transaksi peminjaman untuk buku ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
