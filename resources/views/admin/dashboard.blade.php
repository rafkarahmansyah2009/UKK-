<x-layouts.admin title="Dashboard Admin">
    <div class="flex flex-col w-full p-8 space-y-8 max-w-container-max mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col gap-2 mb-2">
            <h1 class="font-display-lg text-display-lg text-on-surface font-bold">Dashboard Overview</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Ringkasan aktivitas dan metrik utama perpustakaan hari ini.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Buku -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm flex items-center justify-between group relative overflow-hidden border border-outline-variant/30">
                <div class="relative z-10">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider mb-2 font-semibold">Total Buku</p>
                    <h2 class="font-display-lg text-display-lg text-on-surface font-bold">{{ number_format($totalBooks) }}</h2>
                </div>
                <div class="w-12 h-12 rounded-full bg-primary-container/15 flex items-center justify-center relative z-10 text-primary-container">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                </div>
            </div>

            <!-- Total Anggota -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm flex items-center justify-between group relative overflow-hidden border border-outline-variant/30">
                <div class="relative z-10">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider mb-2 font-semibold">Total Anggota</p>
                    <h2 class="font-display-lg text-display-lg text-on-surface font-bold">{{ number_format($totalMembers) }}</h2>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center relative z-10 text-secondary">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">group</span>
                </div>
            </div>

            <!-- Sedang Dipinjam -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm flex items-center justify-between group relative overflow-hidden border border-outline-variant/30">
                <div class="relative z-10">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider mb-2 font-semibold">Sedang Dipinjam</p>
                    <h2 class="font-display-lg text-display-lg text-on-surface font-bold">{{ number_format($borrowedCount) }}</h2>
                </div>
                <div class="w-12 h-12 rounded-full bg-secondary/15 flex items-center justify-center relative z-10 text-secondary">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">swap_horiz</span>
                </div>
            </div>

            <!-- Terlambat -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm flex items-center justify-between group relative overflow-hidden border border-outline-variant/30">
                <div class="relative z-10">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider mb-2 font-semibold">Terlambat</p>
                    <h2 class="font-display-lg text-display-lg text-error font-bold">{{ number_format($overdueCount) }}</h2>
                </div>
                <div class="w-12 h-12 rounded-full bg-error-container/40 flex items-center justify-center relative z-10 text-error">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">warning</span>
                </div>
            </div>
        </div>

        <!-- Main Chart Section -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6 border border-outline-variant/30">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h3 class="font-headline-md text-headline-md text-on-surface font-bold">Grafik Tren Peminjaman</h3>
                    <p class="text-body-sm text-on-surface-variant">Statistik pemantauan sirkulasi peminjaman buku perpustakaan.</p>
                </div>
                <div class="flex items-center gap-2">
                    <label for="chartFilter" class="sr-only">Filter Periode</label>
                    <div class="relative inline-block">
                        <select
                            id="chartFilter"
                            class="appearance-none bg-surface-container-low hover:bg-surface-container text-on-surface font-body-sm text-sm rounded-lg px-3.5 py-2 pr-9 border border-outline-variant/40 focus:outline-none focus:ring-2 focus:ring-[#1E293B]/20 transition-colors cursor-pointer"
                        >
                            <option value="7_days" selected>7 Hari Terakhir</option>
                            <option value="30_days">30 Hari Terakhir</option>
                            <option value="this_year">Tahun Ini</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-base pointer-events-none">
                            expand_more
                        </span>
                    </div>
                </div>
            </div>

            <!-- Canvas Container -->
            <div class="relative w-full h-64 sm:h-72">
                <canvas id="borrowingChart"></canvas>
            </div>
        </div>

        <!-- Two Columns Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Books Info (4 cols) -->
            <div class="lg:col-span-4 flex flex-col gap-8">
                <!-- Buku Populer -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6 border border-outline-variant/30">
                    <h3 class="font-title-sm text-title-sm text-on-surface font-bold mb-4">Buku Populer</h3>
                    <div class="flex flex-col gap-4">
                        @forelse ($popularBooks as $pBook)
                            <div class="flex items-center gap-4 group">
                                <div class="w-12 h-16 bg-surface-container-high rounded overflow-hidden flex-shrink-0 border border-outline-variant/40">
                                    @if ($pBook->cover_image)
                                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="{{ $pBook->cover_image }}" alt="{{ $pBook->title }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-lg">book</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-body-sm text-body-sm font-bold text-on-surface truncate">{{ $pBook->title }}</h4>
                                    <p class="font-label-caps text-label-caps text-on-surface-variant truncate">{{ $pBook->author }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="font-body-md text-body-md font-bold text-primary">{{ $pBook->borrowings_count }}</span>
                                    <p class="font-label-caps text-label-caps text-on-surface-variant">Peminjaman</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-body-sm text-on-surface-variant">Belum ada data peminjaman buku.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('admin.books.index') }}" class="mt-6 block text-center w-full py-2 font-label-caps text-label-caps text-secondary font-bold hover:bg-secondary/5 rounded-lg transition-colors uppercase">
                        Lihat Semua Koleksi
                    </a>
                </div>

                <!-- Buku Stok Menipis -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6 border-l-4 border-error border-y border-r border-outline-variant/30">
                    <div class="flex items-center gap-2 mb-4 text-error">
                        <span class="material-symbols-outlined">inventory_2</span>
                        <h3 class="font-title-sm text-title-sm font-bold">Peringatan Stok Menipis</h3>
                    </div>
                    <ul class="space-y-3">
                        @forelse ($lowStockBooks as $lsBook)
                            <li class="flex justify-between items-center bg-surface-container-low p-3 rounded-lg">
                                <div class="min-w-0 flex-1">
                                    <p class="font-body-sm text-body-sm font-semibold text-on-surface truncate">{{ $lsBook->title }}</p>
                                    <p class="font-label-caps text-label-caps text-on-surface-variant font-bold">Sisa {{ $lsBook->available_stock }} dari {{ $lsBook->stock }} Eksemplar</p>
                                </div>
                                <a href="{{ route('admin.books.edit', $lsBook) }}" class="text-primary hover:bg-primary/10 p-2 rounded-full transition-colors ml-2" title="Kelola Stok">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-body-sm text-on-surface-variant">Semua stok buku dalam jumlah aman.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Right Column: Tables & Activity (8 cols) -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                <!-- Peminjaman Terbaru -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden border border-outline-variant/30">
                    <div class="p-6 pb-4 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-lowest">
                        <h3 class="font-title-sm text-title-sm text-on-surface font-bold">Peminjaman Terbaru</h3>
                        <a href="{{ route('admin.borrowings.index') }}" class="font-label-caps text-label-caps text-secondary font-bold hover:bg-secondary/5 px-3 py-1.5 rounded-md transition-colors uppercase">
                            Kelola Peminjaman
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low">
                                    <th class="font-label-caps text-label-caps text-on-surface-variant py-3 px-6 whitespace-nowrap uppercase font-bold">ID Transaksi</th>
                                    <th class="font-label-caps text-label-caps text-on-surface-variant py-3 px-6 whitespace-nowrap uppercase font-bold">Anggota</th>
                                    <th class="font-label-caps text-label-caps text-on-surface-variant py-3 px-6 uppercase font-bold">Buku</th>
                                    <th class="font-label-caps text-label-caps text-on-surface-variant py-3 px-6 whitespace-nowrap uppercase font-bold">Tanggal Pinjam</th>
                                    <th class="font-label-caps text-label-caps text-on-surface-variant py-3 px-6 whitespace-nowrap uppercase font-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="font-body-sm text-body-sm divide-y divide-outline-variant/20">
                                @forelse ($recentBorrowings as $b)
                                    <tr class="hover:bg-surface-container-low/40 transition-colors">
                                        <td class="py-3 px-6 font-mono text-on-surface-variant font-bold">{{ $b->transaction_code }}</td>
                                        <td class="py-3 px-6 font-semibold text-on-surface">
                                            {{ $b->user->name }}
                                            <span class="block font-normal text-on-surface-variant text-xs">
                                                {{ $b->user->nis ?? $b->user->nip ?? $b->user->email }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-on-surface truncate max-w-[200px]" title="{{ $b->book->title ?? 'Buku dihapus' }}">
                                            @if ($b->book)
                                                {{ $b->book->title }}
                                            @else
                                                <span class="text-error">Buku dihapus</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-6 text-on-surface-variant">
                                            {{ $b->borrow_date->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="py-3 px-6">
                                            @if ($b->status === 'returned')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-primary/10 text-primary">Selesai</span>
                                            @elseif ($b->isOverdue() || $b->status === 'overdue')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-error/10 text-error">Terlambat</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-secondary-container/20 text-secondary">Dipinjam</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-on-surface-variant">Belum ada transaksi peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Aktivitas Sistem Terbaru (Dynamic from activity_logs) -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-6 border border-outline-variant/30">
                    <h3 class="font-title-sm text-title-sm text-on-surface font-bold mb-6">Log Aktivitas Sistem Terbaru</h3>
                    <div class="relative border-l-2 border-outline-variant/40 ml-3 space-y-6">
                        @forelse ($recentActivities as $act)
                            <div class="relative pl-6">
                                <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-secondary ring-4 ring-surface-container-lowest"></span>
                                <p class="font-body-sm text-body-sm text-on-surface font-medium leading-snug">{{ $act->description }}</p>
                                <span class="font-label-caps text-label-caps text-on-surface-variant mt-1 block">
                                    {{ $act->created_at->diffForHumans() }}
                                </span>
                            </div>
                        @empty
                            <div class="pl-6 text-body-sm text-on-surface-variant">Belum ada aktivitas tercatat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('borrowingChart');
            if (!ctx) return;

            const chartContext = ctx.getContext('2d');

            // Fungsi membuat gradient background lembut
            function createNavyGradient(context) {
                const gradient = context.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(30, 41, 59, 0.22)');
                gradient.addColorStop(0.7, 'rgba(30, 41, 59, 0.04)');
                gradient.addColorStop(1, 'rgba(30, 41, 59, 0.00)');
                return gradient;
            }

            // Data inisial dari controller
            const initialLabels = @json($dayLabels);
            const initialData = @json($chartCounts);

            const chartConfig = {
                type: 'line',
                data: {
                    labels: initialLabels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: initialData,
                        borderColor: '#1E293B',
                        borderWidth: 2.5,
                        backgroundColor: createNavyGradient(chartContext),
                        fill: true,
                        tension: 0.4, // Smooth curved line
                        pointBackgroundColor: '#1E293B',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#1E293B',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleColor: '#F8FAFC',
                            bodyColor: '#F8FAFC',
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} buku dipinjam`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#64748B',
                                font: {
                                    size: 11,
                                    weight: '500'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#64748B',
                                precision: 0,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            };

            const borrowingChart = new Chart(ctx, chartConfig);

            // Filter Dropdown Handler (AJAX)
            const filterDropdown = document.getElementById('chartFilter');
            if (filterDropdown) {
                filterDropdown.addEventListener('change', function () {
                    const period = this.value;

                    // Mengambil data baru via endpoint JSON
                    fetch(`{{ route('admin.dashboard.chart-data') }}?period=${period}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(result => {
                            borrowingChart.data.labels = result.labels;
                            borrowingChart.data.datasets[0].data = result.data;
                            borrowingChart.update('active');
                        })
                        .catch(err => {
                            console.error('Gagal mengambil data chart:', err);
                        });
                });
            }
        });
    </script>
</x-layouts.admin>
