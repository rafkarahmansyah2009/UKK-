<x-layouts.admin title="Manajemen Denda">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header Section -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-12 mb-8 relative z-10 rounded-b-3xl shadow-sm">
            <div class="max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="flex flex-col gap-2">
                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Keuangan & Sirkulasi</span>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 p-0 leading-none">Manajemen Denda</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mt-2">
                        Kelola tagihan denda keterlambatan buku, proses pelunasan kasir perpustakaan, dan catat riwayat setoran.
                    </p>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <form method="GET" action="{{ route('admin.fines.index') }}" class="max-w-container-max mx-auto mt-8 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari nama anggota, NIS/NIP, atau kode transaksi..."
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
                            <option value="">Semua Status Denda</option>
                            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Lunas</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                    @if(request('q') || request('status'))
                        <a href="{{ route('admin.fines.index') }}" class="px-4 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Main Content Area -->
        <div class="px-8 max-w-container-max mx-auto w-full flex-1">
            <!-- Summary Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 -mt-2">
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-error-container flex items-center justify-center text-error">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">pending_actions</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Belum Dilunasi</p>
                        <p class="font-headline-md text-headline-md text-error">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Total Denda Terkumpul</p>
                        <p class="font-headline-md text-headline-md text-secondary">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Total Tagihan Denda</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\Fine::count() }} Kasus</p>
                    </div>
                </div>
            </div>

            <!-- Fines Table -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1050px]">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/50">
                                <th class="py-4 px-6 font-semibold">Kode Transaksi</th>
                                <th class="py-4 px-6 font-semibold">Anggota</th>
                                <th class="py-4 px-6 font-semibold">Buku Terkait</th>
                                <th class="py-4 px-6 font-semibold text-center">Keterlambatan</th>
                                <th class="py-4 px-6 font-semibold text-center">Jumlah Denda</th>
                                <th class="py-4 px-6 font-semibold text-center">Status</th>
                                <th class="py-4 px-6 font-semibold text-right w-44">Aksi / Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                            @forelse ($fines as $fine)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <span class="font-mono font-bold text-secondary">{{ $fine->borrowing->transaction_code ?? '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-primary">{{ $fine->user->name }}</span>
                                            <span class="text-xs text-on-surface-variant font-mono">
                                                {{ $fine->user->isSiswa() ? 'NIS: ' . ($fine->user->nis ?? '-') : 'NIP: ' . ($fine->user->nip ?? '-') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="truncate max-w-[240px]">
                                            <span class="font-semibold text-on-surface block truncate" title="{{ $fine->borrowing->book->title ?? '-' }}">
                                                {{ $fine->borrowing->book->title ?? '-' }}
                                            </span>
                                            <span class="text-xs text-on-surface-variant">
                                                Jatuh Tempo: {{ $fine->borrowing->due_date ? $fine->borrowing->due_date->format('d/m/Y') : '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-error-container/50 text-error">
                                            {{ $fine->days_overdue }} Hari
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="font-bold text-base {{ $fine->isPaid() ? 'text-secondary' : 'text-error' }}">
                                            {{ $fine->formatted_amount }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($fine->isPaid())
                                            <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-secondary-container/20 text-secondary">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-error-container text-error">
                                                Belum Lunas
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        @if ($fine->isPaid())
                                            <div class="text-right">
                                                <span class="text-xs text-on-surface-variant block">{{ $fine->payment_date ? $fine->payment_date->format('d/m/Y H:i') : '-' }}</span>
                                                <span class="text-[11px] text-secondary font-medium block">Diterima: {{ $fine->paidTo->name ?? 'Admin' }}</span>
                                            </div>
                                        @else
                                            <div x-data="{ openModal: false }" class="inline-block">
                                                <button
                                                    @click="openModal = true"
                                                    type="button"
                                                    class="px-3.5 py-2 bg-secondary text-on-secondary hover:bg-secondary/90 rounded-xl text-xs font-semibold flex items-center gap-1.5 shadow-sm transition-all ml-auto"
                                                >
                                                    <span class="material-symbols-outlined text-[16px]">payments</span>
                                                    Bayar Denda
                                                </button>

                                                <!-- Payment Confirmation Modal (Stitch: 35b36502064b4b0c927f01696bfcf34e) -->
                                                <div
                                                    x-show="openModal"
                                                    x-cloak
                                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 text-left"
                                                >
                                                    <div
                                                        @click.away="openModal = false"
                                                        class="bg-surface-container-lowest rounded-2xl shadow-xl max-w-md w-full p-6 border border-outline-variant space-y-5"
                                                    >
                                                        <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                                                            <div class="flex items-center gap-2">
                                                                <span class="material-symbols-outlined text-secondary">verified</span>
                                                                <h3 class="font-title-sm text-title-sm text-primary font-bold">Konfirmasi Pelunasan Denda</h3>
                                                            </div>
                                                            <button @click="openModal = false" class="text-on-surface-variant hover:text-on-surface">
                                                                <span class="material-symbols-outlined">close</span>
                                                            </button>
                                                        </div>

                                                        <div class="space-y-3 text-body-sm">
                                                            <div class="p-3 bg-surface-container-low rounded-xl flex items-center justify-between">
                                                                <span class="text-xs text-on-surface-variant">Peminjam:</span>
                                                                <span class="font-semibold text-primary">{{ $fine->user->name }}</span>
                                                            </div>
                                                            <div class="p-3 bg-surface-container-low rounded-xl flex items-center justify-between">
                                                                <span class="text-xs text-on-surface-variant">Keterlambatan:</span>
                                                                <span class="font-semibold text-error">{{ $fine->days_overdue }} Hari</span>
                                                            </div>
                                                            <div class="p-4 bg-secondary-container/15 rounded-xl flex items-center justify-between">
                                                                <span class="text-body-sm font-semibold text-secondary">Total Tagihan:</span>
                                                                <span class="font-bold text-xl text-secondary">{{ $fine->formatted_amount }}</span>
                                                            </div>
                                                        </div>

                                                        <form method="POST" action="{{ route('admin.fines.pay', $fine) }}" class="space-y-4">
                                                            @csrf
                                                            <div>
                                                                <label class="block text-xs font-semibold text-on-surface mb-1">Catatan Pembayaran / Kasir</label>
                                                                <input
                                                                    type="text"
                                                                    name="notes"
                                                                    value="Pembayaran tunai di meja sirkulasi perpustakaan."
                                                                    class="w-full bg-surface-container-lowest text-on-surface text-body-sm px-3 py-2 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary"
                                                                >
                                                            </div>

                                                            <div class="flex items-center justify-end gap-3 pt-2">
                                                                <button
                                                                    @click="openModal = false"
                                                                    type="button"
                                                                    class="px-4 py-2 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant text-xs font-semibold"
                                                                >
                                                                    Batal
                                                                </button>
                                                                <button
                                                                    type="submit"
                                                                    class="px-4 py-2 bg-secondary text-on-secondary hover:bg-secondary/90 rounded-xl text-xs font-semibold flex items-center gap-1.5 shadow-sm"
                                                                >
                                                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                                    Tandai Lunas
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">payments</span>
                                        <p class="font-title-sm text-title-sm">Tidak ada data denda perpustakaan yang ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($fines->hasPages())
                    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low/40">
                        {{ $fines->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
