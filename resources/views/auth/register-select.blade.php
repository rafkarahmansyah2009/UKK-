<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Registrasi - Library SMKN 5</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface antialiased font-body-md text-on-surface">
    <main class="min-h-screen flex items-center justify-center p-4 sm:p-8">
        <div class="flex flex-col w-full max-w-4xl mx-auto">
            <div class="bg-surface-container-lowest rounded-2xl shadow-xl p-8 sm:p-12 border border-outline-variant/40 text-center">
                <!-- Branding Header -->
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-container rounded-2xl shadow-md text-tertiary-fixed mb-4">
                    <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                </div>
                <h1 class="font-display-lg text-display-lg text-primary font-bold mb-2">Pendaftaran Anggota</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto mb-10">
                    Pilih kategori keanggotaan Anda di SMKN 5 untuk melanjutkan proses pendaftaran.
                </p>

                <!-- Choice Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto mb-10">
                    <!-- Option Siswa -->
                    <a href="{{ route('register.siswa') }}" class="group flex flex-col items-center p-8 bg-surface-container-lowest hover:bg-surface-container-low/60 rounded-xl border-2 border-outline-variant hover:border-secondary transition-all shadow-sm hover:shadow-md text-left">
                        <div class="w-16 h-16 rounded-full bg-secondary-container/15 flex items-center justify-center text-secondary mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">school</span>
                        </div>
                        <h2 class="font-title-sm text-title-sm font-bold text-on-surface mb-2">Daftar sebagai Siswa</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant text-center">
                            Khusus bagi peserta didik aktif SMKN 5. Wajib menyertakan Nomor Induk Siswa (NIS), kelas, dan jurusan.
                        </p>
                        <span class="mt-6 inline-flex items-center gap-2 font-label-caps text-label-caps font-bold text-secondary uppercase tracking-wider group-hover:translate-x-1 transition-transform">
                            Pilih Pendaftaran Siswa
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </span>
                    </a>

                    <!-- Option Guru -->
                    <a href="{{ route('register.guru') }}" class="group flex flex-col items-center p-8 bg-surface-container-lowest hover:bg-surface-container-low/60 rounded-xl border-2 border-outline-variant hover:border-primary-container transition-all shadow-sm hover:shadow-md text-left">
                        <div class="w-16 h-16 rounded-full bg-primary-container/15 flex items-center justify-center text-primary-container mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">co_present</span>
                        </div>
                        <h2 class="font-title-sm text-title-sm font-bold text-on-surface mb-2">Daftar sebagai Guru</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant text-center">
                            Bagi dewan guru dan tenaga pendidik SMKN 5. Wajib menyertakan Nomor Induk Pegawai (NIP) dan mata pelajaran.
                        </p>
                        <span class="mt-6 inline-flex items-center gap-2 font-label-caps text-label-caps font-bold text-primary-container uppercase tracking-wider group-hover:translate-x-1 transition-transform">
                            Pilih Pendaftaran Guru
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </span>
                    </a>
                </div>

                <div class="pt-6 border-t border-outline-variant/40 text-center">
                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Sudah memiliki akun terdaftar?
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
