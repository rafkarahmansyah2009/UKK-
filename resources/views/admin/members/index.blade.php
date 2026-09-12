<x-layouts.admin title="Manajemen Anggota">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header Section -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-12 mb-8 relative z-10 rounded-b-3xl shadow-sm">
            <div class="max-w-container-max mx-auto flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="flex flex-col gap-2">
                    <span class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Keanggotaan Perpustakaan</span>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 p-0 leading-none">Daftar Anggota</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl mt-2">
                        Kelola data keanggotaan siswa dan dewan guru, pantau status keaktifan serta sirkulasi peminjaman.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.members.create') }}" class="flex items-center gap-2 bg-primary text-on-primary hover:bg-primary/90 px-5 py-2.5 rounded-xl transition-colors shadow-md font-body-sm text-body-sm font-semibold">
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                        Tambah Anggota
                    </a>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <form method="GET" action="{{ route('admin.members.index') }}" class="max-w-container-max mx-auto mt-8 flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari berdasarkan nama, NIS, NIP, atau email..."
                        class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-12 pr-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-shadow shadow-sm"
                    >
                </div>
                <div class="flex flex-wrap gap-4">
                    <div class="relative min-w-[160px]">
                        <select
                            name="tipe"
                            onchange="this.form.submit()"
                            class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-4 pr-10 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary appearance-none cursor-pointer shadow-sm"
                        >
                            <option value="">Semua Tipe</option>
                            <option value="siswa" {{ request('tipe') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru" {{ request('tipe') === 'guru' ? 'selected' : '' }}>Guru</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                    <div class="relative min-w-[160px]">
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm pl-4 pr-10 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary appearance-none cursor-pointer shadow-sm"
                        >
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                    @if(request('q') || request('tipe') || request('status'))
                        <a href="{{ route('admin.members.index') }}" class="px-4 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Main Content Area -->
        <div class="px-8 max-w-container-max mx-auto w-full flex-1">
            <!-- Summary Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 -mt-2">
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center text-white">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">group</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Total Anggota</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\User::where('role', 'member')->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Siswa Terdaftar</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\User::where('role', 'member')->where('member_type', 'siswa')->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-tertiary-container/20 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">badge</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Guru Terdaftar</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\User::where('role', 'member')->where('member_type', 'guru')->count() }}</p>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    </div>
                    <div>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase mb-1">Anggota Aktif</p>
                        <p class="font-headline-md text-headline-md text-on-surface">{{ \App\Models\User::where('role', 'member')->where('status', 'active')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Members Table -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1000px]">
                        <thead>
                            <tr class="bg-surface-container text-on-surface font-title-sm text-title-sm border-b border-outline-variant/50">
                                <th class="py-4 px-6 font-semibold">Anggota</th>
                                <th class="py-4 px-6 font-semibold">NIS / NIP</th>
                                <th class="py-4 px-6 font-semibold">Tipe</th>
                                <th class="py-4 px-6 font-semibold">Kelas / Mapel</th>
                                <th class="py-4 px-6 font-semibold">Kontak</th>
                                <th class="py-4 px-6 font-semibold text-center">Status</th>
                                <th class="py-4 px-6 font-semibold text-right w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                            @forelse ($members as $member)
                                <tr class="hover:bg-surface-container-low/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            @if ($member->avatar)
                                                <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant/50">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-secondary-container/20 text-secondary font-bold flex items-center justify-center text-sm">
                                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.members.show', $member) }}" class="font-semibold text-primary hover:text-secondary block">
                                                    {{ $member->name }}
                                                </a>
                                                <span class="text-xs text-on-surface-variant font-mono">{{ $member->username ?? $member->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-mono text-on-surface">
                                        {{ $member->isSiswa() ? ($member->nis ?? '-') : ($member->nip ?? '-') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if ($member->isSiswa())
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-secondary-fixed/50 text-on-secondary-fixed-variant text-xs font-semibold">
                                                Siswa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-tertiary-fixed/60 text-on-tertiary-fixed text-xs font-semibold">
                                                Guru
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-on-surface">
                                        @if ($member->isSiswa())
                                            <span>{{ $member->class ?? '-' }}</span>
                                            @if($member->major)
                                                <span class="text-xs text-on-surface-variant block">{{ $member->major }}</span>
                                            @endif
                                        @else
                                            <span>{{ $member->subject ?? 'Guru SMKN 5' }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-xs text-on-surface block">{{ $member->email }}</span>
                                        <span class="text-xs text-on-surface-variant block mt-0.5">{{ $member->phone ?? '-' }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($member->status === 'active')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-secondary-container/20 text-secondary">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded text-[11px] font-bold uppercase tracking-wider bg-error-container text-error">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.members.show', $member) }}" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-secondary transition-colors" title="Lihat Profil">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <a href="{{ route('admin.members.edit', $member) }}" class="p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-secondary transition-colors" title="Edit Anggota">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.members.toggle-status', $member) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2 rounded-lg {{ $member->status === 'active' ? 'text-on-surface-variant hover:text-error hover:bg-error-container/20' : 'text-secondary hover:bg-secondary-container/20' }} transition-colors" title="{{ $member->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                    <span class="material-symbols-outlined text-[20px]">
                                                        {{ $member->status === 'active' ? 'block' : 'check_circle' }}
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-5xl mb-2 text-outline-variant">person_off</span>
                                        <p class="font-title-sm text-title-sm">Tidak ada anggota yang sesuai dengan kriteria pencarian.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($members->hasPages())
                    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low/40">
                        {{ $members->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
