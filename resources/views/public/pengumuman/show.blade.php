<x-layouts.public title="{{ $announcement['title'] }} - Library SMKN 5">
    <!-- Breadcrumb & Top Bar -->
    <div class="bg-surface-container-low/50 py-6 px-4 sm:px-8 border-b border-outline-variant/40">
        <div class="max-w-container-max mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs text-on-surface-variant flex-wrap" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">home</span>
                    Beranda
                </a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="{{ route('pengumuman') }}" class="hover:text-primary transition-colors">Pengumuman</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-secondary font-semibold truncate max-w-[200px] sm:max-w-xs">{{ $announcement['title'] }}</span>
            </nav>

            <!-- Back to announcements list button -->
            <a
                href="{{ route('pengumuman') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-lowest text-primary hover:bg-surface-container rounded-xl font-body-sm text-body-sm font-semibold border border-outline-variant/60 shadow-sm transition-all duration-200 hover:-translate-y-0.5 shrink-0 self-start sm:self-auto"
            >
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Pengumuman
            </a>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="max-w-container-max mx-auto px-4 sm:px-8 py-10 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            <!-- Left / Main Article Column -->
            <article class="lg:col-span-8 flex flex-col gap-6">
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-sm p-6 sm:p-10">
                    @php
                        $categoryClass = match($announcement['category']) {
                            'Layanan & Operasional' => 'bg-amber-50 text-amber-900 border-amber-200/80',
                            'Koleksi & Referensi' => 'bg-blue-50 text-blue-900 border-blue-200/80',
                            'Kegiatan & Literasi' => 'bg-emerald-50 text-emerald-900 border-emerald-200/80',
                            'Fasilitas & Sistem' => 'bg-purple-50 text-purple-900 border-purple-200/80',
                            default => 'bg-surface-container text-on-surface-variant border-outline-variant/60',
                        };
                    @endphp

                    <!-- Category & Reading Time -->
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold border {{ $categoryClass }}">
                            <span class="material-symbols-outlined text-[16px]">{{ $announcement['icon'] ?? 'campaign' }}</span>
                            {{ $announcement['category'] }}
                        </span>

                        <span class="text-xs text-on-surface-variant font-medium flex items-center gap-1.5 bg-surface-container-low px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-[15px] text-outline">timer</span>
                            {{ $announcement['read_time'] }}
                        </span>
                    </div>

                    <!-- Article Title -->
                    <h1 class="font-display-lg text-display-lg text-primary font-bold leading-tight mb-6">
                        {{ $announcement['title'] }}
                    </h1>

                    <!-- Article Metadata Bar -->
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-6 py-4 px-5 bg-surface-container-low/60 rounded-xl border border-outline-variant/40 text-xs text-on-surface-variant mb-8">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-secondary">school</span>
                            <span>Diterbitkan oleh: <strong class="text-on-surface">{{ $announcement['author'] }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-outline">calendar_today</span>
                            <span>Tanggal: <strong class="text-on-surface">{{ $announcement['published_at'] }}</strong></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-outline">verified</span>
                            <span class="text-secondary font-semibold">Resmi Perpustakaan</span>
                        </div>
                    </div>

                    <!-- Key Points Summary (if available) -->
                    @if (!empty($announcement['key_points']))
                        <div class="bg-secondary-fixed/30 border border-secondary/20 rounded-xl p-5 mb-8">
                            <div class="flex items-center gap-2 text-secondary font-bold text-sm mb-3">
                                <span class="material-symbols-outlined text-[20px]">fact_check</span>
                                <span>Poin Penting Pengumuman:</span>
                            </div>
                            <ul class="space-y-2">
                                @foreach ($announcement['key_points'] as $point)
                                    <li class="flex items-start gap-2.5 text-sm text-on-surface">
                                        <span class="material-symbols-outlined text-secondary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                        <span>{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Main Article Body -->
                    <div class="prose max-w-none font-body-md text-body-md text-on-surface leading-relaxed space-y-4">
                        {!! $announcement['content'] !!}
                    </div>

                    <!-- Important Note Callout (if available) -->
                    @if (!empty($announcement['important_note']))
                        <div class="mt-8 p-4 rounded-xl bg-amber-50 border-l-4 border-amber-500 text-amber-900 flex items-start gap-3">
                            <span class="material-symbols-outlined text-amber-600 text-[22px] shrink-0 mt-0.5">info</span>
                            <div>
                                <h4 class="font-bold text-sm text-amber-950 mb-0.5">Catatan Khusus:</h4>
                                <p class="text-xs sm:text-sm text-amber-900 leading-relaxed">{{ $announcement['important_note'] }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Official Endorsement Stamp -->
                    <div class="mt-10 pt-6 border-t border-outline-variant/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-surface-container-low/40 p-5 rounded-xl border border-outline-variant/30">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/logo.png') }}" alt="SMKN 5" class="h-10 w-auto opacity-90">
                            <div>
                                <h5 class="text-xs font-bold text-primary uppercase tracking-wider">Perpustakaan SMK Negeri 5</h5>
                                <p class="text-[11px] text-on-surface-variant">Sistem Informasi Manajemen Pustaka Digital</p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right text-xs text-on-surface-variant">
                            <p>Status Validasi: <span class="text-emerald-700 font-bold">Terverifikasi</span></p>
                            <p class="text-[11px]">Dikeluarkan di Tangerang, Banten</p>
                        </div>
                    </div>

                    <!-- Action & Share Bar -->
                    <div
                        x-data="{
                            copied: false,
                            copyUrl() {
                                navigator.clipboard.writeText(window.location.href);
                                this.copied = true;
                                setTimeout(() => this.copied = false, 2500);
                            }
                        }"
                        class="mt-8 pt-6 border-t border-outline-variant/40 flex flex-wrap items-center justify-between gap-4"
                    >
                        <a
                            href="{{ route('pengumuman') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-surface-container hover:bg-surface-container-high text-primary rounded-xl font-semibold text-sm transition-colors"
                        >
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            Kembali ke Daftar Pengumuman
                        </a>

                        <div class="flex items-center gap-2">
                            <button
                                @click="copyUrl()"
                                type="button"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-surface-container-lowest border border-outline-variant hover:bg-surface-container text-on-surface rounded-xl text-sm font-medium transition-colors shadow-sm"
                            >
                                <span class="material-symbols-outlined text-[18px]" x-show="!copied">content_copy</span>
                                <span class="material-symbols-outlined text-[18px] text-emerald-600" x-show="copied" x-cloak>check</span>
                                <span x-text="copied ? 'Tautan Disalin!' : 'Bagikan Link'">Bagikan Link</span>
                            </button>

                            <button
                                onclick="window.print()"
                                type="button"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-surface-container-lowest border border-outline-variant hover:bg-surface-container text-on-surface rounded-xl text-sm font-medium transition-colors shadow-sm"
                                title="Cetak Pengumuman"
                            >
                                <span class="material-symbols-outlined text-[18px]">print</span>
                                <span class="hidden sm:inline">Cetak</span>
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Right / Sidebar Column -->
            <aside class="lg:col-span-4 flex flex-col gap-6">
                <!-- Related / Other Announcements -->
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-sm p-6">
                    <div class="flex items-center justify-between gap-2 pb-4 mb-4 border-b border-outline-variant/40">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-[22px]">newspaper</span>
                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface">Pengumuman Lainnya</h3>
                        </div>
                        <a href="{{ route('pengumuman') }}" class="text-xs font-bold text-secondary hover:underline">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="divide-y divide-outline-variant/30">
                        @foreach ($relatedAnnouncements as $rel)
                            <article class="py-4 first:pt-0 last:pb-0 group">
                                <div class="flex items-center gap-2 mb-1 text-[11px] text-on-surface-variant">
                                    <span class="px-2 py-0.5 rounded-full bg-surface-container font-semibold">
                                        {{ $rel['category'] }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $rel['published_at'] }}</span>
                                </div>
                                <h4 class="font-bold text-sm text-on-surface group-hover:text-secondary transition-colors line-clamp-2 leading-snug">
                                    <a href="{{ route('pengumuman.show', $rel['slug']) }}">
                                        {{ $rel['title'] }}
                                    </a>
                                </h4>
                            </article>
                        @endforeach
                    </div>

                    <a
                        href="{{ route('pengumuman') }}"
                        class="mt-6 w-full block text-center py-2.5 px-4 bg-surface-container hover:bg-surface-container-high rounded-xl text-primary font-semibold text-sm transition-colors"
                    >
                        Buka Semua Pengumuman
                    </a>
                </div>

                <!-- Jam Layanan Perpustakaan -->
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-sm p-6 relative overflow-hidden">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">schedule</span>
                        </div>
                        <div>
                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface leading-tight">Jam Layanan</h3>
                            <p class="text-xs text-on-surface-variant">Kunjungan & Layanan Sirkulasi</p>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs">
                        <li class="flex justify-between items-center py-2 border-b border-outline-variant/30">
                            <span class="text-on-surface-variant font-medium">Senin – Kamis</span>
                            <span class="font-bold text-on-surface bg-surface-container px-2.5 py-1 rounded-md">07.30 – 15.30 WIB</span>
                        </li>
                        <li class="flex justify-between items-center py-2 border-b border-outline-variant/30">
                            <span class="text-on-surface-variant font-medium">Jumat</span>
                            <span class="font-bold text-error bg-error-container/50 px-2.5 py-1 rounded-md">07.30 – 11.30 WIB</span>
                        </li>
                        <li class="flex justify-between items-center pt-2 text-on-surface-variant">
                            <span>Sabtu, Minggu & Hari Libur</span>
                            <span class="font-bold text-outline">Tutup</span>
                        </li>
                    </ul>
                    <a href="{{ route('tentang') }}" class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-secondary hover:underline">
                        Informasi Perpustakaan Selengkapnya
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>

                <!-- Katalog Promo Banner -->
                <div class="bg-gradient-to-br from-primary-container to-primary text-on-primary rounded-2xl p-6 shadow-md relative overflow-hidden">
                    <div class="relative z-10 space-y-3">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px] text-white">menu_book</span>
                        </div>
                        <h3 class="font-title-sm text-title-sm font-bold text-white">Cari Buku & Modul Vokasi?</h3>
                        <p class="text-xs text-primary-fixed-dim leading-relaxed">
                            Jelajahi ribuan koleksi buku pelajaran, modul praktikum kejuruan, dan buku fiksi di katalog perpustakaan kami.
                        </p>
                        <a
                            href="{{ route('katalog') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-secondary text-white rounded-xl text-xs font-semibold hover:bg-secondary-container transition-all duration-200 shadow-sm"
                        >
                            <span>Buka Katalog Buku</span>
                            <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.public>
