<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Registrasi - Library SMKN 5</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface antialiased font-body-md text-on-surface">
    <main class="min-h-screen flex items-center justify-center p-8">
        <div class="flex flex-col w-full h-full min-h-[calc(100vh-4rem)]">
            <div class="flex-1 flex w-full max-w-container-max mx-auto bg-surface-container-lowest rounded-2xl shadow-xl overflow-hidden relative">
                <!-- Left Panel -->
                <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-between p-12 overflow-hidden bg-primary-container text-on-primary-container">
                    <!-- Background Image -->
                    <div class="absolute inset-0 bg-cover bg-center z-0 mix-blend-overlay opacity-40" style="background-image: url('{{ asset('images/library/screen.png') }}');"></div>
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
                            Perpustakaan Digital SMKN 5
                        </h1>
                        <p class="font-body-md text-body-md text-primary-fixed-dim max-w-sm">
                            Jelajahi ribuan koleksi buku digital dan tingkatkan pengetahuan Anda bersama kami.
                        </p>
                        <!-- Decorative Stats -->
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

                <!-- Right Panel -->
                <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-surface-container-lowest relative z-30">
                    <div class="w-full max-w-xl">
                        <!-- Header Section -->
                        <div class="flex flex-col items-center mb-8 text-center">
                            <h1 class="font-display-lg text-display-lg text-primary mb-2">Daftar sebagai Anggota</h1>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto">Buat akun untuk mengakses layanan perpustakaan secara penuh dan mulai menjelajahi koleksi kami.</p>
                        </div>

                        <!-- Choice Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Siswa Card -->
                            <a href="{{ route('register.siswa') }}" class="group flex flex-col items-center p-6 rounded-xl bg-surface hover:bg-surface-container-low transition-all duration-200 hover:shadow-md flex flex-col items-center text-center h-full relative overflow-hidden border border-outline-variant/30 hover:border-secondary">
                                <div class="w-16 h-16 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">school</span>
                                </div>
                                <h3 class="font-title-sm text-title-sm text-on-surface mb-2">Siswa</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Daftar sebagai siswa untuk meminjam buku dan akses materi pelajaran.</p>
                            </a>

                            <!-- Guru Card -->
                            <a href="{{ route('register.guru') }}" class="group flex flex-col items-center p-6 rounded-xl bg-surface hover:bg-surface-container-low transition-all duration-200 hover:shadow-md flex flex-col items-center text-center h-full relative overflow-hidden border border-outline-variant/30 hover:border-primary-container">
                                <div class="w-16 h-16 rounded-full bg-tertiary-container text-on-tertiary-container flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">local_library</span>
                                </div>
                                <h3 class="font-title-sm text-title-sm text-on-surface mb-2">Guru</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Daftar sebagai guru untuk mengelola referensi dan merekomendasikan bahan bacaan.</p>
                            </a>
                        </div>

                        <div class="flex justify-center items-center mt-8">
                            <a class="font-body-sm text-body-sm text-secondary hover:text-on-secondary-fixed-variant transition-colors flex items-center gap-1" href="{{ route('login') }}">
                                <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Masuk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
