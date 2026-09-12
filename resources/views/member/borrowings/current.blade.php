<x-layouts.member title="Peminjaman Saya">
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-surface-container-low rounded-3xl p-6 sm:p-10 border border-outline-variant/40 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="font-label-caps text-label-caps text-secondary font-bold uppercase tracking-wider">Sirkulasi Aktif</span>
                <h1 class="font-display-lg text-display-lg text-primary font-bold mt-1 mb-2">Peminjaman Buku Saya</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                    Pantau masa peminjaman aktif dan pastikan mengembalikan buku ke meja sirkulasi perpustakaan sebelum tanggal jatuh tempo.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('member.borrowings.history') }}" class="px-5 py-3 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-xl font-body-sm text-body-sm font-semibold transition-colors">
                    Riwayat Selesai
                </a>
                <a href="{{ route('member.books.index') }}" class="px-5 py-3 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Pinjam Buku Lain
                </a>
            </div>
        </div>

        <!-- Borrowings List -->
        <div class="space-y-4">
            @forelse ($borrowings as $b)
                <div class="bg-surface-container-lowest rounded-2xl p-6 border {{ $b->isOverdue() ? 'border-error/40 shadow-error/10' : 'border-outline-variant/50' }} shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        <!-- Book Details -->
                        <div class="flex items-start gap-4 flex-1">
                            @if ($b->book->cover_image)
                                <img src="{{ $b->book->cover_image }}" alt="{{ $b->book->title }}" class="w-16 h-24 object-cover rounded-xl shadow-sm border border-outline-variant/40">
                            @else
                                <div class="w-16 h-24 bg-surface-container rounded-xl flex items-center justify-center text-on-surface-variant border border-outline-variant/40">
                                    <span class="material-symbols-outlined text-2xl">book</span>
                                </div>
                            @endif

                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold text-secondary">{{ $b->transaction_code }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded bg-surface-container text-on-surface-variant font-semibold">
                                        {{ $b->book->category->name ?? 'Koleksi' }}
                                    </span>
                                </div>
                                <h2 class="font-title-sm text-title-sm font-bold text-primary">
                                    <a href="{{ route('member.books.show', $b->book) }}" class="hover:text-secondary transition-colors">
                                        {{ $b->book->title }}
                                    </a>
                                </h2>
                                <p class="text-xs text-on-surface-variant">Penulis: {{ $b->book->author }} &bull; Rak: {{ $b->book->shelf_location ?? '-' }}</p>
                                @if($b->notes)
                                    <p class="text-xs text-on-surface-variant italic mt-1">Catatan: {{ $b->notes }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Date Timeline & Status -->
                        <div class="flex flex-wrap md:flex-nowrap items-center gap-6 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-4 md:pt-0 border-outline-variant/30">
                            <div class="text-left md:text-right">
                                <span class="text-xs text-on-surface-variant block">Tanggal Pinjam</span>
                                <span class="font-semibold text-body-sm text-on-surface">{{ $b->borrow_date->format('d M Y') }}</span>
                            </div>

                            <div class="text-left md:text-right">
                                <span class="text-xs text-on-surface-variant block">Batas Jatuh Tempo</span>
                                <span class="font-bold text-body-sm block {{ $b->isOverdue() ? 'text-error' : 'text-primary' }}">
                                    {{ $b->due_date->format('d M Y') }}
                                </span>
                            </div>

                            <div class="text-left md:text-right min-w-[140px]">
                                @if ($b->isOverdue())
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold uppercase bg-error-container text-error mb-1">
                                        Terlambat {{ $b->days_overdue }} Hari
                                    </span>
                                    <span class="text-xs text-error font-semibold block">Denda: Rp {{ number_format($b->days_overdue * 1000, 0, ',', '.') }}</span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold uppercase bg-secondary-container/20 text-secondary mb-1">
                                        {{ now()->diffInDays($b->due_date, false) }} Hari Tersisa
                                    </span>
                                    <span class="text-xs text-secondary font-medium block">Peminjaman Aktif</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-surface-container-lowest rounded-3xl p-12 text-center border border-outline-variant/40 space-y-4">
                    <span class="material-symbols-outlined text-6xl text-outline-variant">auto_stories</span>
                    <h2 class="font-title-sm text-title-sm font-bold text-primary">Tidak Ada Peminjaman Aktif</h2>
                    <p class="text-body-sm text-on-surface-variant max-w-md mx-auto">
                        Saat ini Anda tidak memiliki buku yang sedang dipinjam. Temukan koleksi menarik dan ajukan peminjaman sekarang.
                    </p>
                    <a href="{{ route('member.books.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold shadow-md transition-all">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                        Jelajahi Katalog Buku
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Instructions Footer Note -->
        <div class="p-6 bg-surface-container-low rounded-2xl border border-outline-variant/40 flex items-start gap-4">
            <span class="material-symbols-outlined text-secondary text-2xl mt-0.5">info</span>
            <div class="text-body-sm text-on-surface-variant space-y-1">
                <p class="font-bold text-primary">Prosedur Pengembalian Buku Perpustakaan SMKN 5:</p>
                <p>Bawa buku fisik ke meja sirkulasi perpustakaan di Gedung Utama SMKN 5. Petugas perpustakaan akan memindai transaksi dan memverifikasi kondisi fisik buku.</p>
            </div>
        </div>

        @if ($borrowings->hasPages())
            <div class="mt-8">
                {{ $borrowings->links() }}
            </div>
        @endif
    </div>
</x-layouts.member>
