<x-layouts.public title="Informasi Perpustakaan - Library SMKN 5">
    <div class="flex flex-col w-full font-body-md text-on-surface bg-surface h-auto">
        <!-- Hero Section -->
        <div class="relative w-full px-4 sm:px-8 py-24 bg-surface-container-low overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="w-full h-full bg-cover bg-center opacity-30 mix-blend-multiply"
                    style="background-image: url('{{ asset('images/library/screen.png') }}');">
                </div>
            </div>
            <div class="relative z-10 max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <span class="font-label-caps text-label-caps text-secondary tracking-widest uppercase">Pusat Pembelajaran</span>
                    <h1 class="font-display-lg text-display-lg text-on-surface lg:text-[48px] lg:leading-[56px] tracking-tight">Informasi Perpustakaan</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl leading-relaxed">
                        Perpustakaan SMKN 5 adalah pusat pembelajaran modern yang dirancang untuk mendukung keunggulan akademik dan vokasional. Kami menyediakan akses ke ribuan koleksi literatur, ruang baca yang nyaman, dan layanan digital terintegrasi untuk seluruh siswa dan staf pengajar.
                    </p>
                </div>
                <div class="lg:col-span-7 relative">
                    <img class="w-full h-auto aspect-video object-cover rounded-2xl shadow-xl transform rotate-2 hover:rotate-0 transition-transform duration-500"
                        src="{{ asset('images/library/screen.png') }}"
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-secondary/10 rounded-full blur-2xl"></div>
                    <div class="absolute -top-6 -right-6 w-40 h-40 bg-primary/5 rounded-full blur-3xl"></div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="w-full max-w-container-max mx-auto px-4 sm:px-8 py-24 grid grid-cols-1 md:grid-cols-12 gap-12">
            <div class="md:col-span-4 flex flex-col gap-12">
                <!-- Jam Operasional -->
                <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-md relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-secondary/5 rounded-bl-full transform translate-x-1/2 -translate-y-1/2 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-secondary-container text-on-secondary-container rounded-xl flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">schedule</span>
                        </div>
                        <h2 class="font-headline-md text-headline-md text-on-surface">Jam Operasional</h2>
                    </div>
                    <ul class="flex flex-col gap-4">
                        <li class="flex justify-between items-center pb-4 border-b border-surface-variant">
                            <span class="text-on-surface-variant font-medium">Senin – Kamis</span>
                            <span class="font-bold text-on-surface bg-surface-container py-1 px-3 rounded-lg text-sm">07.00 – 15.00</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-on-surface-variant font-medium">Jumat</span>
                            <span class="font-bold text-error bg-error-container/50 py-1 px-3 rounded-lg text-sm">07.00 – 11.30</span>
                        </li>
                    </ul>
                </div>

                <!-- Kontak Kami -->
                <div class="bg-primary text-on-primary rounded-2xl p-8 shadow-lg relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="flex items-center gap-4 mb-6 relative z-10">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">contact_support</span>
                        </div>
                        <h2 class="font-headline-md text-headline-md">Kontak Kami</h2>
                    </div>
                    <div class="flex flex-col gap-5 relative z-10">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-on-primary-container mt-0.5">location_on</span>
                            <div>
                                <p class="font-bold">Library SMKN 5</p>
                                <p class="text-on-primary-container text-sm">Jl. Tripraja No.1, RT.003/RW.005<br>Panunggangan Utara, Kec. Pinang<br>Kota Tangerang, Banten 15143</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-on-primary-container">mail</span>
                            <a class="text-white hover:text-secondary-fixed transition-colors" href="mailto:info@smkn5.sch.id">info@smkn5.sch.id</a>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-on-primary-container">call</span>
                            <span class="text-white">(021) 12345678</span>
                        </div>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="rounded-2xl overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3502613417236!2d106.64302017469655!3d-6.217456593770514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fa277460b6d1%3A0xd06392fc4ad4133d!2sSMK%20Negeri%205%20Kota%20Tangerang!5e0!3m2!1sid!2sid!4v1789294465130!5m2!1sid!2sid"
                        width="100%"
                        height="250"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <div class="md:col-span-8 flex flex-col gap-16">
                <!-- Aturan Peminjaman -->
                <div class="flex flex-col gap-8">
                    <div class="flex items-center gap-4">
                        <h2 class="font-display-lg-mobile text-display-lg-mobile text-on-surface">Aturan Peminjaman</h2>
                        <div class="h-px bg-surface-variant flex-grow ml-4"></div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                            <div class="w-10 h-10 bg-surface-container rounded-full flex items-center justify-center flex-shrink-0 text-primary">
                                <span class="material-symbols-outlined">badge</span>
                            </div>
                            <div>
                                <h3 class="font-title-sm text-title-sm text-on-surface mb-1">Identitas Pribadi</h3>
                                <p class="text-body-sm text-on-surface-variant leading-relaxed">Anggota wajib menggunakan akun sendiri saat meminjam. Dilarang meminjamkan akun kepada orang lain.</p>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                            <div class="w-10 h-10 bg-surface-container rounded-full flex items-center justify-center flex-shrink-0 text-primary">
                                <span class="material-symbols-outlined">event_available</span>
                            </div>
                            <div>
                                <h3 class="font-title-sm text-title-sm text-on-surface mb-1">Tepat Waktu</h3>
                                <p class="text-body-sm text-on-surface-variant leading-relaxed">Buku harus dikembalikan sesuai batas waktu yang telah ditentukan oleh sistem perpustakaan.</p>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                            <div class="w-10 h-10 bg-error-container/30 rounded-full flex items-center justify-center flex-shrink-0 text-error">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                            <div>
                                <h3 class="font-title-sm text-title-sm text-on-surface mb-1">Denda Keterlambatan</h3>
                                <p class="text-body-sm text-on-surface-variant leading-relaxed">Keterlambatan pengembalian buku dapat dikenakan denda administratif sesuai peraturan sekolah.</p>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow flex items-start gap-4">
                            <div class="w-10 h-10 bg-surface-container rounded-full flex items-center justify-center flex-shrink-0 text-primary">
                                <span class="material-symbols-outlined">health_and_safety</span>
                            </div>
                            <div>
                                <h3 class="font-title-sm text-title-sm text-on-surface mb-1">Perawatan Buku</h3>
                                <p class="text-body-sm text-on-surface-variant leading-relaxed">Buku yang dipinjam harus dijaga dengan baik. Kerusakan atau kehilangan menjadi tanggung jawab peminjam.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alur Peminjaman -->
                <div class="flex flex-col gap-10">
                    <div class="flex flex-col gap-2">
                        <span class="font-label-caps text-label-caps text-secondary tracking-widest uppercase">Panduan Singkat</span>
                        <h2 class="font-display-lg-mobile text-display-lg-mobile text-on-surface">Alur Peminjaman</h2>
                    </div>
                    <div class="relative">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                            <div class="flex flex-col items-center text-center group cursor-default step-card" data-step="1">
                                <div class="w-16 h-16 bg-surface-container-lowest border-4 shadow-md rounded-full flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110 group-hover:border-secondary-container border-secondary/30">
                                    <span class="material-symbols-outlined text-secondary text-[28px]">search</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant mb-1">Langkah 1</span>
                                <h4 class="font-title-sm text-title-sm text-on-surface mb-2">Cari Buku</h4>
                                <p class="text-sm text-on-surface-variant">Temukan buku di halaman katalog.</p>
                            </div>
                            <div class="flex flex-col items-center text-center group cursor-default step-card" data-step="2">
                                <div class="w-16 h-16 bg-surface-container-lowest border-4 shadow-md rounded-full flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110 group-hover:border-secondary-container border-secondary/30">
                                    <span class="material-symbols-outlined text-secondary text-[28px]">pan_tool_alt</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant mb-1">Langkah 2</span>
                                <h4 class="font-title-sm text-title-sm text-on-surface mb-2">Ajukan</h4>
                                <p class="text-sm text-on-surface-variant">Klik tombol pinjam pada detail buku.</p>
                            </div>
                            <div class="flex flex-col items-center text-center group cursor-default step-card" data-step="3">
                                <div class="w-16 h-16 bg-surface-container-lowest border-4 shadow-md rounded-full flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110 group-hover:border-secondary-container border-secondary/30">
                                    <span class="material-symbols-outlined text-secondary text-[28px]">hourglass_empty</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant mb-1">Langkah 3</span>
                                <h4 class="font-title-sm text-title-sm text-on-surface mb-2">Tunggu</h4>
                                <p class="text-sm text-on-surface-variant">Tunggu persetujuan dari pustakawan.</p>
                            </div>
                            <div class="flex flex-col items-center text-center group cursor-default step-card" data-step="4">
                                <div class="w-16 h-16 bg-surface-container-lowest border-4 shadow-md rounded-full flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110 group-hover:border-secondary-container border-secondary/30">
                                    <span class="material-symbols-outlined text-secondary text-[28px]">assignment_return</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-on-surface-variant mb-1">Langkah 4</span>
                                <h4 class="font-title-sm text-title-sm text-on-surface mb-2">Kembalikan</h4>
                                <p class="text-sm text-on-surface-variant">Kembalikan buku tepat waktu.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>