<x-layouts.admin title="Transaksi Peminjaman Baru">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-10 mb-8 rounded-b-3xl shadow-sm">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant text-body-sm mb-1">
                        <a href="{{ route('admin.borrowings.index') }}" class="hover:text-primary transition-colors">Peminjaman</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Transaksi Baru</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 leading-tight">Transaksi Peminjaman Baru</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Catat sirkulasi peminjaman buku untuk siswa atau guru yang aktif terdaftar.
                    </p>
                </div>
                <a href="{{ route('admin.borrowings.index') }}" class="px-4 py-2.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="max-w-4xl mx-auto w-full px-4 sm:px-8">
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 p-6 sm:p-10" x-data="{
                borrowDate: '{{ old('borrow_date', date('Y-m-d')) }}',
                durationDays: {{ old('duration_days', 7) }},
                get dueDate() {
                    if (!this.borrowDate) return '';
                    let d = new Date(this.borrowDate);
                    d.setDate(d.getDate() + parseInt(this.durationDays));
                    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                }
            }">
                <form method="POST" action="{{ route('admin.borrowings.store') }}" class="space-y-8">
                    @csrf

                    <!-- 1. Peminjam & Buku -->
                    <div>
                        <h2 class="font-title-sm text-title-sm text-primary mb-4 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary">person_search</span>
                            Identitas Peminjam & Buku
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="user_id" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Pilih Anggota Peminjam <span class="text-error">*</span></label>
                                <select
                                    id="user_id"
                                    name="user_id"
                                    required
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('user_id') border-error @enderror"
                                >
                                    <option value="">-- Pilih Anggota Aktif --</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}" {{ (old('user_id') == $member->id || request('user_id') == $member->id) ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->isSiswa() ? 'Siswa - NIS: ' . $member->nis : 'Guru - NIP: ' . $member->nip }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="book_id" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Pilih Judul Buku <span class="text-error">*</span></label>
                                <select
                                    id="book_id"
                                    name="book_id"
                                    required
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('book_id') border-error @enderror"
                                >
                                    <option value="">-- Pilih Buku Tersedia --</option>
                                    @foreach ($books as $b)
                                        <option value="{{ $b->id }}" {{ (old('book_id') == $b->id || request('book_id') == $b->id) ? 'selected' : '' }}>
                                            {{ $b->title }} (Sisa Stok: {{ $b->available_stock }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 2. Waktu Peminjaman & Durasi -->
                    <div>
                        <h2 class="font-title-sm text-title-sm text-primary mb-4 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary">calendar_today</span>
                            Waktu & Durasi Peminjaman
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="borrow_date" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Tanggal Mulai Pinjam <span class="text-error">*</span></label>
                                <input
                                    type="date"
                                    id="borrow_date"
                                    name="borrow_date"
                                    x-model="borrowDate"
                                    required
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('borrow_date') border-error @enderror"
                                >
                                @error('borrow_date')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Durasi Peminjaman <span class="text-error">*</span></label>
                                <div class="grid grid-cols-4 gap-2">
                                    <template x-for="d in [3, 7, 14, 30]">
                                        <label class="cursor-pointer border text-center py-3 rounded-xl font-semibold text-body-sm transition-all" :class="durationDays == d ? 'border-secondary bg-secondary-container/15 text-secondary' : 'border-outline-variant text-on-surface-variant hover:border-outline'">
                                            <input type="radio" name="duration_days" :value="d" x-model="durationDays" class="hidden">
                                            <span x-text="d + ' Hari'"></span>
                                        </label>
                                    </template>
                                </div>
                                @error('duration_days')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Catatan Transaksi (Opsional)</label>
                                <input
                                    type="text"
                                    id="notes"
                                    name="notes"
                                    value="{{ old('notes') }}"
                                    placeholder="Contoh: Dipinjam untuk praktikum kelompok di lab..."
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- 3. Summary & Info Banner -->
                    <div class="p-5 bg-surface-container-low rounded-2xl border border-outline-variant/40 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">event_upcoming</span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-on-surface-variant uppercase">Estimasi Jatuh Tempo Pengembalian</p>
                                <p class="text-lg font-bold text-primary mt-0.5" x-text="dueDate || '-'"></p>
                            </div>
                        </div>
                        <div class="text-xs text-on-surface-variant sm:text-right">
                            <p class="font-semibold text-on-surface">Ketentuan Perpustakaan SMKN 5:</p>
                            <p>Denda keterlambatan Rp 1.000 / hari jika melewati batas tempo.</p>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="pt-6 border-t border-outline-variant/40 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.borrowings.index') }}" class="px-6 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold shadow-md flex items-center gap-2 transition-all">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Simpan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
