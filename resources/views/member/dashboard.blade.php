<x-layouts.member title="Dashboard Anggota">
    <div class="space-y-8">
        <!-- Welcome Hero Banner -->
        <div class="relative bg-surface-container-low rounded-3xl p-6 sm:p-10 overflow-hidden border border-outline-variant/40 shadow-sm">
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-container/15 text-secondary font-label-caps text-label-caps font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        Kartu Anggota Digital
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary font-bold leading-tight">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                        {{ auth()->user()->isSiswa() ? 'Siswa Kelas ' . (auth()->user()->class ?? '-') . ' (' . (auth()->user()->major ?? 'SMKN 5') . ') - NIS: ' . (auth()->user()->nis ?? '-') : 'Dewan Guru SMKN 5 - NIP: ' . (auth()->user()->nip ?? '-') }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('member.books.index') }}" class="px-6 py-3.5 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-title-sm text-title-sm font-semibold shadow-md flex items-center gap-2 transition-all">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                        Cari Buku
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/40 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-2xl bg-secondary-container/15 text-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">book</span>
                </div>
                <div>
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Buku Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-on-surface">{{ $totalActive }}</p>
                    <span class="text-xs text-secondary mt-1 block">Maksimal 3 buku</span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/40 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-2xl {{ $totalOverdue > 0 ? 'bg-error-container text-error' : 'bg-surface-container text-on-surface-variant' }} flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">alarm</span>
                </div>
                <div>
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Terlambat Pengembalian</p>
                    <p class="text-3xl font-bold {{ $totalOverdue > 0 ? 'text-error' : 'text-on-surface' }}">{{ $totalOverdue }}</p>
                    <span class="text-xs {{ $totalOverdue > 0 ? 'text-error' : 'text-on-surface-variant' }} mt-1 block">
                        {{ $totalOverdue > 0 ? 'Segera kembalikan ke perpustakaan' : 'Tidak ada pinjaman terlambat' }}
                    </span>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/40 flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-14 h-14 rounded-2xl {{ $unpaidFines > 0 ? 'bg-error-container text-error' : 'bg-secondary-container/15 text-secondary' }} flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">payments</span>
                </div>
                <div>
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Tagihan Denda Aktif</p>
                    <p class="text-2xl font-bold {{ $unpaidFines > 0 ? 'text-error' : 'text-secondary' }}">
                        Rp {{ number_format($unpaidFines, 0, ',', '.') }}
                    </p>
                    <span class="text-xs text-on-surface-variant mt-1 block">
                        {{ $unpaidFines > 0 ? 'Harap selesaikan di kasir perpustakaan' : 'Bebas denda perpustakaan' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Section 1: Peminjaman Aktif -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/40 overflow-hidden">
            <div class="p-6 border-b border-outline-variant/30 flex items-center justify-between">
                <div>
                    <h2 class="font-title-sm text-title-sm text-primary font-bold">Peminjaman Aktif Anda</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Daftar buku yang sedang Anda bawa dan batas waktu pengembalian</p>
                </div>
                <a href="{{ route('member.borrowings.current') }}" class="text-xs font-semibold text-secondary hover:underline flex items-center gap-1">
                    Lihat Semua
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low text-on-surface text-xs font-semibold border-b border-outline-variant/30">
                            <th class="py-3 px-6">Buku</th>
                            <th class="py-3 px-6">Tanggal Pinjam</th>
                            <th class="py-3 px-6">Batas Tempo</th>
                            <th class="py-3 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-sm divide-y divide-outline-variant/20">
                        @forelse ($activeBorrowings as $b)
                            <tr class="hover:bg-surface-container-low/40 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @if ($b->book->cover_image)
                                            <img src="{{ $b->book->cover_image }}" alt="{{ $b->book->title }}" class="w-10 h-14 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-10 h-14 bg-surface-container rounded flex items-center justify-center text-on-surface-variant">
                                                <span class="material-symbols-outlined text-base">book</span>
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('member.books.show', $b->book) }}" class="font-semibold text-primary hover:text-secondary block">
                                                {{ $b->book->title }}
                                            </a>
                                            <span class="text-xs text-on-surface-variant">{{ $b->book->author }}</span>
                                            <span class="text-[11px] font-mono text-secondary block mt-0.5">Kode: {{ $b->transaction_code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-on-surface text-xs">
                                    {{ $b->borrow_date->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-xs font-semibold block {{ $b->isOverdue() ? 'text-error' : 'text-on-surface' }}">
                                        {{ $b->due_date->format('d M Y') }}
                                    </span>
                                    @if ($b->isOverdue())
                                        <span class="text-[11px] text-error font-medium">Terlambat {{ $b->days_overdue }} hari</span>
                                    @else
                                        <span class="text-[11px] text-secondary font-medium">{{ now()->diffInDays($b->due_date, false) }} hari tersisa</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($b->isOverdue())
                                        <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase bg-error-container text-error">
                                            Terlambat
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase bg-secondary-container/20 text-secondary">
                                            Sedang Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-outline-variant">menu_book</span>
                                    <p class="font-semibold text-body-sm">Anda tidak sedang meminjam buku saat ini.</p>
                                    <a href="{{ route('member.books.index') }}" class="inline-block mt-2 text-xs font-semibold text-secondary hover:underline">
                                        Jelajahi Katalog Buku &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 2: Rekomendasi Buku -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-headline-md text-headline-md font-bold text-primary">Rekomendasi Koleksi Buku</h2>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Buku kejuruan dan referensi pilihan yang siap dipinjam</p>
                </div>
                <a href="{{ route('member.books.index') }}" class="text-xs font-semibold text-secondary hover:underline flex items-center gap-1">
                    Lihat Semua Buku
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($recommendedBooks as $book)
                    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/50 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-all">
                        <div class="aspect-[3/4] bg-surface-container-high relative overflow-hidden flex items-center justify-center">
                            @if ($book->cover_image)
                                <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-secondary-container/10 flex flex-col items-center justify-center p-4 text-center">
                                    <span class="material-symbols-outlined text-4xl text-outline mb-2">menu_book</span>
                                    <span class="text-xs font-bold text-on-surface-variant">{{ $book->title }}</span>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary/90 text-white shadow-sm">
                                    Tersedia ({{ $book->available_stock }})
                                </span>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-1">
                            <span class="text-[11px] font-semibold text-secondary uppercase mb-1 truncate">{{ $book->category->name ?? 'Umum' }}</span>
                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface line-clamp-2 mb-1" title="{{ $book->title }}">{{ $book->title }}</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant truncate mb-4">{{ $book->author }}</p>

                            <div class="mt-auto pt-3 border-t border-outline-variant/40 flex items-center gap-2">
                                <a href="{{ route('member.books.show', $book) }}" class="flex-1 py-2 text-center text-xs font-semibold bg-secondary-container/15 text-secondary hover:bg-secondary-container/25 rounded-xl transition-colors">
                                    Detail
                                </a>
                                <form method="POST" action="{{ route('member.borrowings.store') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit" class="w-full py-2 text-center text-xs font-semibold bg-primary text-on-primary hover:bg-primary/90 rounded-xl shadow-sm transition-colors flex items-center justify-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">outbound</span>
                                        Pinjam
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.member>
