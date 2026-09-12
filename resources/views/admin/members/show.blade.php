<x-layouts.admin title="Detail Anggota - {{ $member->name }}">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-10 mb-8 rounded-b-3xl shadow-sm">
            <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant text-body-sm mb-1">
                        <a href="{{ route('admin.members.index') }}" class="hover:text-primary transition-colors">Anggota</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Profil Detail</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 leading-tight">{{ $member->name }}</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        {{ $member->isSiswa() ? 'Siswa SMKN 5' : 'Dewan Guru SMKN 5' }} &bull; Username: <span class="font-mono text-primary">{{ $member->username ?? '-' }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.members.edit', $member) }}" class="px-5 py-2.5 bg-secondary text-on-secondary hover:bg-secondary/90 rounded-xl font-body-sm text-body-sm font-semibold flex items-center gap-2 shadow-sm transition-all">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Profil
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="px-4 py-2.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold flex items-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="max-w-5xl mx-auto w-full px-4 sm:px-8 space-y-8">
            <!-- Member Overview Card -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pb-6 border-b border-outline-variant/40">
                    @if ($member->avatar)
                        <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="w-20 h-20 rounded-2xl object-cover shadow-sm border border-outline-variant/50">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-secondary-container/20 text-secondary font-bold text-2xl flex items-center justify-center shadow-sm">
                            {{ strtoupper(substr($member->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="font-headline-md text-headline-md text-primary font-bold">{{ $member->name }}</h2>
                            @if ($member->status === 'active')
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-secondary-container/20 text-secondary">Aktif</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-error-container text-error">Nonaktif</span>
                            @endif
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $member->isSiswa() ? 'bg-secondary-fixed/50 text-on-secondary-fixed-variant' : 'bg-tertiary-fixed/60 text-on-tertiary-fixed' }}">
                                {{ $member->isSiswa() ? 'Siswa' : 'Guru' }}
                            </span>
                        </div>
                        <p class="text-on-surface-variant text-body-sm mt-1">Terdaftar sejak {{ $member->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>

                <!-- Detail Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 text-body-sm">
                    <div class="p-3 bg-surface-container-low rounded-xl">
                        <span class="text-xs text-on-surface-variant block mb-1">{{ $member->isSiswa() ? 'NIS' : 'NIP' }}</span>
                        <span class="font-mono font-bold text-on-surface">{{ $member->isSiswa() ? ($member->nis ?? '-') : ($member->nip ?? '-') }}</span>
                    </div>
                    <div class="p-3 bg-surface-container-low rounded-xl">
                        <span class="text-xs text-on-surface-variant block mb-1">Email</span>
                        <span class="font-medium text-on-surface truncate block">{{ $member->email }}</span>
                    </div>
                    <div class="p-3 bg-surface-container-low rounded-xl">
                        <span class="text-xs text-on-surface-variant block mb-1">Telepon</span>
                        <span class="font-medium text-on-surface">{{ $member->phone ?? '-' }}</span>
                    </div>
                    <div class="p-3 bg-surface-container-low rounded-xl">
                        <span class="text-xs text-on-surface-variant block mb-1">{{ $member->isSiswa() ? 'Kelas & Jurusan' : 'Mata Pelajaran' }}</span>
                        <span class="font-semibold text-secondary">
                            {{ $member->isSiswa() ? ($member->class ?? '-') . ' (' . ($member->major ?? '-') . ')' : ($member->subject ?? '-') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Borrowing & Fines Section -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden">
                <div class="p-6 border-b border-outline-variant/40 flex items-center justify-between">
                    <div>
                        <h3 class="font-title-sm text-title-sm text-primary">Riwayat Peminjaman Anggota</h3>
                        <p class="text-xs text-on-surface-variant mt-0.5">Seluruh catatan sirkulasi buku oleh anggota ini</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/40">
                                <th class="py-3 px-6 text-xs font-semibold">Kode</th>
                                <th class="py-3 px-6 text-xs font-semibold">Judul Buku</th>
                                <th class="py-3 px-6 text-xs font-semibold">Tgl Pinjam</th>
                                <th class="py-3 px-6 text-xs font-semibold">Jatuh Tempo</th>
                                <th class="py-3 px-6 text-xs font-semibold">Tgl Kembali</th>
                                <th class="py-3 px-6 text-xs font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-body-sm divide-y divide-outline-variant/30">
                            @forelse ($member->borrowings as $b)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-3 px-6 font-mono font-medium text-secondary">{{ $b->transaction_code }}</td>
                                    <td class="py-3 px-6 font-medium text-on-surface">{{ $b->book->title }}</td>
                                    <td class="py-3 px-6 text-on-surface-variant">{{ $b->borrow_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-6 text-on-surface-variant">{{ $b->due_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-6 text-on-surface-variant">{{ $b->return_date ? $b->return_date->format('d/m/Y') : '-' }}</td>
                                    <td class="py-3 px-6 text-center">
                                        @if ($b->status === 'returned')
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant">Selesai</span>
                                        @elseif ($b->isOverdue())
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-error-container text-error">Terlambat</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold bg-secondary-container/20 text-secondary">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-on-surface-variant text-body-sm">
                                        Belum ada riwayat transaksi peminjaman untuk anggota ini.
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
