<x-layouts.member title="Riwayat Peminjaman">
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-surface-container-low rounded-3xl p-6 sm:p-10 border border-outline-variant/40 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="font-label-caps text-label-caps text-secondary font-bold uppercase tracking-wider">Arsip Sirkulasi</span>
                <h1 class="font-display-lg text-display-lg text-primary font-bold mt-1 mb-2">Riwayat Peminjaman</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                    Daftar seluruh buku yang pernah Anda pinjam dan telah selesai dikembalikan ke perpustakaan SMKN 5.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('member.borrowings.current') }}" class="px-5 py-3 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-xl font-body-sm text-body-sm font-semibold transition-colors">
                    Peminjaman Aktif
                </a>
                <a href="{{ route('member.books.index') }}" class="px-5 py-3 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold shadow-sm transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    Katalog Buku
                </a>
            </div>
        </div>

        <!-- History Table Card -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/50">
                            <th class="py-4 px-6 font-semibold">Kode</th>
                            <th class="py-4 px-6 font-semibold">Buku</th>
                            <th class="py-4 px-6 font-semibold">Tgl Pinjam</th>
                            <th class="py-4 px-6 font-semibold">Batas Tempo</th>
                            <th class="py-4 px-6 font-semibold">Tgl Dikembalikan</th>
                            <th class="py-4 px-6 font-semibold text-center">Status Denda</th>
                            <th class="py-4 px-6 font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                        @forelse ($borrowings as $b)
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-4 px-6 font-mono font-bold text-secondary text-xs">
                                    {{ $b->transaction_code }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        @if ($b->book->cover_image)
                                            <img src="{{ $b->book->cover_image }}" alt="{{ $b->book->title }}" class="w-9 h-12 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-9 h-12 bg-surface-container rounded flex items-center justify-center text-on-surface-variant">
                                                <span class="material-symbols-outlined text-sm">book</span>
                                            </div>
                                        @endif
                                        <div class="truncate max-w-[260px]">
                                            <a href="{{ route('member.books.show', $b->book) }}" class="font-semibold text-primary hover:text-secondary block truncate">
                                                {{ $b->book->title }}
                                            </a>
                                            <span class="text-xs text-on-surface-variant">{{ $b->book->author }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-xs text-on-surface whitespace-nowrap">{{ $b->borrow_date->format('d/m/Y') }}</td>
                                <td class="py-4 px-6 text-xs text-on-surface whitespace-nowrap">{{ $b->due_date->format('d/m/Y') }}</td>
                                <td class="py-4 px-6 text-xs text-on-surface whitespace-nowrap">{{ $b->return_date ? $b->return_date->format('d/m/Y') : '-' }}</td>
                                <td class="py-4 px-6 text-center">
                                    @if ($b->fine)
                                        @if ($b->fine->isPaid())
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-secondary-container/20 text-secondary">
                                                Denda Lunas ({{ $b->fine->formatted_amount }})
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-error-container text-error">
                                                Denda Belum Lunas ({{ $b->fine->formatted_amount }})
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-xs text-on-surface-variant">Tidak Ada Denda</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-surface-container text-on-surface-variant">
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">history</span>
                                    <p class="font-title-sm text-title-sm">Belum ada riwayat pengembalian buku.</p>
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
</x-layouts.member>
