<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Guru - Library SMKN 5</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface antialiased font-body-md text-on-background">
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
                    <div class="w-full max-w-xl z-10 relative overflow-hidden transition-all duration-500 ease-in-out" id="registration-container">
                        <!-- Header Section -->
                        <div class="flex flex-col items-center mb-8 text-center" id="reg-header">
                            <h1 class="font-display-lg text-display-lg text-primary mb-2">Form Pendaftaran Guru</h1>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto">Lengkapi data diri Anda sebagai pengajar SMKN 5</p>
                        </div>

                        <!-- Errors -->
                        @if ($errors->any())
                            <div class="p-4 mb-6 bg-error-container/40 border border-error rounded-lg text-error text-body-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <!-- Step 1: Form Guru -->
                        <div class="transition-opacity duration-300 opacity-100 block" id="step-1">
                            <form class="space-y-6" id="registration-form" method="POST" action="{{ route('register.guru') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="flex flex-col items-center justify-center mb-6">
                                    <label for="guru_profile_photo" class="cursor-pointer relative group flex flex-col items-center">
                                        <div class="w-24 h-24 rounded-full bg-surface-container-high border-2 border-dashed border-outline-variant flex items-center justify-center mb-2 group-hover:bg-primary-fixed group-hover:border-secondary transition-all overflow-hidden relative shadow-sm">
                                            <img id="guru-photo-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                                            <span id="guru-photo-placeholder" class="material-symbols-outlined text-3xl text-on-surface-variant group-hover:text-primary transition-colors">add_a_photo</span>
                                        </div>
                                        <div class="absolute bottom-6 right-0 bg-primary text-on-primary p-1.5 rounded-full shadow-md group-hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-[16px] block">photo_camera</span>
                                        </div>
                                        <input
                                            id="guru_profile_photo"
                                            accept="image/png,image/jpeg,image/jpg,image/webp"
                                            class="hidden"
                                            type="file"
                                            name="profile_photo"
                                            onchange="
                                                const file = this.files[0];
                                                if (file) {
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => {
                                                        const img = document.getElementById('guru-photo-preview');
                                                        const placeholder = document.getElementById('guru-photo-placeholder');
                                                        img.src = e.target.result;
                                                        img.classList.remove('hidden');
                                                        placeholder.classList.add('hidden');
                                                    };
                                                    reader.readAsDataURL(file);
                                                }
                                            "
                                        >
                                    </label>
                                    <p class="font-label-caps text-label-caps text-on-surface-variant mt-1">Unggah Foto Profil</p>
                                    <p class="font-label-caps text-xs text-outline">JPG, PNG atau WebP (Maksimal 2MB)</p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Nama Lengkap -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Nama Lengkap</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">person</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Nama Lengkap" required type="text" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Email</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">mail</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="email@smkn5.sch.id" required type="email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Nomor Telepon</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">call</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="08xxxxxxxxxx" required type="tel" name="phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>

                                    <!-- Username -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Username</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">alternate_email</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Username" required type="text" name="username" value="{{ old('username') }}">
                                        </div>
                                    </div>

                                    <!-- NIP -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">NIP (Opsional)</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">badge</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Nomor Induk Pegawai" type="text" name="nip" value="{{ old('nip') }}">
                                        </div>
                                    </div>

                                    <!-- Mata Pelajaran -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Mata Pelajaran</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">menu_book</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Misal: Matematika" required type="text" name="subject" value="{{ old('subject') }}">
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Password</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">lock</span>
                                            <input class="w-full pl-10 pr-12 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Minimal 8 karakter" required minlength="8" type="password" name="password">
                                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface btn-toggle-password focus:outline-none" type="button">
                                                <span class="material-symbols-outlined">visibility_off</span>
                                            </button>
                                        </div>
                                        <p class="font-label-caps text-xs text-on-surface-variant/70">Minimal 8 karakter</p>
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Konfirmasi Password</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">lock_reset</span>
                                            <input class="w-full pl-10 pr-12 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Ulangi password" required minlength="8" type="password" name="password_confirmation">
                                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant btn-toggle-password" type="button">
                                                <span class="material-symbols-outlined">visibility_off</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <label class="flex items-start gap-3 p-4 bg-surface rounded-lg cursor-pointer group">
                                    <div class="relative flex items-center justify-center mt-0.5">
                                        <input class="peer appearance-none w-5 h-5 border-2 border-outline rounded bg-surface-container-lowest checked:bg-primary checked:border-primary transition-colors cursor-pointer" required type="checkbox" name="terms">
                                        <span class="material-symbols-outlined absolute text-on-primary text-[16px] opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity" style="font-variation-settings: 'FILL' 1;">check</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Saya menyetujui <a class="text-secondary hover:underline font-semibold" href="#">Syarat & Ketentuan</a></span>
                                </label>

                                <button class="w-full py-3.5 bg-primary text-on-primary rounded-lg font-body-md font-semibold hover:bg-primary-container transition-all flex justify-center items-center gap-2 group" type="submit">
                                    Daftar <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">person_add</span>
                                </button>

                                <div class="text-center mt-4">
                                    <a class="font-body-sm text-secondary hover:underline" href="{{ route('login') }}">Sudah punya akun? Masuk</a>
                                </div>
                            </form>
                        </div>

                        <!-- Success State -->
                        <div class="hidden opacity-0 transition-opacity duration-500 flex flex-col items-center justify-center py-12 text-center" id="success-state">
                            <div class="w-24 h-24 bg-primary-fixed rounded-full flex items-center justify-center mb-6 relative">
                                <div class="absolute inset-0 bg-primary-fixed animate-ping rounded-full opacity-50"></div>
                                <span class="material-symbols-outlined text-5xl text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            </div>
                            <h2 class="font-display-lg text-display-lg text-primary mb-3">Pendaftaran Berhasil!</h2>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-sm mx-auto mb-8">Akun Anda telah berhasil dibuat. Silakan masuk menggunakan username dan password yang telah didaftarkan.</p>
                            <a class="px-8 py-3 bg-primary text-on-primary rounded-lg font-body-md text-body-md font-semibold hover:bg-primary-container transition-all" href="{{ route('login') }}">
                                Lanjut ke Masuk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('registration-form');
            const successState = document.getElementById('success-state');
            const togglePasswordBtns = document.querySelectorAll('.btn-toggle-password');

            // Password Toggle Visibility
            togglePasswordBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('span');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.textContent = 'visibility';
                    } else {
                        input.type = 'password';
                        icon.textContent = 'visibility_off';
                    }
                });
            });

            // Handle Form Submit - Let Laravel handle the submission
            form.addEventListener('submit', (e) => {
                // Form will submit normally to Laravel
                // The success state will be handled by Laravel redirect
            });
        });
    </script>
</body>
</html>
