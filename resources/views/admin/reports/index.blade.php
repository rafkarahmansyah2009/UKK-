<x-layouts.admin title="Laporan Perpustakaan">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header Section -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-12 mb-8 relative z-10 rounded-b-3xl shadow-sm print:hidden">
            <div class="max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="flex flex-col gap-2">
                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Rekapitulasi & Statistik</span>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 p-0 leading-none">Laporan Perpustakaan</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mt-2">
                        Rekapitulasi sirkulasi peminjaman, pengembalian, dan pendapatan denda perpustakaan SMKN 5 berdasarkan periode tanggal.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="window.print()" class="flex items-center gap-2 bg-primary text-on-primary hover:bg-primary/90 px-5 py-2.5 rounded-xl transition-colors shadow-md font-body-sm text-body-sm font-semibold">
                        <span class="material-symbols-outlined text-[20px]">print</span>
                        Cetak Laporan
                    </button>
                </div>
            </div>

            <!-- Date Range Filter Form -->
            <form method="GET" action="{{ route('admin.reports.index') }}" class="max-w-container-max mx-auto mt-8 flex flex-col sm:flex-row items-end gap-4">
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1">Dari Tanggal:</label>
                    <input
                        type="date"
                        name="start_date"
                        value="{{ $startDate }}"
                        class="bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-2.5 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary shadow-sm"
                    >
                </div>
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1">Sampai Tanggal:</label>
                    <input
                        type="date"
                        name="end_date"
                        value="{{ $endDate }}"
                        class="bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-2.5 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary shadow-sm"
                    >
                </div>
                <button type="submit" class="px-5 py-2.5 bg-secondary text-on-secondary hover:bg-secondary/90 rounded-xl font-body-sm text-body-sm font-semibold flex items-center gap-2 shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                    Filter Periode
                </button>
            </form>
        </div>

        <!-- Print-only Title Header -->
        <div class="hidden print:block mb-8 text-center border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-900">PERPUSTAKAAN SMKN 5</h1>
            <h2 class="text-lg font-semibold text-gray-700">Laporan Sirkulasi & Transaksi Peminjaman</h2>
            <p class="text-sm text-gray-500">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
        </div>

        <!-- Main Content Area -->
        <div class="px-8 max-w-container-max mx-auto w-full flex-1">
            <!-- Metric Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8 -mt-2 print:grid-cols-5">
                <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/30">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Total Sirkulasi</p>
                    <p class="text-2xl font-bold text-on-surface">{{ $totalTransactions }}</p>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/30">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Kembali Sukses</p>
                    <p class="text-2xl font-bold text-secondary">{{ $returnedCount }}</p>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/30">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Sedang Dipinjam</p>
                    <p class="text-2xl font-bold text-primary">{{ $activeCount }}</p>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/30">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Terlambat</p>
                    <p class="text-2xl font-bold text-error">{{ $overdueCount }}</p>
                </div>
                <div class="bg-surface-container-lowest p-4 rounded-xl shadow-sm border border-outline-variant/30 col-span-2 lg:col-span-1">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Denda Terkumpul</p>
                    <p class="text-xl font-bold text-secondary">Rp {{ number_format($finesCollected, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Report Table -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1000px]">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/50">
                                <th class="py-3 px-4 font-semibold text-xs">No</th>
                                <th class="py-3 px-6 font-semibold text-xs">Kode Transaksi</th>
                                <th class="py-3 px-6 font-semibold text-xs">Peminjam</th>
                                <th class="py-3 px-6 font-semibold text-xs">Judul Buku</th>
                                <th class="py-3 px-6 font-semibold text-xs">Tgl Pinjam</th>
                                <th class="py-3 px-6 font-semibold text-xs">Batas Waktu</th>
                                <th class="py-3 px-6 font-semibold text-xs">Tgl Kembali</th>
                                <th class="py-3 px-6 font-semibold text-xs text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                            @forelse ($transactions as $index => $t)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-3.5 px-4 text-xs text-on-surface-variant">{{ $transactions->firstItem() + $index }}</td>
                                    <td class="py-3.5 px-6 font-mono font-bold text-secondary text-xs">{{ $t->transaction_code }}</td>
                                    <td class="py-3.5 px-6">
                                        <span class="font-semibold text-primary block">{{ $t->user->name }}</span>
                                        <span class="text-xs text-on-surface-variant">
                                            {{ $t->user->isSiswa() ? 'Siswa (' . ($t->user->class ?? '-') . ')' : 'Guru' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6">
                                        <span class="font-medium text-on-surface block max-w-[280px] truncate" title="{{ $t->book->title }}">
                                            {{ $t->book->title }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-6 text-xs text-on-surface whitespace-nowrap">{{ $t->borrow_date->format('d/m/Y') }}</td>
                                    <td class="py-3.5 px-6 text-xs text-on-surface whitespace-nowrap">{{ $t->due_date->format('d/m/Y') }}</td>
                                    <td class="py-3.5 px-6 text-xs text-on-surface whitespace-nowrap">{{ $t->return_date ? $t->return_date->format('d/m/Y') : '-' }}</td>
                                    <td class="py-3.5 px-6 text-center whitespace-nowrap">
                                        @if ($t->status === 'returned')
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-surface-container text-on-surface-variant">Selesai</span>
                                        @elseif ($t->isOverdue())
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-error-container text-error">Terlambat</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-secondary-container/20 text-secondary">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">bar_chart</span>
                                        <p class="font-title-sm text-title-sm">Tidak ada catatan transaksi pada periode yang dipilih.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($transactions->hasPages())
                    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low/40 print:hidden">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
