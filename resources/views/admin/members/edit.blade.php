<x-layouts.admin title="Edit Anggota - {{ $member->name }}">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-10 mb-8 rounded-b-3xl shadow-sm">
            <div class="max-w-3xl mx-auto flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant text-body-sm mb-1">
                        <a href="{{ route('admin.members.index') }}" class="hover:text-primary transition-colors">Anggota</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Edit</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 leading-tight">Edit Data Anggota</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Perbarui profil, informasi kelas/mapel, atau status keaktifan <strong class="text-primary">{{ $member->name }}</strong>.
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
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 p-6 sm:p-10" x-data="{ memberType: '{{ old('member_type', $member->member_type ?? 'siswa') }}' }">
                <form method="POST" action="{{ route('admin.members.update', $member) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Status Banner -->
                    <div class="p-4 rounded-xl border flex items-center justify-between {{ $member->status === 'active' ? 'bg-secondary-container/10 border-secondary/30 text-secondary' : 'bg-error-container/20 border-error/30 text-error' }}">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined">{{ $member->status === 'active' ? 'check_circle' : 'block' }}</span>
                            <span class="text-sm font-semibold">Status Saat Ini: {{ $member->status === 'active' ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                        <div>
                            <select name="status" class="bg-surface-container-lowest text-on-surface text-xs font-semibold py-1.5 px-3 rounded-lg border border-outline-variant focus:outline-none focus:border-secondary">
                                <option value="active" {{ old('status', $member->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $member->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Member Type Selector -->
                    <div>
                        <label class="block font-title-sm text-body-sm font-semibold text-on-surface mb-3">Tipe Keanggotaan <span class="text-error">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer border-2 rounded-xl p-4 flex items-center gap-3 transition-all" :class="memberType === 'siswa' ? 'border-secondary bg-secondary-container/10' : 'border-outline-variant hover:border-outline'">
                                <input type="radio" name="member_type" value="siswa" x-model="memberType" class="hidden">
                                <span class="material-symbols-outlined text-2xl text-secondary">school</span>
                                <div>
                                    <span class="block font-semibold text-on-surface text-body-sm">Siswa</span>
                                    <span class="text-xs text-on-surface-variant">NIS & Kelas</span>
                                </div>
                            </label>
                            <label class="cursor-pointer border-2 rounded-xl p-4 flex items-center gap-3 transition-all" :class="memberType === 'guru' ? 'border-secondary bg-secondary-container/10' : 'border-outline-variant hover:border-outline'">
                                <input type="radio" name="member_type" value="guru" x-model="memberType" class="hidden">
                                <span class="material-symbols-outlined text-2xl text-secondary">badge</span>
                                <div>
                                    <span class="block font-semibold text-on-surface text-body-sm">Guru</span>
                                    <span class="text-xs text-on-surface-variant">NIP & Mata Pelajaran</span>
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
                                value="{{ old('name', $member->name) }}"
                                required
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
                                value="{{ old('email', $member->email) }}"
                                required
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
                                value="{{ old('username', $member->username) }}"
                                required
                                class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('username') border-error @enderror"
                            >
                            @error('username')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Conditional: Siswa fields -->
                        <div x-show="memberType === 'siswa'" class="space-y-6 md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="nis" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">NIS</label>
                                <input
                                    type="text"
                                    id="nis"
                                    name="nis"
                                    value="{{ old('nis', $member->nis) }}"
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
                                    value="{{ old('class', $member->class) }}"
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
                                    value="{{ old('major', $member->major) }}"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('major') border-error @enderror"
                                >
                                @error('major')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Conditional: Guru fields -->
                        <div x-show="memberType === 'guru'" class="space-y-6 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nip" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">NIP</label>
                                <input
                                    type="text"
                                    id="nip"
                                    name="nip"
                                    value="{{ old('nip', $member->nip) }}"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('nip') border-error @enderror"
                                >
                                @error('nip')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Mata Pelajaran</label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    value="{{ old('subject', $member->subject) }}"
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
                                value="{{ old('phone', $member->phone) }}"
                                class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('phone') border-error @enderror"
                            >
                            @error('phone')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Password Baru (Opsional)</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Biarkan kosong jika tidak diubah"
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
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
