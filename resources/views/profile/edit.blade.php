@if(auth()->user()->isAdmin())
    <x-layouts.admin title="Profil Administrator">
        <div class="p-8 max-w-4xl mx-auto space-y-8">
            <h1 class="font-display-lg text-display-lg text-primary font-bold">Profil Akun</h1>
            <div class="p-6 bg-surface-container-lowest border border-outline-variant/50 shadow-sm rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-surface-container-lowest border border-outline-variant/50 shadow-sm rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </x-layouts.admin>
@else
    <x-layouts.member title="Pengaturan Akun Member">
        <div class="w-full max-w-6xl mx-auto px-2 sm:px-4 py-2">
            <!-- Breadcrumb & Page Header -->
            <div class="flex flex-col gap-2 mb-8">
                <nav class="flex items-center gap-2 font-body-sm text-body-sm text-outline">
                    <a href="{{ route('member.dashboard') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    <span class="material-symbols-outlined text-xs text-outline-variant">chevron_right</span>
                    <span class="text-on-surface font-semibold">Pengaturan Akun</span>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-1">
                    <div>
                        <h1 class="font-headline-md text-headline-md font-bold text-primary tracking-tight">Pengaturan Akun Member</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola profil data {{ $user->isGuru() ? 'guru' : 'siswa' }}/anggota dan informasi keamanan akun perpustakaan Anda.</p>
                    </div>
                    <div class="flex items-center gap-2.5 px-3 py-1.5 bg-surface-container rounded-lg self-start sm:self-auto shadow-sm">
                        <span class="material-symbols-outlined text-secondary text-lg">verified_user</span>
                        <span class="font-label-caps text-label-caps text-primary uppercase font-bold tracking-wider">Status {{ ucfirst($user->status ?? 'Aktif') }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Alert Notifications -->
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" class="transition-all duration-300 mb-6 p-4 rounded-xl bg-surface-container-lowest border border-secondary/20 shadow-md flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-secondary text-2xl">check_circle</span>
                        <div>
                            <p class="font-title-sm text-title-sm text-primary font-bold">Berhasil Disimpan</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Profil akun member perpustakaan berhasil diperbarui.</p>
                        </div>
                    </div>
                    <button type="button" @click="show = false" class="p-1 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" class="transition-all duration-300 mb-6 p-4 rounded-xl bg-surface-container-lowest border border-secondary/20 shadow-md flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-secondary text-2xl">check_circle</span>
                        <div>
                            <p class="font-title-sm text-title-sm text-primary font-bold">Password Berhasil Diperbarui</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Kata sandi akun Anda telah berhasil diperbarui.</p>
                        </div>
                    </div>
                    <button type="button" @click="show = false" class="p-1 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            @endif

            <!-- Main Grid: Profil Pengguna & Keamanan Akun -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Card 1: Profil Pengguna (7 Cols) -->
                <section class="lg:col-span-7 bg-surface-container-lowest rounded-xl shadow-md p-6 sm:p-8 flex flex-col gap-6 border border-outline-variant/40">
                    <!-- Header Card -->
                    <div class="flex items-center gap-3.5 pb-2">
                        <div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-primary-container shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-2xl">person</span>
                        </div>
                        <div>
                            <h2 class="font-title-sm text-title-sm font-bold text-primary">Profil Pengguna</h2>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Informasi data anggota perpustakaan SMKN 5.</p>
                        </div>
                    </div>

                    <!-- Area Foto Profil & Form Profil -->
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex flex-col gap-6" id="profileForm"
                          x-data="{
                              photoPreview: null,
                              hasCustomAvatar: {{ $user->avatar ? 'true' : 'false' }},
                              handlePhoto(e) {
                                  const file = e.target.files && e.target.files[0];
                                  if (file) {
                                      const reader = new FileReader();
                                      reader.onload = (ev) => {
                                          this.photoPreview = ev.target.result;
                                      };
                                      reader.readAsDataURL(file);
                                  }
                              },
                              resetPhoto() {
                                  this.photoPreview = null;
                                  $refs.avatarInput.value = '';
                              }
                          }">
                        @csrf
                        @method('patch')

                        <div class="p-5 bg-surface rounded-xl flex flex-col sm:flex-row items-center gap-6">
                            <div class="relative shrink-0">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-24 h-24 rounded-full object-cover shadow-sm bg-surface-container border-2 border-secondary" alt="{{ $user->name }}">
                                </template>
                                <template x-if="!photoPreview">
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar }}" class="w-24 h-24 rounded-full object-cover shadow-sm bg-surface-container border border-outline-variant" id="avatarPreview" alt="{{ $user->name }}">
                                    @else
                                        <div class="w-24 h-24 rounded-full bg-secondary/15 border-2 border-secondary/30 flex items-center justify-center font-bold text-secondary text-2xl shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </template>

                                <span class="absolute bottom-0 right-0 px-2 py-0.5 rounded-full bg-surface-container-lowest text-secondary shadow-sm font-label-caps text-label-caps font-bold flex items-center gap-1 border border-outline-variant/30">
                                    <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                    {{ $user->isGuru() ? 'Guru Aktif' : 'Siswa Aktif' }}
                                </span>
                            </div>

                            <div class="flex flex-col items-center sm:items-start text-center sm:text-left gap-3">
                                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                                    <label for="avatarUploadInput" class="cursor-pointer inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-primary-container text-on-primary hover:bg-primary transition-colors font-body-sm text-body-sm font-semibold shadow-sm">
                                        <span class="material-symbols-outlined text-lg">photo_camera</span>
                                        <span>Ubah Foto</span>
                                    </label>
                                    <input
                                        type="file"
                                        id="avatarUploadInput"
                                        name="avatar"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="hidden"
                                        x-ref="avatarInput"
                                        @change="handlePhoto($event)"
                                    />
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-error hover:bg-error-container/30 transition-colors font-body-sm text-body-sm font-medium"
                                        @click="resetPhoto()"
                                    >
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                        <span>Batal Foto</span>
                                    </button>
                                </div>
                                <p class="font-label-caps text-label-caps text-outline">Format JPG, PNG atau WebP. Maksimal 2MB. Resolusi disarankan 1:1.</p>
                                @error('avatar')
                                    <p class="font-body-sm text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Field Form Profil -->
                        <div class="flex flex-col gap-4">
                            <!-- Nama Lengkap -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-body-sm text-body-sm font-semibold text-primary" for="namaLengkap">Nama Lengkap</label>
                                <input
                                    class="w-full px-4 py-2.5 rounded-lg bg-surface-container-low text-on-surface font-body-sm text-body-sm border border-transparent focus:border-secondary focus:bg-surface-container-lowest focus:outline-none shadow-sm transition-all @error('name') border-error @enderror"
                                    id="namaLengkap"
                                    name="name"
                                    required
                                    type="text"
                                    value="{{ old('name', $user->name) }}"
                                />
                                @error('name')
                                    <p class="font-body-sm text-xs text-error mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($user->isGuru())
                                    <!-- NIP (Readonly) -->
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between">
                                            <label class="font-body-sm text-body-sm font-semibold text-primary" for="nipField">NIP (Nomor Induk Pegawai)</label>
                                            <span class="flex items-center gap-1 text-outline font-label-caps text-label-caps">
                                                <span class="material-symbols-outlined text-xs">lock</span> Terkunci
                                            </span>
                                        </div>
                                        <div class="relative">
                                            <input
                                                class="w-full px-4 py-2.5 rounded-lg bg-surface-container text-on-surface-variant font-body-sm text-body-sm cursor-not-allowed select-none border border-outline-variant/30"
                                                id="nipField"
                                                readonly
                                                type="text"
                                                value="{{ $user->nip ?? '-' }}"
                                            />
                                            <span class="material-symbols-outlined text-outline absolute right-3 top-1/2 -translate-y-1/2 text-lg">verified</span>
                                        </div>
                                    </div>
                                    <!-- Mata Pelajaran (Readonly) -->
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between">
                                            <label class="font-body-sm text-body-sm font-semibold text-primary" for="subjectField">Mata Pelajaran</label>
                                            <span class="flex items-center gap-1 text-outline font-label-caps text-label-caps">
                                                <span class="material-symbols-outlined text-xs">lock</span> Terkunci
                                            </span>
                                        </div>
                                        <div class="relative">
                                            <input
                                                class="w-full px-4 py-2.5 rounded-lg bg-surface-container text-on-surface-variant font-body-sm text-body-sm cursor-not-allowed select-none border border-outline-variant/30"
                                                id="subjectField"
                                                readonly
                                                type="text"
                                                value="{{ $user->subject ?? '-' }}"
                                            />
                                            <span class="material-symbols-outlined text-outline absolute right-3 top-1/2 -translate-y-1/2 text-lg">school</span>
                                        </div>
                                    </div>
                                @else
                                    <!-- NIS (Readonly) -->
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between">
                                            <label class="font-body-sm text-body-sm font-semibold text-primary" for="nisField">NIS (Nomor Induk Siswa)</label>
                                            <span class="flex items-center gap-1 text-outline font-label-caps text-label-caps">
                                                <span class="material-symbols-outlined text-xs">lock</span> Terkunci
                                            </span>
                                        </div>
                                        <div class="relative">
                                            <input
                                                class="w-full px-4 py-2.5 rounded-lg bg-surface-container text-on-surface-variant font-body-sm text-body-sm cursor-not-allowed select-none border border-outline-variant/30"
                                                id="nisField"
                                                readonly
                                                type="text"
                                                value="{{ $user->nis ?? '-' }}"
                                            />
                                            <span class="material-symbols-outlined text-outline absolute right-3 top-1/2 -translate-y-1/2 text-lg">verified</span>
                                        </div>
                                    </div>
                                    <!-- Kelas / Jurusan (Readonly) -->
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between">
                                            <label class="font-body-sm text-body-sm font-semibold text-primary" for="kelasField">Kelas / Jurusan</label>
                                            <span class="flex items-center gap-1 text-outline font-label-caps text-label-caps">
                                                <span class="material-symbols-outlined text-xs">lock</span> Terkunci
                                            </span>
                                        </div>
                                        <div class="relative">
                                            <input
                                                class="w-full px-4 py-2.5 rounded-lg bg-surface-container text-on-surface-variant font-body-sm text-body-sm cursor-not-allowed select-none border border-outline-variant/30"
                                                id="kelasField"
                                                readonly
                                                type="text"
                                                value="{{ trim(($user->class ?? '') . ' ' . ($user->major ?? '')) ?: '-' }}"
                                            />
                                            <span class="material-symbols-outlined text-outline absolute right-3 top-1/2 -translate-y-1/2 text-lg">school</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <p class="font-label-caps text-label-caps text-outline italic -mt-1">
                                *Data nomor induk dan jurusan disinkronkan dengan data induk SMKN 5. Hubungi staf perpustakaan jika terdapat kesalahan data.
                            </p>

                            <!-- Email -->
                            <div class="flex flex-col gap-1.5 pt-1">
                                <label class="font-body-sm text-body-sm font-semibold text-primary" for="emailSiswa">Email Siswa/Anggota</label>
                                <div class="relative">
                                    <input
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-surface-container-low text-on-surface font-body-sm text-body-sm border border-transparent focus:border-secondary focus:bg-surface-container-lowest focus:outline-none shadow-sm transition-all @error('email') border-error @enderror"
                                        id="emailSiswa"
                                        name="email"
                                        required
                                        type="email"
                                        value="{{ old('email', $user->email) }}"
                                    />
                                    <span class="material-symbols-outlined text-outline absolute left-3 top-1/2 -translate-y-1/2 text-lg">mail</span>
                                </div>
                                @error('email')
                                    <p class="font-body-sm text-xs text-error mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone / Whatsapp -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-body-sm text-body-sm font-semibold text-primary" for="noWhatsapp">Nomor HP / WhatsApp</label>
                                <div class="relative">
                                    <input
                                        class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-surface-container-low text-on-surface font-body-sm text-body-sm border border-transparent focus:border-secondary focus:bg-surface-container-lowest focus:outline-none shadow-sm transition-all @error('phone') border-error @enderror"
                                        id="noWhatsapp"
                                        name="phone"
                                        placeholder="Contoh: 081234567890"
                                        type="tel"
                                        value="{{ old('phone', $user->phone) }}"
                                    />
                                    <span class="material-symbols-outlined text-outline absolute left-3 top-1/2 -translate-y-1/2 text-lg">chat</span>
                                </div>
                                <span class="font-label-caps text-label-caps text-outline">Digunakan untuk notifikasi jatuh tempo pengembalian dan reservasi buku.</span>
                                @error('phone')
                                    <p class="font-body-sm text-xs text-error mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Footer Actions Profil -->
                            <div class="flex items-center justify-end gap-3 pt-4 mt-2">
                                <button
                                    type="button"
                                    class="px-5 py-2.5 rounded-lg bg-surface-container text-on-surface font-body-sm text-body-sm font-medium hover:bg-surface-container-high transition-colors"
                                    onclick="window.location.reload()"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="px-6 py-2.5 rounded-lg bg-secondary text-white font-body-sm text-body-sm font-bold shadow-md hover:bg-secondary/90 transition-colors flex items-center gap-2"
                                >
                                    <span class="material-symbols-outlined text-lg">save</span>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </section>

                <!-- Card 2: Keamanan Akun & Kartu Digital (5 Cols) -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <!-- Form Keamanan Password -->
                    <section class="bg-surface-container-lowest rounded-xl shadow-md p-6 sm:p-8 flex flex-col gap-6 border border-outline-variant/40">
                        <div class="flex items-center gap-3.5 pb-2">
                            <div class="w-12 h-12 rounded-xl bg-surface-container-low flex items-center justify-center text-primary-container shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-2xl">shield</span>
                            </div>
                            <div>
                                <h2 class="font-title-sm text-title-sm font-bold text-primary">Keamanan Akun</h2>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Perbarui kata sandi untuk melindungi privasi akun anggota Anda.</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4" id="passwordForm"
                              x-data="{
                                  showCurrent: false,
                                  showNew: false,
                                  showConfirm: false,
                                  newPass: '',
                                  confirmPass: '',
                                  get mismatch() {
                                      return this.confirmPass.length > 0 && this.newPass !== this.confirmPass;
                                  }
                              }">
                            @csrf
                            @method('put')

                            <!-- Password Saat Ini -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-body-sm text-body-sm font-semibold text-primary" for="current_password">Password Saat Ini</label>
                                <div class="relative">
                                    <input
                                        class="w-full pl-4 pr-11 py-2.5 rounded-lg bg-surface-container-low text-on-surface font-body-sm text-body-sm border border-transparent focus:border-secondary focus:bg-surface-container-lowest focus:outline-none shadow-sm transition-all @error('current_password', 'updatePassword') border-error @enderror"
                                        id="current_password"
                                        name="current_password"
                                        placeholder="Masukkan password saat ini"
                                        required
                                        :type="showCurrent ? 'text' : 'password'"
                                        autocomplete="current-password"
                                    />
                                    <button
                                        type="button"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface p-1 focus:outline-none"
                                        @click="showCurrent = !showCurrent"
                                    >
                                        <span class="material-symbols-outlined text-lg" x-text="showCurrent ? 'visibility_off' : 'visibility'">visibility</span>
                                    </button>
                                </div>
                                @if($errors->updatePassword->has('current_password'))
                                    <p class="font-body-sm text-xs text-error mt-0.5">{{ $errors->updatePassword->first('current_password') }}</p>
                                @endif
                            </div>

                            <!-- Password Baru -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-body-sm text-body-sm font-semibold text-primary" for="password">Password Baru</label>
                                <div class="relative">
                                    <input
                                        class="w-full pl-4 pr-11 py-2.5 rounded-lg bg-surface-container-low text-on-surface font-body-sm text-body-sm border border-transparent focus:border-secondary focus:bg-surface-container-lowest focus:outline-none shadow-sm transition-all @error('password', 'updatePassword') border-error @enderror"
                                        id="password"
                                        name="password"
                                        minlength="8"
                                        placeholder="Minimal 8 karakter"
                                        required
                                        x-model="newPass"
                                        :type="showNew ? 'text' : 'password'"
                                        autocomplete="new-password"
                                    />
                                    <button
                                        type="button"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface p-1 focus:outline-none"
                                        @click="showNew = !showNew"
                                    >
                                        <span class="material-symbols-outlined text-lg" x-text="showNew ? 'visibility_off' : 'visibility'">visibility</span>
                                    </button>
                                </div>
                                @if($errors->updatePassword->has('password'))
                                    <p class="font-body-sm text-xs text-error mt-0.5">{{ $errors->updatePassword->first('password') }}</p>
                                @endif
                            </div>

                            <!-- Konfirmasi Password Baru -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-body-sm text-body-sm font-semibold text-primary" for="password_confirmation">Konfirmasi Password Baru</label>
                                <div class="relative">
                                    <input
                                        class="w-full pl-4 pr-11 py-2.5 rounded-lg bg-surface-container-low text-on-surface font-body-sm text-body-sm border border-transparent focus:border-secondary focus:bg-surface-container-lowest focus:outline-none shadow-sm transition-all"
                                        :class="{ 'border-error': mismatch }"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        minlength="8"
                                        placeholder="Ulangi password baru"
                                        required
                                        x-model="confirmPass"
                                        :type="showConfirm ? 'text' : 'password'"
                                        autocomplete="new-password"
                                    />
                                    <button
                                        type="button"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface p-1 focus:outline-none"
                                        @click="showConfirm = !showConfirm"
                                    >
                                        <span class="material-symbols-outlined text-lg" x-text="showConfirm ? 'visibility_off' : 'visibility'">visibility</span>
                                    </button>
                                </div>
                                <p class="font-label-caps text-label-caps text-error" x-show="mismatch" style="display: none;">
                                    Konfirmasi password tidak cocok!
                                </p>
                                @if($errors->updatePassword->has('password_confirmation'))
                                    <p class="font-body-sm text-xs text-error mt-0.5">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                                @endif
                            </div>

                            <!-- Box Informatif Kecil Aturan Peminjaman -->
                            <div class="p-3.5 bg-surface-container-low rounded-xl flex items-start gap-3 mt-1 shadow-sm border border-outline-variant/30">
                                <span class="material-symbols-outlined text-secondary text-xl shrink-0 mt-0.5">info</span>
                                <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                    Akun ini terhubung dengan kartu anggota perpustakaan digital SMKN 5. Jangan membagikan kata sandi kepada orang lain demi keselamatan transaksi buku Anda.
                                </p>
                            </div>

                            <!-- Footer Action Keamanan -->
                            <div class="pt-2">
                                <button
                                    type="submit"
                                    class="w-full py-2.5 px-4 rounded-lg bg-primary-container text-on-primary hover:bg-primary font-body-sm text-body-sm font-bold shadow-md transition-colors flex items-center justify-center gap-2"
                                >
                                    <span class="material-symbols-outlined text-lg">lock_reset</span>
                                    <span>Ubah Password</span>
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- Kartu Anggota Digital Preview -->
                    <div class="bg-surface-container-lowest rounded-xl shadow-md p-6 relative overflow-hidden flex flex-col gap-4 border border-outline-variant/40">
                        <div class="flex items-center justify-between">
                            <span class="font-label-caps text-label-caps text-outline uppercase font-bold tracking-wider">Kartu Anggota Digital</span>
                            <span class="material-symbols-outlined text-secondary text-xl">contactless</span>
                        </div>
                        <div class="p-5 rounded-xl bg-primary text-on-primary flex flex-col justify-between shadow-lg relative overflow-hidden min-h-[160px]">
                            <!-- Decorative Subtle Pattern -->
                            <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full bg-secondary/25 blur-xl pointer-events-none"></div>
                            <div class="flex items-start justify-between relative z-10">
                                <div class="flex flex-col">
                                    <span class="font-label-caps text-label-caps text-inverse-primary tracking-widest uppercase">Perpustakaan SMKN 5</span>
                                    <span class="font-title-sm text-title-sm font-bold mt-0.5">{{ $user->name }}</span>
                                </div>
                                <div class="px-2 py-0.5 rounded bg-surface-container-lowest/15 backdrop-blur-md font-label-caps text-label-caps text-on-primary">
                                    {{ $user->isGuru() ? 'Guru' : 'Siswa' }}
                                </div>
                            </div>
                            <div class="flex items-end justify-between relative z-10 pt-4">
                                <div>
                                    <p class="font-label-caps text-label-caps text-inverse-primary">{{ $user->isGuru() ? 'NIP Guru' : 'NIS Siswa' }}</p>
                                    <p class="font-body-md text-body-md font-mono tracking-wider font-bold">
                                        {{ $user->isGuru() ? ($user->nip ?? '-') : ($user->nis ?? '-') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-label-caps text-label-caps text-inverse-primary">Status</p>
                                    <p class="font-body-sm text-body-sm font-semibold capitalize">{{ $user->status ?? 'Aktif' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-on-surface-variant font-body-sm text-body-sm pt-1">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-base text-secondary">qr_code_2</span>
                                <span>ID Anggota Aktif</span>
                            </span>
                            <span class="text-xs text-outline font-medium">
                                {{ $user->isGuru() ? ($user->subject ?? 'Guru SMKN 5') : ($user->class . ' ' . $user->major) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.member>
@endif
