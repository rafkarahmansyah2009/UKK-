<x-layouts.admin title="Pengembalian Buku">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header Section -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-12 mb-8 relative z-10 rounded-b-3xl shadow-sm">
            <div class="max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="flex flex-col gap-2">
                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Sirkulasi & Transaksi</span>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 p-0 leading-none">Pengembalian Buku</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mt-2">
                        Proses penerimaan buku yang dikembalikan, verifikasi denda keterlambatan, dan perbarui stok otomatis.
                    </p>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <form method="GET" action="{{ route('admin.returns.index') }}" class="max-w-container-max mx-auto mt-8 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari kode transaksi, nama anggota, NIS/NIP, atau judul buku..."
                        class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-12 pr-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-shadow shadow-sm"
                    >
                </div>
                <div class="flex gap-4">
                    <div class="relative min-w-[200px]">
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-4 pr-10 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary appearance-none cursor-pointer shadow-sm"
                        >
                            <option value="">Semua Transaksi</option>
                            <option value="borrowed" {{ request('status', 'borrowed') === 'borrowed' ? 'selected' : '' }}>Belum Dikembalikan</option>
                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                    @if(request('q') || request('status'))
                        <a href="{{ route('admin.returns.index') }}" class="px-4 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Main Content Area -->
        <div class="px-8 max-w-container-max mx-auto w-full flex-1">
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 -mt-2">
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">assignment_return</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Perlu Dikembalikan</p>
                        <p class="font-headline-md text-headline-md text-secondary">{{ \App\Models\Borrowing::whereIn('status', ['borrowed', 'overdue'])->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-error-container flex items-center justify-center text-error">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">timer_off</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Terlambat (Kena Denda)</p>
                        <p class="font-headline-md text-headline-md text-error">{{ \App\Models\Borrowing::whereIn('status', ['borrowed', 'overdue'])->where('due_date', '<', now())->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">task_alt</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Selesai Dikembalikan</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\Borrowing::where('status', 'returned')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1050px]">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/50">
                                <th class="py-4 px-6 font-semibold">Kode Transaksi</th>
                                <th class="py-4 px-6 font-semibold">Peminjam</th>
                                <th class="py-4 px-6 font-semibold">Buku Dipinjam</th>
                                <th class="py-4 px-6 font-semibold">Tgl Pinjam &amp; Tempo</th>
                                <th class="py-4 px-6 font-semibold text-center">Status Waktu</th>
                                <th class="py-4 px-6 font-semibold text-center">Denda</th>
                                <th class="py-4 px-6 font-semibold text-right w-44">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                            @forelse ($borrowings as $b)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <span class="font-mono font-bold text-secondary">{{ $b->transaction_code }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-primary">{{ $b->user->name }}</span>
                                            <span class="text-xs text-on-surface-variant font-mono">
                                                {{ $b->user->isSiswa() ? 'NIS: ' . ($b->user->nis ?? '-') : 'NIP: ' . ($b->user->nip ?? '-') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            @if ($b->book?->cover_image)
                                                <img src="{{ $b->book->cover_image }}" alt="{{ $b->book->title }}" class="w-9 h-12 object-cover rounded shadow-sm">
                                            @else
                                                <div class="w-9 h-12 bg-surface-container rounded flex items-center justify-center text-on-surface-variant">
                                                    <span class="material-symbols-outlined text-sm">book</span>
                                                </div>
                                            @endif
                                            <div class="truncate max-w-[240px]">
                                                <span class="font-semibold text-on-surface block truncate" title="{{ $b->book?->title ?? 'Buku Dihapus' }}">{{ $b->book?->title ?? 'Buku Dihapus' }}</span>
                                                <span class="text-xs text-on-surface-variant">{{ $b->book?->author ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-on-surface">
                                        <span class="text-xs text-on-surface-variant block">Pinjam: {{ $b->borrow_date->format('d/m/Y') }}</span>
                                        <span class="font-semibold block {{ $b->isOverdue() && $b->status !== 'returned' ? 'text-error' : 'text-on-surface' }}">
                                            Tempo: {{ $b->due_date->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($b->status === 'returned')
                                            <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-surface-container text-on-surface-variant">
                                                Dikembalikan
                                            </span>
                                        @elseif ($b->isOverdue())
                                            <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-error-container text-error">
                                                Terlambat {{ $b->days_overdue }} Hari
                                            </span>
                                        @else
                                            <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-secondary-container/20 text-secondary">
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($b->fine)
                                            <span class="font-bold text-xs {{ $b->fine->isPaid() ? 'text-secondary' : 'text-error' }}">
                                                {{ $b->fine->formatted_amount }}
                                                <span class="block text-[10px] font-normal">({{ $b->fine->isPaid() ? 'Lunas' : 'Belum Lunas' }})</span>
                                            </span>
                                        @elseif ($b->isOverdue() && $b->status !== 'returned')
                                            <span class="font-bold text-xs text-error">
                                                Rp {{ number_format($b->days_overdue * 1000, 0, ',', '.') }}
                                                <span class="block text-[10px] font-normal">(Perkiraan)</span>
                                            </span>
                                        @else
                                            <span class="text-xs text-on-surface-variant">Rp 0</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        @if ($b->status !== 'returned')
                                            <form method="POST" action="{{ route('admin.returns.process', $b) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin memproses pengembalian buku {{ $b->book?->title ?? 'ini' }}? Stok buku akan bertambah otomatis.');">
                                                @csrf
                                                <button type="submit" class="px-3.5 py-2 bg-secondary text-on-secondary hover:bg-secondary/90 rounded-xl text-xs font-semibold flex items-center gap-1.5 shadow-sm transition-all ml-auto">
                                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                    Proses Kembali
                                                </button>
                                            </form>
                                        @else
                                            <div class="text-right">
                                                <span class="text-xs text-on-surface-variant font-medium block">Kembali {{ $b->return_date ? $b->return_date->format('d/m/Y') : '' }}</span>
                                                <span class="text-[11px] text-secondary font-semibold">Tersimpan</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">assignment_returned</span>
                                        <p class="font-title-sm text-title-sm">Tidak ada transaksi peminjaman yang cocok.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($borrowings->hasPages())
                    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low/40">
                        {{ $borrowings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
