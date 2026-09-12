<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Siswa - Library SMKN 5</title>
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
                        <span class="font-label-caps text-label-caps text-secondary uppercase tracking-wider font-bold">Registrasi Anggota</span>
                        <h1 class="font-headline-md text-headline-md font-bold text-primary">Pendaftaran Siswa SMKN 5</h1>
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

                <form method="POST" action="{{ route('register.siswa') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="space-y-2 sm:col-span-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="name">
                                Nama Lengkap Siswa
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">person</span>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none"
                                    placeholder="Contoh: Muhammad Rizky"
                                    required
                                    autofocus
                                >
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="email">
                                Email
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">mail</span>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none"
                                    placeholder="nama@siswa.smkn5.sch.id"
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
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none"
                                    placeholder="Username akun"
                                    required
                                >
                            </div>
                        </div>

                        <!-- NIS -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="nis">
                                NIS (Nomor Induk Siswa)
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline">badge</span>
                                <input
                                    id="nis"
                                    name="nis"
                                    type="text"
                                    value="{{ old('nis') }}"
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none"
                                    placeholder="Contoh: 20231015"
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
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none"
                                    placeholder="08xxxxxxxxxx"
                                >
                            </div>
                        </div>

                        <!-- Kelas -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="class">
                                Kelas
                            </label>
                            <div class="relative">
                                <select
                                    id="class"
                                    name="class"
                                    class="w-full pl-4 pr-10 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none appearance-none"
                                    required
                                >
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="X RPL 1" @selected(old('class') == 'X RPL 1')>X RPL 1</option>
                                    <option value="X RPL 2" @selected(old('class') == 'X RPL 2')>X RPL 2</option>
                                    <option value="XI RPL 1" @selected(old('class') == 'XI RPL 1')>XI RPL 1</option>
                                    <option value="XI RPL 2" @selected(old('class') == 'XI RPL 2')>XI RPL 2</option>
                                    <option value="XII RPL 1" @selected(old('class') == 'XII RPL 1')>XII RPL 1</option>
                                    <option value="X TKJ 1" @selected(old('class') == 'X TKJ 1')>X TKJ 1</option>
                                    <option value="XI TKJ 1" @selected(old('class') == 'XI TKJ 1')>XI TKJ 1</option>
                                    <option value="XII TKJ 1" @selected(old('class') == 'XII TKJ 1')>XII TKJ 1</option>
                                    <option value="X AKL 1" @selected(old('class') == 'X AKL 1')>X AKL 1</option>
                                    <option value="XI AKL 1" @selected(old('class') == 'XI AKL 1')>XI AKL 1</option>
                                    <option value="XII TSM" @selected(old('class') == 'XII TSM')>XII TSM</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Jurusan -->
                        <div class="space-y-2">
                            <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block font-semibold" for="major">
                                Jurusan / Kompetensi Keahlian
                            </label>
                            <div class="relative">
                                <select
                                    id="major"
                                    name="major"
                                    class="w-full pl-4 pr-10 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none appearance-none"
                                    required
                                >
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                    <option value="RPL" @selected(old('major') == 'RPL')>Rekayasa Perangkat Lunak (RPL)</option>
                                    <option value="TKJ" @selected(old('major') == 'TKJ')>Teknik Komputer & Jaringan (TKJ)</option>
                                    <option value="AKL" @selected(old('major') == 'AKL')>Akuntansi & Keuangan Lembaga (AKL)</option>
                                    <option value="TSM" @selected(old('major') == 'TSM')>Teknik Sepeda Motor (TSM)</option>
                                    <option value="MM" @selected(old('major') == 'MM')>Multimedia (MM)</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
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
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none"
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
                                    class="w-full pl-11 pr-4 py-2.5 bg-surface-container-low/40 border border-outline-variant rounded-lg font-body-sm text-on-surface focus:border-secondary focus:ring-1 focus:ring-secondary outline-none"
                                    placeholder="Ulangi password"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3 bg-secondary hover:bg-secondary/90 text-on-secondary rounded-lg font-title-sm text-title-sm font-semibold shadow-md transition-colors flex items-center justify-center gap-2 mt-4"
                    >
                        <span>Selesaikan Pendaftaran Siswa</span>
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
