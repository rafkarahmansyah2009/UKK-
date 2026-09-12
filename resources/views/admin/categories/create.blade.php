<x-layouts.admin title="Tambah Kategori Baru">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-10 mb-8 rounded-b-3xl shadow-sm">
            <div class="max-w-2xl mx-auto flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant text-body-sm mb-1">
                        <a href="{{ route('admin.categories.index') }}" class="hover:text-primary transition-colors">Kategori</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Tambah Baru</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 leading-tight">Tambah Kategori Baru</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Buat klasifikasi kategori buku untuk memudahkan pengelompokan inventaris.
                    </p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="max-w-2xl mx-auto w-full px-4 sm:px-8">
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 p-6 sm:p-10">
                <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="code" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Kode Kategori <span class="text-error">*</span></label>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            value="{{ old('code') }}"
                            required
                            placeholder="Contoh: RPL, TKR, FIK, UMUM"
                            class="w-full bg-surface-container-lowest text-on-surface font-mono text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary uppercase @error('code') border-error @enderror"
                        >
                        <p class="text-xs text-on-surface-variant mt-1">Kode unik klasifikasi, maksimal 20 karakter.</p>
                        @error('code')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Nama Kategori <span class="text-error">*</span></label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            placeholder="Contoh: Rekayasa Perangkat Lunak"
                            class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('name') border-error @enderror"
                        >
                        @error('name')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Deskripsi / Keterangan</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Penjelasan cakupan materi atau buku dalam kategori ini..."
                            class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm p-4 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('description') border-error @enderror"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-error text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="pt-6 border-t border-outline-variant/40 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold shadow-md flex items-center gap-2 transition-all">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
