<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Perpustakaan SMKN 5' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background font-body-md text-on-background antialiased min-h-screen flex flex-col">
    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-surface-container-lowest/90 backdrop-blur-md border-b border-outline-variant shadow-sm">
        <div class="max-w-container-max mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-container text-tertiary-fixed rounded-xl flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                </div>
                <div>
                    <span class="font-headline-md text-headline-md font-bold text-primary block leading-none">Library</span>
                    <span class="font-label-caps text-label-caps text-secondary font-bold tracking-wider">SMKN 5</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="font-body-sm text-body-sm transition-colors {{ request()->routeIs('home') ? 'text-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Beranda
                </a>
                <a href="{{ route('katalog') }}" class="font-body-sm text-body-sm transition-colors {{ request()->routeIs('katalog') ? 'text-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Katalog Buku
                </a>
                <a href="{{ route('tentang') }}" class="font-body-sm text-body-sm transition-colors {{ request()->routeIs('tentang') ? 'text-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Informasi Perpustakaan
                </a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-primary-container text-on-primary rounded-lg font-title-sm text-title-sm font-semibold hover:bg-primary-container/90 transition-colors shadow-sm">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('member.dashboard') }}" class="px-5 py-2.5 bg-secondary text-on-secondary rounded-lg font-title-sm text-title-sm font-semibold hover:bg-secondary-container transition-colors shadow-sm">
                            Dashboard Member
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-on-surface-variant hover:text-primary font-body-sm text-body-sm font-semibold transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary-container text-on-primary rounded-lg font-body-sm text-body-sm font-semibold hover:bg-primary-container/90 transition-colors shadow-sm">
                        Daftar Anggota
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 w-full">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-primary-container text-on-primary-container border-t border-outline-variant/20 pt-12 pb-8 mt-16">
        <div class="max-w-container-max mx-auto px-4 sm:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="md:col-span-2 space-y-4">
                <div class="flex items-center gap-3 text-on-primary">
                    <span class="material-symbols-outlined text-3xl text-tertiary-fixed" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                    <span class="font-headline-md text-headline-md font-bold">Library SMKN 5</span>
                </div>
                <p class="font-body-md text-body-md text-primary-fixed-dim max-w-md">
                    Sistem perpustakaan digital terintegrasi SMKN 5 untuk mendukung literasi, riset, dan pembelajaran vokasi berkualitas tinggi.
                </p>
            </div>
            <div class="space-y-3">
                <h4 class="font-title-sm text-title-sm text-on-primary font-bold">Tautan Cepat</h4>
                <ul class="space-y-2 text-body-sm text-primary-fixed-dim">
                    <li><a href="{{ route('home') }}" class="hover:text-on-primary transition-colors">Beranda</a></li>
                    <li><a href="{{ route('katalog') }}" class="hover:text-on-primary transition-colors">Katalog Buku</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-on-primary transition-colors">Informasi Perpustakaan</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-on-primary transition-colors">Masuk Akun</a></li>
                </ul>
            </div>
            <div class="space-y-3">
                <h4 class="font-title-sm text-title-sm text-on-primary font-bold">Jam Layanan</h4>
                <p class="text-body-sm text-primary-fixed-dim">Senin - Kamis: 07.30 - 15.30 WIB</p>
                <p class="text-body-sm text-primary-fixed-dim">Jumat: 07.30 - 11.30 WIB</p>
                <p class="text-body-sm text-primary-fixed-dim">Sabtu - Minggu: Tutup</p>
            </div>
        </div>
        <div class="max-w-container-max mx-auto px-4 sm:px-8 pt-6 border-t border-outline-variant/15 text-center text-body-sm text-primary-fixed-dim">
            <p>&copy; {{ date('Y') }} Perpustakaan SMKN 5. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
