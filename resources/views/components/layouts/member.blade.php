<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Portal Anggota' }} - Library SMKN 5</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background font-body-md text-on-background antialiased min-h-screen flex flex-col">
    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-50 bg-surface-container-lowest/90 backdrop-blur-md border-b border-outline-variant shadow-sm">
        <div class="max-w-container-max mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
            <!-- Brand -->
            <div class="flex items-center gap-8">
                <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-container text-tertiary-fixed rounded-xl flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                    </div>
                    <div>
                        <span class="font-headline-md text-headline-md font-bold text-primary block leading-none">Library</span>
                        <span class="font-label-caps text-label-caps text-secondary font-bold tracking-wider">SMKN 5</span>
                    </div>
                </a>

                <!-- Nav Links -->
                <nav class="hidden md:flex items-center gap-1">
                    <a
                        href="{{ route('member.dashboard') }}"
                        class="px-4 py-2 rounded-lg font-body-sm text-body-sm transition-colors {{ request()->routeIs('member.dashboard') ? 'bg-secondary-container/15 text-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low' }}"
                    >
                        Dashboard
                    </a>
                    <a
                        href="{{ route('member.books.index') }}"
                        class="px-4 py-2 rounded-lg font-body-sm text-body-sm transition-colors {{ request()->routeIs('member.books.*') ? 'bg-secondary-container/15 text-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low' }}"
                    >
                        Katalog Buku
                    </a>
                    <a
                        href="{{ route('member.borrowings.current') }}"
                        class="px-4 py-2 rounded-lg font-body-sm text-body-sm transition-colors {{ request()->routeIs('member.borrowings.current') ? 'bg-secondary-container/15 text-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low' }}"
                    >
                        Peminjaman Saya
                    </a>
                    <a
                        href="{{ route('member.borrowings.history') }}"
                        class="px-4 py-2 rounded-lg font-body-sm text-body-sm transition-colors {{ request()->routeIs('member.borrowings.history') ? 'bg-secondary-container/15 text-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low' }}"
                    >
                        Riwayat
                    </a>
                </nav>
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 text-right">
                    <div class="hidden sm:block">
                        <p class="font-body-sm text-body-sm font-bold text-on-surface leading-tight">{{ auth()->user()->name }}</p>
                        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">
                            {{ auth()->user()->isSiswa() ? 'Siswa (' . (auth()->user()->class ?? 'SMKN 5') . ')' : 'Guru (' . (auth()->user()->subject ?? 'SMKN 5') . ')' }}
                        </p>
                    </div>
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant">
                    @else
                        <div class="w-10 h-10 rounded-full bg-secondary/10 border border-secondary flex items-center justify-center font-bold text-secondary text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button
                        type="submit"
                        class="p-2 rounded-lg text-on-surface-variant hover:text-error hover:bg-error-container/20 transition-colors"
                        title="Keluar"
                    >
                        <span class="material-symbols-outlined text-[22px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Mobile Nav Strip -->
    <div class="md:hidden bg-surface-container-lowest border-b border-outline-variant px-4 py-2 flex items-center justify-around text-body-sm">
        <a href="{{ route('member.dashboard') }}" class="py-1 px-2 {{ request()->routeIs('member.dashboard') ? 'text-secondary font-bold' : 'text-on-surface-variant' }}">Dashboard</a>
        <a href="{{ route('member.books.index') }}" class="py-1 px-2 {{ request()->routeIs('member.books.*') ? 'text-secondary font-bold' : 'text-on-surface-variant' }}">Katalog</a>
        <a href="{{ route('member.borrowings.current') }}" class="py-1 px-2 {{ request()->routeIs('member.borrowings.current') ? 'text-secondary font-bold' : 'text-on-surface-variant' }}">Peminjaman</a>
        <a href="{{ route('member.borrowings.history') }}" class="py-1 px-2 {{ request()->routeIs('member.borrowings.history') ? 'text-secondary font-bold' : 'text-on-surface-variant' }}">Riwayat</a>
    </div>

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-container-max mx-auto p-4 sm:p-8">
        <!-- Flash Notification -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-secondary/10 border-l-4 border-secondary text-secondary rounded-r-lg flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span class="font-body-sm text-body-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-error/10 border-l-4 border-error text-error rounded-r-lg flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined">error</span>
                    <span class="font-body-sm text-body-sm font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-surface-container-lowest border-t border-outline-variant py-6 text-center text-body-sm text-on-surface-variant mt-auto">
        <p>&copy; {{ date('Y') }} Perpustakaan SMKN 5. Seluruh hak cipta dilindungi.</p>
    </footer>
</body>
</html>
