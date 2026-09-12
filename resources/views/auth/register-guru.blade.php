<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Guru - Library SMKN 5</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface antialiased font-body-md text-on-surface">
    <main class="min-h-screen flex items-center justify-center p-4 sm:p-8">
        <div class="flex flex-col w-full max-w-2xl mx-auto">
            <div class="bg-surface-container-lowest rounded-2xl shadow-xl p-8 sm:p-12 border border-outline-variant/40">
                <!-- Header -->
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('register') }}" class="p-2 rounded-lg hover:bg-surface-container-low text-on-surface-variant transition-colors" title="Kembali">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                    <div>
                        <span class="font-label-caps text-label-caps text-primary-container uppercase tracking-wider font-bold">Registrasi Anggota</span>
                        <h1 class="font-headline-md text-headline-md font-bold text-primary">Pendaftaran Guru / Tenaga Pendidik</h1>
                    </div>
                </div>

                <!-- Errors -->
                @if ($errors->any())
                    <div class="p-4 mb-6 bg-error-container/40 border border-error rounded-lg text-error text-body-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.guru') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="space-y-2 sm:col-span-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="name">
                                Nama Lengkap Beserta Gelar
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">person</span>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="Contoh: Drs. Hendro Wibowo, M.Kom"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="email">
                                Email Resmi / Dinas
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">mail</span>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="nama@guru.smkn5.sch.id"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="username">
                                Username
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">alternate_email</span>
                                <input
                                    id="username"
                                    name="username"
                                    type="text"
                                    value="{{ old('username') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="Username akun"
                                    required
                                >
                            </div>
                        </div>

                        <!-- NIP -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="nip">
                                NIP / NUPTK
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">badge</span>
                                <input
                                    id="nip"
                                    name="nip"
                                    type="text"
                                    value="{{ old('nip') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="197805122003121002"
                                    required
                                >
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="phone">
                                Nomor Telepon / WA
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">call</span>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="08xxxxxxxxxx"
                                >
                            </div>
                        </div>

                        <!-- Mata Pelajaran -->
                        <div class="space-y-2 sm:col-span-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="subject">
                                Bidang Studi / Mata Pelajaran yang Diampu
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">menu_book</span>
                                <input
                                    id="subject"
                                    name="subject"
                                    type="text"
                                    value="{{ old('subject') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="Contoh: Pemrograman Web & Perangkat Bergerak"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="password">
                                Password
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">lock</span>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="Min. 8 karakter"
                                    required
                                >
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="password_confirmation">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">lock</span>
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none"
                                    placeholder="Ulangi password"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3 bg-primary-container hover:bg-primary-container/90 text-on-primary rounded-lg font-title-sm text-title-sm font-semibold shadow-md transition-colors flex items-center justify-center gap-2 mt-4"
                    >
                        <span>Selesaikan Pendaftaran Guru</span>
                        <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                    </button>
                </form>

                <div class="pt-6 border-t border-outline-variant/40 text-center mt-6">
                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="text-secondary font-semibold hover:underline">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
