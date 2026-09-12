<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Perpustakaan' }} - Library SMKN 5</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background font-body-md text-on-background antialiased">
    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest z-50 flex flex-col shadow-[0_0_12px_rgba(0,0,0,0.03)] border-r border-outline-variant">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary-container text-tertiary-fixed rounded-xl flex items-center justify-center shadow-sm">
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
            </div>
            <span class="font-headline-md text-headline-md text-primary font-bold leading-tight">Perpus<br>SMKN 5</span>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 space-y-1 py-2">
            <div class="text-label-caps font-label-caps text-on-surface-variant px-4 py-2 uppercase font-semibold">Beranda</div>
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-body-sm text-body-sm">Dashboard Admin</span>
            </a>

            <div class="text-label-caps font-label-caps text-on-surface-variant px-4 py-2 mt-4 uppercase font-semibold">Manajemen Koleksi</div>
            <a
                href="{{ route('admin.books.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.books.*') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">book</span>
                <span class="font-body-sm text-body-sm">Data Buku</span>
            </a>
            <a
                href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">category</span>
                <span class="font-body-sm text-body-sm">Kategori</span>
            </a>

            <div class="text-label-caps font-label-caps text-on-surface-variant px-4 py-2 mt-4 uppercase font-semibold">Transaksi</div>
            <a
                href="{{ route('admin.borrowings.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.borrowings.*') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">outbound</span>
                <span class="font-body-sm text-body-sm">Peminjaman</span>
            </a>
            <a
                href="{{ route('admin.returns.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.returns.*') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">assignment_return</span>
                <span class="font-body-sm text-body-sm">Pengembalian</span>
            </a>
            <a
                href="{{ route('admin.fines.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.fines.*') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">payments</span>
                <span class="font-body-sm text-body-sm">Denda</span>
            </a>

            <div class="text-label-caps font-label-caps text-on-surface-variant px-4 py-2 mt-4 uppercase font-semibold">Lainnya</div>
            <a
                href="{{ route('admin.members.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.members.*') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">group</span>
                <span class="font-body-sm text-body-sm">Anggota</span>
            </a>
            <a
                href="{{ route('admin.reports.index') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-secondary-container text-on-secondary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container' }}"
            >
                <span class="material-symbols-outlined">bar_chart</span>
                <span class="font-body-sm text-body-sm">Laporan</span>
            </a>
        </nav>

        <!-- Admin Profile & Logout -->
        <div class="p-4 border-t border-outline-variant bg-surface-container-low">
            <div class="flex items-center gap-3 px-2 mb-3">
                <img
                    alt="Profile"
                    class="w-10 h-10 rounded-full object-cover border border-outline-variant"
                    src="{{ auth()->user()->avatar ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCtm_u3lB6IQEkySkKODBLovGXGMqERI9HrEL6DLkVOQF2JRMIl3N8Zp7MgAr8xlhhoC4B9CAlCMFfQcVSdoHe6NJS-ICGui9xvBBpm6s0g3PcXG-gLSzGdWM2hHzwwFsdBlU5lMS6HXF0m1df4XK5qPf903c14GshWR7p_5CEJ3IRf2Zs9VoNhq7d1vn4A-Uvfh_Msblw5zbNjEue6xsvO8d1EvM_fT12sIw_Mn7MKFD70HKpMzXlI' }}"
                >
                <div class="overflow-hidden">
                    <p class="font-body-sm text-body-sm font-bold text-on-surface truncate">{{ auth()->user()->name }}</p>
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-error hover:bg-error-container hover:text-on-error-container transition-all"
                >
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-body-sm text-body-sm font-semibold">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="pl-72 flex flex-col min-h-screen">
        <!-- Top Header -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-surface/85 backdrop-blur-xl border-b border-outline-variant z-40 px-8 flex items-center justify-between">
            <form action="{{ route('admin.books.index') }}" method="GET" class="flex items-center bg-surface-container-high px-4 py-1.5 rounded-full w-96">
                <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
                <input
                    name="q"
                    value="{{ request('q') }}"
                    class="bg-transparent border-none focus:ring-0 text-body-sm w-full outline-none"
                    placeholder="Cari buku atau anggota..."
                    type="text"
                >
            </form>

            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" target="_blank" class="text-body-sm text-on-surface-variant hover:text-primary flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                    <span>Lihat Web</span>
                </a>
                <div class="flex items-center gap-3">
                    <span class="font-body-sm text-body-sm text-on-surface">Petugas: <strong>{{ auth()->user()->name }}</strong></span>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 pt-16 bg-background w-full">
            <!-- Flash Notification -->
            @if (session('success'))
                <div class="max-w-container-max mx-auto px-8 pt-6">
                    <div class="p-4 bg-secondary/10 border-l-4 border-secondary text-secondary rounded-r-lg flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span class="font-body-sm text-body-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-container-max mx-auto px-8 pt-6">
                    <div class="p-4 bg-error/10 border-l-4 border-error text-error rounded-r-lg flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined">error</span>
                            <span class="font-body-sm text-body-sm font-semibold">{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
