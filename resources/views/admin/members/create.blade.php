<x-layouts.admin title="Tambah Anggota Baru">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-10 mb-8 rounded-b-3xl shadow-sm">
            <div class="max-w-3xl mx-auto flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant text-body-sm mb-1">
                        <a href="{{ route('admin.members.index') }}" class="hover:text-primary transition-colors">Anggota</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Tambah Baru</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 leading-tight">Tambah Anggota Baru</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Daftarkan siswa atau guru secara manual ke dalam sistem perpustakaan SMKN 5.
                    </p>
                </div>
                <a href="{{ route('admin.members.index') }}" class="px-4 py-2.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl mx-auto w-full px-4 sm:px-8">
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 p-6 sm:p-10" x-data="{ memberType: '{{ old('member_type', 'siswa') }}' }">
                <form method="POST" action="{{ route('admin.members.store') }}" class="space-y-6">
                    @csrf

                    <!-- Member Type Selector -->
                    <div>
                        <label class="block font-title-sm text-body-sm font-semibold text-on-surface mb-3">Tipe Keanggotaan <span class="text-error">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer border-2 rounded-xl p-4 flex items-center gap-3 transition-all" :class="memberType === 'siswa' ? 'border-secondary bg-secondary-container/10' : 'border-outline-variant hover:border-outline'">
                                <input type="radio" name="member_type" value="siswa" x-model="memberType" class="hidden">
                                <span class="material-symbols-outlined text-2xl text-secondary">school</span>
                                <div>
                                    <span class="block font-semibold text-on-surface text-body-sm">Siswa</span>
                                    <span class="text-xs text-on-surface-variant">Membutuhkan NIS & Kelas</span>
                                </div>
                            </label>
                            <label class="cursor-pointer border-2 rounded-xl p-4 flex items-center gap-3 transition-all" :class="memberType === 'guru' ? 'border-secondary bg-secondary-container/10' : 'border-outline-variant hover:border-outline'">
                                <input type="radio" name="member_type" value="guru" x-model="memberType" class="hidden">
                                <span class="material-symbols-outlined text-2xl text-secondary">badge</span>
                                <div>
                                    <span class="block font-semibold text-on-surface text-body-sm">Guru</span>
                                    <span class="text-xs text-on-surface-variant">Membutuhkan NIP & Mata Pelajaran</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Common Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Nama Lengkap <span class="text-error">*</span></label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                placeholder="Contoh: Muhammad Rizky Ramadhan"
                                class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('name') border-error @enderror"
                            >
                            @error('name')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Alamat Email <span class="text-error">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="email@smkn5.sch.id"
                                class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('email') border-error @enderror"
                            >
                            @error('email')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="username" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Username <span class="text-error">*</span></label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                placeholder="rizky.ramadhan"
                                class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('username') border-error @enderror"
                            >
                            @error('username')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Conditional: Siswa fields -->
                        <div x-show="memberType === 'siswa'" class="space-y-6 md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="nis" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Nomor Induk Siswa (NIS) <span class="text-error">*</span></label>
                                <input
                                    type="text"
                                    id="nis"
                                    name="nis"
                                    value="{{ old('nis') }}"
                                    placeholder="Contoh: 20241001"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('nis') border-error @enderror"
                                >
                                @error('nis')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="class" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Kelas</label>
                                <input
                                    type="text"
                                    id="class"
                                    name="class"
                                    value="{{ old('class') }}"
                                    placeholder="Contoh: XI RPL 1"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('class') border-error @enderror"
                                >
                                @error('class')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="major" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Jurusan</label>
                                <input
                                    type="text"
                                    id="major"
                                    name="major"
                                    value="{{ old('major') }}"
                                    placeholder="Contoh: Rekayasa Perangkat Lunak"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('major') border-error @enderror"
                                >
                                @error('major')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Conditional: Guru fields -->
                        <div x-show="memberType === 'guru'" class="space-y-6 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
                            <div>
                                <label for="nip" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Nomor Induk Pegawai (NIP) <span class="text-error">*</span></label>
                                <input
                                    type="text"
                                    id="nip"
                                    name="nip"
                                    value="{{ old('nip') }}"
                                    placeholder="Contoh: 198503152010011005"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('nip') border-error @enderror"
                                >
                                @error('nip')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Mata Pelajaran yang Diampu</label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    placeholder="Contoh: Pemrograman Web & Bergerak"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('subject') border-error @enderror"
                                >
                                @error('subject')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Nomor Telepon / WhatsApp</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="08123456789"
                                class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('phone') border-error @enderror"
                            >
                            @error('phone')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Password Akun <span class="text-error">*</span></label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Minimal 6 karakter"
                                class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('password') border-error @enderror"
                            >
                            @error('password')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="pt-6 border-t border-outline-variant/40 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.members.index') }}" class="px-6 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold shadow-md flex items-center gap-2 transition-all">
                            <span class="material-symbols-outlined text-[20px]">person_add</span>
                            Simpan Anggota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
