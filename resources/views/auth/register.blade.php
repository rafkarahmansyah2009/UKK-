<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar sebagai Anggota - Library SMKN 5</title>
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
                            <h1 class="font-display-lg text-display-lg text-primary mb-2">Daftar sebagai Anggota</h1>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto">Buat akun untuk mengakses layanan perpustakaan secara penuh dan mulai menjelajahi koleksi kami.</p>
                        </div>

                        <!-- Step 1: Role Selection -->
                        <div class="transition-opacity duration-300 opacity-100 block" id="step-1">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <!-- Siswa Card -->
                                <label class="group cursor-pointer relative">
                                    <input class="peer sr-only" name="role" type="radio" value="siswa">
                                    <div class="p-6 rounded-xl bg-surface hover:bg-surface-container-low transition-all duration-200 peer-checked:bg-primary-fixed peer-checked:shadow-inner flex flex-col items-center text-center h-full relative overflow-hidden border border-outline-variant/30">
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-primary rounded-xl pointer-events-none transition-colors"></div>
                                        <div class="w-16 h-16 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">school</span>
                                        </div>
                                        <h3 class="font-title-sm text-title-sm text-on-surface mb-2">Siswa</h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Daftar sebagai siswa untuk meminjam buku dan akses materi pelajaran.</p>
                                        <!-- Check icon for selected state -->
                                        <div class="absolute top-4 right-4 opacity-0 peer-checked:opacity-100 text-primary transition-opacity">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Guru Card -->
                                <label class="group cursor-pointer relative">
                                    <input class="peer sr-only" name="role" type="radio" value="guru">
                                    <div class="p-6 rounded-xl bg-surface hover:bg-surface-container-low transition-all duration-200 peer-checked:bg-primary-fixed peer-checked:shadow-inner flex flex-col items-center text-center h-full relative overflow-hidden border border-outline-variant/30">
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-primary rounded-xl pointer-events-none transition-colors"></div>
                                        <div class="w-16 h-16 rounded-full bg-tertiary-container text-on-tertiary-container flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">local_library</span>
                                        </div>
                                        <h3 class="font-title-sm text-title-sm text-on-surface mb-2">Guru</h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Daftar sebagai guru untuk mengelola referensi dan merekomendasikan bahan bacaan.</p>
                                        <!-- Check icon for selected state -->
                                        <div class="absolute top-4 right-4 opacity-0 peer-checked:opacity-100 text-primary transition-opacity">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="flex justify-between items-center mt-8">
                                <a class="font-body-sm text-body-sm text-secondary hover:text-on-secondary-fixed-variant transition-colors flex items-center gap-1" href="{{ route('login') }}">
                                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Masuk
                                </a>
                                <button class="px-6 py-3 bg-primary text-on-primary rounded-lg font-body-sm text-body-sm font-semibold hover:bg-primary-container hover:shadow-md transition-all opacity-50 cursor-not-allowed flex items-center gap-2" id="btn-next" type="button" disabled>
                                    Lanjutkan <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Details Form -->
                        <div class="hidden opacity-0 transition-opacity duration-300" id="step-2">
                            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-outline-variant">
                                <button class="text-on-surface-variant hover:text-on-surface p-2 rounded-full hover:bg-surface-container transition-colors" id="btn-back" type="button">
                                    <span class="material-symbols-outlined">arrow_back</span>
                                </button>
                                <div>
                                    <h2 class="font-title-sm text-title-sm text-on-surface leading-tight">Lengkapi Data Diri</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant" id="role-subtitle">Mendaftar sebagai...</p>
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

                            <form method="POST" action="{{ route('register.process') }}" class="space-y-6" id="registration-form">
                                @csrf
                                <input type="hidden" name="role" id="form-role" value="">

                                <!-- Profile Photo Upload -->
                                <div class="flex flex-col items-center justify-center p-6 bg-surface border-2 border-dashed border-outline-variant rounded-xl hover:bg-surface-container-low transition-colors cursor-pointer group">
                                    <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-3 group-hover:bg-primary-fixed transition-colors">
                                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">add_a_photo</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface font-semibold">Unggah Foto Profil</p>
                                    <p class="font-label-caps text-label-caps text-on-surface-variant mt-1">PNG, JPG hingga 2MB</p>
                                    <input accept="image/png, image/jpeg" class="hidden" type="file" name="profile_photo">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Common Fields -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Nama Lengkap</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">person</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="Masukkan nama lengkap" required type="text" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Email</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">mail</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="nama@email.com" required type="email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Nomor Telepon</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">call</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="08xxxxxxxxxx" required type="tel" name="phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Username</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">alternate_email</span>
                                            <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="Pilih username" required type="text" name="username" value="{{ old('username') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Conditional Fields Container -->
                                <div class="p-5 bg-surface-container-low rounded-xl space-y-4" id="dynamic-fields">
                                    <!-- Injected via JS based on selection -->
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Password Fields -->
                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Password</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">lock</span>
                                            <input class="w-full pl-10 pr-12 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="••••••••" required type="password" name="password">
                                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface btn-toggle-password focus:outline-none" type="button">
                                                <span class="material-symbols-outlined">visibility_off</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Konfirmasi Password</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">lock_reset</span>
                                            <input class="w-full pl-10 pr-12 py-3 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" required type="password" name="password_confirmation">
                                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface btn-toggle-password focus:outline-none" type="button">
                                                <span class="material-symbols-outlined">visibility_off</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms Checkbox -->
                                <label class="flex items-start gap-3 p-4 bg-surface rounded-lg cursor-pointer group">
                                    <div class="relative flex items-center justify-center mt-0.5">
                                        <input class="peer appearance-none w-5 h-5 border-2 border-outline rounded bg-surface-container-lowest checked:bg-primary checked:border-primary transition-colors cursor-pointer" required type="checkbox" name="terms">
                                        <span class="material-symbols-outlined absolute text-on-primary text-[16px] opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity" style="font-variation-settings: 'FILL' 1;">check</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Saya menyetujui <a class="text-secondary hover:underline font-semibold" href="#">Syarat & Ketentuan</a> serta <a class="text-secondary hover:underline font-semibold" href="#">Kebijakan Privasi</a> Perpustakaan SMKN 5.</span>
                                </label>

                                <!-- Submit Button -->
                                <button class="w-full py-3.5 bg-primary text-on-primary rounded-lg font-body-md text-body-md font-semibold hover:bg-primary-container hover:shadow-lg transition-all flex justify-center items-center gap-2 group" type="submit">
                                    Daftar Sekarang <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">person_add</span>
                                </button>
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
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const regHeader = document.getElementById('reg-header');
            const successState = document.getElementById('success-state');
            const btnNext = document.getElementById('btn-next');
            const btnBack = document.getElementById('btn-back');
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const dynamicFieldsContainer = document.getElementById('dynamic-fields');
            const roleSubtitle = document.getElementById('role-subtitle');
            const formRole = document.getElementById('form-role');
            const form = document.getElementById('registration-form');
            const togglePasswordBtns = document.querySelectorAll('.btn-toggle-password');

            let selectedRole = null;

            // Templates for dynamic fields
            const siswaFields = `
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2 col-span-1 md:col-span-1">
                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">NIS</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">badge</span>
                            <input type="number" required class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="Nomor Induk" name="nis" value="{{ old('nis') }}">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Kelas</label>
                        <div class="relative">
                            <select required class="w-full pl-4 pr-10 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all appearance-none" name="class">
                                <option value="" disabled selected>Pilih Kelas</option>
                                <option value="X" @selected(old('class') == 'X')>Kelas X</option>
                                <option value="XI" @selected(old('class') == 'XI')>Kelas XI</option>
                                <option value="XII" @selected(old('class') == 'XII')>Kelas XII</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Jurusan</label>
                        <div class="relative">
                            <select required class="w-full pl-4 pr-10 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all appearance-none" name="major">
                                <option value="" disabled selected>Pilih Jurusan</option>
                                <option value="RPL" @selected(old('major') == 'RPL')">RPL</option>
                                <option value="TKJ" @selected(old('major') == 'TKJ')">TKJ</option>
                                <option value="MM" @selected(old('major') == 'MM')">Multimedia</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                        </div>
                    </div>
                </div>
            `;

            const guruFields = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">NIP (Opsional)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">badge</span>
                            <input type="number" class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="Nomor Induk Pegawai" name="nip" value="{{ old('nip') }}">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="font-label-caps text-label-caps text-on-surface-variant uppercase block">Mata Pelajaran</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">menu_book</span>
                            <input type="text" required class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all placeholder:text-outline" placeholder="Misal: Matematika" name="subject" value="{{ old('subject') }}">
                        </div>
                    </div>
                </div>
            `;

            // Handle Role Selection
            roleRadios.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    selectedRole = e.target.value;
                    btnNext.disabled = false;
                    btnNext.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            });

            // Navigation Next
            btnNext.addEventListener('click', () => {
                if (!selectedRole) return;

                // Set form role value
                formRole.value = selectedRole;

                // Populate dynamic fields
                dynamicFieldsContainer.innerHTML = selectedRole === 'siswa' ? siswaFields : guruFields;
                roleSubtitle.textContent = `Mendaftar sebagai ${selectedRole.charAt(0).toUpperCase() + selectedRole.slice(1)}`;

                // Transition
                step1.classList.remove('opacity-100');
                step1.classList.add('opacity-0');

                setTimeout(() => {
                    step1.classList.add('hidden');
                    step1.classList.remove('block');
                    regHeader.classList.add('hidden'); // Hide main header to save space

                    step2.classList.remove('hidden');
                    // slight delay for rendering before opacity fade in
                    setTimeout(() => {
                        step2.classList.remove('opacity-0');
                        step2.classList.add('opacity-100');
                    }, 50);
                }, 300);
            });

            // Navigation Back
            btnBack.addEventListener('click', () => {
                step2.classList.remove('opacity-100');
                step2.classList.add('opacity-0');

                setTimeout(() => {
                    step2.classList.add('hidden');

                    step1.classList.remove('hidden');
                    step1.classList.add('block');
                    regHeader.classList.remove('hidden');

                    setTimeout(() => {
                        step1.classList.remove('opacity-0');
                        step1.classList.add('opacity-100');
                    }, 50);
                }, 300);
            });

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