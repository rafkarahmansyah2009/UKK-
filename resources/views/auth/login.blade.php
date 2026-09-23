<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Library SMKN 5</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface antialiased font-body-md text-on-surface">
    <main class="min-h-screen flex items-center justify-center p-8">
        <div class="flex flex-col w-full h-full min-h-[calc(100vh-4rem)]">
            <div class="flex-1 flex w-full max-w-container-max mx-auto bg-surface-container-lowest rounded-2xl shadow-xl overflow-hidden relative">
                <!-- Left Panel: Branding & Imagery -->
                <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-between p-12 overflow-hidden bg-primary-container text-on-primary-container">
                    <!-- Background Image -->
                    <div class="absolute inset-0 bg-cover bg-center z-0 mix-blend-overlay opacity-40" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAs8bjDgxj4IxMxihtg7C6n0rYYvQJyEMtrRy3GEWqGXExDRnlse-jb6b4OQq3Ot3fMaFRPHCs1VFjp6dzvqX_QlG0yviXAuB_J_eQi89wr9CobBx7fcVRrzM7EyeQVjKGnW_IcItfMQmyaxyUe5JPdqMTJeslU700t3hxQe7D_Q5H2Af08ueo28aF7CVUtoValK1izCGh4-eyaId4jhDDguiP5vupZpcTGJZpk7-XbPu0ABZu8InjY');"></div>
                    <!-- Scrim -->
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-container via-primary-container/80 to-transparent z-10"></div>

                    <div class="relative z-20 flex flex-col items-start gap-4">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-4xl text-tertiary-fixed" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                            <span class="font-display-lg text-display-lg text-on-primary">Library SMKN 5</span>
                        </div>
                        <div class="h-1 w-12 bg-tertiary-fixed rounded-full"></div>
                    </div>

                    <div class="relative z-20 mt-auto flex flex-col gap-6">
                        <h1 class="font-display-lg text-display-lg text-on-primary leading-tight max-w-md">
                            Sistem Manajemen Perpustakaan Modern
                        </h1>
                        <p class="font-body-md text-body-md text-primary-fixed-dim max-w-sm">
                            Akses ribuan koleksi buku, jurnal, dan referensi akademik. Kelola peminjaman dan riwayat bacaan Anda dengan mudah dan efisien.
                        </p>
                        <!-- Decorative Elements -->
                        <div class="flex gap-4 mt-8">
                            <div class="flex flex-col gap-1">
                                <span class="font-title-sm text-title-sm text-on-primary">15K+</span>
                                <span class="font-label-caps text-label-caps text-primary-fixed-dim">Koleksi Buku</span>
                            </div>
                            <div class="w-[1px] h-12 bg-primary-fixed-dim/30"></div>
                            <div class="flex flex-col gap-1">
                                <span class="font-title-sm text-title-sm text-on-primary">2.4K</span>
                                <span class="font-label-caps text-label-caps text-primary-fixed-dim">Anggota Aktif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Circle -->
                    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-secondary/20 rounded-full blur-3xl z-0 pointer-events-none"></div>
                </div>

                <!-- Right Panel: Login Form -->
                <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-surface-container-lowest relative z-30">
                    <div class="w-full max-w-md flex flex-col gap-8">
                        <!-- Mobile Branding (Hidden on Desktop) -->
                        <div class="flex lg:hidden flex-col items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-primary-container rounded-2xl flex items-center justify-center shadow-md">
                                <span class="material-symbols-outlined text-3xl text-tertiary-fixed" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                            </div>
                            <span class="font-display-lg-mobile text-display-lg-mobile text-on-surface">Library SMKN 5</span>
                        </div>

                        <div class="flex flex-col gap-2 text-center lg:text-left">
                            <h2 class="font-headline-md text-headline-md text-on-surface">Selamat Datang</h2>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                        </div>

                        <!-- Session Status / Errors -->
                        @if (session('status'))
                            <div class="p-4 bg-secondary-container/10 border border-secondary-container rounded-lg text-secondary text-body-sm">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="p-4 bg-error-container/40 border border-error rounded-lg text-error text-body-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        @error('username')
                            <div class="p-3 bg-error-container/20 border border-error/30 rounded-lg text-error text-body-sm">
                                {{ $message }}
                            </div>
                        @enderror

                        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                            @csrf

                            <!-- Username / Email -->
                            <div class="flex flex-col gap-2">
                                <label class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider" for="username">
                                    Username atau Email
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">person</span>
                                    <input
                                        class="w-full pl-12 pr-4 py-3 bg-surface-container-lowest rounded-lg text-on-surface font-body-md text-body-md border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all duration-200"
                                        id="username"
                                        name="username"
                                        value="{{ old('username') }}"
                                        placeholder="Masukkan NIS atau Email"
                                        required
                                        autofocus
                                    >
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="flex flex-col gap-2">
                                <label class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider" for="password">
                                    Password
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">lock</span>
                                    <input
                                        class="w-full pl-12 pr-12 py-3 bg-surface-container-lowest rounded-lg text-on-surface font-body-md text-body-md border border-outline-variant focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all duration-200"
                                        id="password"
                                        name="password"
                                        placeholder="Masukkan Password"
                                        required
                                        type="password"
                                    >
                                    <button
                                        type="button"
                                        onclick="const input = document.getElementById('password'); const icon = this.querySelector('span'); if(input.type === 'password') { input.type = 'text'; icon.textContent = 'visibility'; } else { input.type = 'password'; icon.textContent = 'visibility_off'; }"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors focus:outline-none"
                                    >
                                        <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Options -->
                            <div class="flex items-center justify-between mt-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input
                                        id="remember"
                                        type="checkbox"
                                        name="remember"
                                        class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary cursor-pointer"
                                    >
                                    <span class="font-body-sm text-body-sm text-on-surface-variant group-hover:text-on-surface transition-colors">Ingat Saya</span>
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors font-medium" href="{{ route('password.request') }}">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="mt-6 w-full py-4 bg-primary-container hover:bg-primary-container/90 text-on-primary rounded-lg font-title-sm text-title-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 group relative overflow-hidden"
                            >
                                <span class="relative z-10">Masuk</span>
                                <span class="material-symbols-outlined relative z-10 group-hover:translate-x-1 transition-transform duration-200">login</span>
                                <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out z-0"></div>
                            </button>
                        </form>

                        <div class="mt-8 text-center border-t border-outline-variant/30 pt-8">
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Belum memiliki akun?
                                <a class="text-secondary hover:text-primary font-medium transition-colors" href="{{ route('register') }}">
                                    Daftar di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
