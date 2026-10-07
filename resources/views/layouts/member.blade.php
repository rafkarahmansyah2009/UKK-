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
    <header class="fixed top-0 w-full z-50 bg-surface/90 backdrop-blur-md border-b border-outline-variant">
        <div class="h-16 w-full px-4 sm:px-8 flex items-center justify-between relative">
            <!-- Brand -->
            <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2">
                <img
                    alt="Library SMKN 5 Logo"
                    class="h-8 w-auto"
                    src="{{ asset('images/logo.png') }}"
                    onerror="this.onerror=null; this.src='https://lh3.googleusercontent.com/aida-public/AB6AXuCAI-VR8ddAtWX6cI7oHUn3TLLw8FWvZ2ROV05jIbuD2Pwj73K8gJKE6oH4UMZNai_IPwdT5KtT4pZGsetbCbxkqvJpHxfcHMJglcrgxIfxGl7aahQd4h0d1a2ysfyzKI4uvrQ47DnDi-R2U26LUpy2p7w_1EQ5klA12VwsLs-RQqXKABmbhN7lW137QDgnIbghY4Ukyz5k4nyetVwXGopVh9mw5i_2VdpP2R7jq5YQwwcqJ1cR1FES';"
                />
                <span class="font-headline-md text-title-sm text-primary font-bold">Library SMKN 5</span>
            </a>

            <!-- Centered Nav Links -->
            <nav class="hidden md:flex gap-8 absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2">
                <a
                    href="{{ route('member.dashboard') }}"
                    class="text-body-sm transition-colors {{ request()->routeIs('member.dashboard') ? 'text-secondary font-bold underline decoration-2 underline-offset-8' : 'text-on-surface-variant hover:text-on-surface' }}"
                >
                    Dashboard
                </a>
                <a
                    href="{{ route('member.books.index') }}"
                    class="text-body-sm transition-colors {{ request()->routeIs('member.books.*') ? 'text-secondary font-bold underline decoration-2 underline-offset-8' : 'text-on-surface-variant hover:text-on-surface' }}"
                >
                    Katalog
                </a>
                <a
                    href="{{ route('member.borrowings.current') }}"
                    class="text-body-sm transition-colors {{ request()->routeIs('member.borrowings.current') ? 'text-secondary font-bold underline decoration-2 underline-offset-8' : 'text-on-surface-variant hover:text-on-surface' }}"
                >
                    Peminjaman Saya
                </a>
                <a
                    href="{{ route('member.borrowings.history') }}"
                    class="text-body-sm transition-colors {{ request()->routeIs('member.borrowings.history') ? 'text-secondary font-bold underline decoration-2 underline-offset-8' : 'text-on-surface-variant hover:text-on-surface' }}"
                >
                    Riwayat
                </a>
            </nav>

            <!-- Right Actions (Notifications, Profile, Logout) -->
            <div class="flex items-center gap-4 sm:gap-6">
                <a
                    href="{{ route('member.borrowings.current') }}"
                    class="text-on-surface-variant hover:text-on-surface p-1 rounded-lg hover:bg-surface-container-low transition-colors relative"
                    title="Pemberitahuan Peminjaman"
                >
                    <span class="material-symbols-outlined text-[22px]">notifications</span>
                </a>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <button
                        @click="open = !open"
                        type="button"
                        class="flex items-center gap-2.5 pl-1.5 pr-3 py-1.5 rounded-full bg-surface-container-low hover:bg-surface-container-high transition-colors focus:outline-none"
                    >
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant shadow-sm">
                        @else
                            <div class="w-8 h-8 rounded-full bg-secondary/15 border border-secondary/30 flex items-center justify-center font-bold text-secondary text-xs shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="font-body-sm text-body-sm text-on-surface font-semibold leading-none truncate max-w-[120px]">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="font-label-caps text-label-caps text-outline leading-tight mt-0.5">
                                {{ auth()->user()->isGuru() ? 'Guru' : 'Siswa' }}
                            </span>
                        </div>
                        <span class="material-symbols-outlined text-outline text-base ml-0.5 transition-transform duration-200" :class="{ 'rotate-180': open }">expand_more</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 mt-2 w-56 bg-surface-container-lowest rounded-xl shadow-lg border border-outline-variant/60 py-1.5 z-50 overflow-hidden"
                        style="display: none;"
                    >
                        <!-- Mobile User Info Header -->
                        <div class="px-4 py-2.5 border-b border-outline-variant/40 sm:hidden">
                            <p class="font-body-sm text-body-sm font-bold text-primary truncate">{{ auth()->user()->name }}</p>
                            <p class="font-label-caps text-label-caps text-outline">{{ auth()->user()->email }}</p>
                        </div>

                        <!-- Dropdown Links -->
                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2.5 px-4 py-2.5 text-body-sm font-medium text-on-surface hover:bg-surface-container hover:text-secondary transition-colors"
                        >
                            <span class="material-symbols-outlined text-[20px] text-outline">manage_accounts</span>
                            <span>Pengaturan Akun</span>
                        </a>

                        <div class="h-px bg-outline-variant/40 my-1"></div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-body-sm font-medium text-error hover:bg-error-container/20 transition-colors text-left"
                            >
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Nav Strip -->
    <div class="md:hidden mt-16 bg-surface-container-lowest border-b border-outline-variant px-4 py-2 flex items-center justify-around text-body-sm">
        <a href="{{ route('member.dashboard') }}" class="py-1 px-2 {{ request()->routeIs('member.dashboard') ? 'text-secondary font-bold underline decoration-2 underline-offset-4' : 'text-on-surface-variant' }}">Dashboard</a>
        <a href="{{ route('member.books.index') }}" class="py-1 px-2 {{ request()->routeIs('member.books.*') ? 'text-secondary font-bold underline decoration-2 underline-offset-4' : 'text-on-surface-variant' }}">Katalog</a>
        <a href="{{ route('member.borrowings.current') }}" class="py-1 px-2 {{ request()->routeIs('member.borrowings.current') ? 'text-secondary font-bold underline decoration-2 underline-offset-4' : 'text-on-surface-variant' }}">Peminjaman</a>
        <a href="{{ route('member.borrowings.history') }}" class="py-1 px-2 {{ request()->routeIs('member.borrowings.history') ? 'text-secondary font-bold underline decoration-2 underline-offset-4' : 'text-on-surface-variant' }}">Riwayat</a>
    </div>

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-container-max mx-auto p-4 sm:p-8 pt-20 md:pt-24">
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
