<x-layouts.admin title="Tambah Buku Baru">
    <div class="flex flex-col w-full h-full pb-16 relative bg-background font-body-md text-on-background">
        <!-- Header -->
        <div class="w-full bg-surface-container-low px-8 pt-8 pb-10 mb-8 rounded-b-3xl shadow-sm">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-on-surface-variant text-body-sm mb-1">
                        <a href="{{ route('admin.books.index') }}" class="hover:text-primary transition-colors">Daftar Buku</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Tambah Baru</span>
                    </div>
                    <h1 class="font-display-lg text-display-lg text-primary m-0 leading-tight">Tambah Buku Baru</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                        Masukkan data detail eksemplar buku ke dalam basis data perpustakaan SMKN 5.
                    </p>
                </div>
                <a href="{{ route('admin.books.index') }}" class="px-4 py-2.5 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold flex items-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="max-w-4xl mx-auto w-full px-4 sm:px-8">
            <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/50 p-6 sm:p-10">
                <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Section: Informasi Utama -->
                    <div>
                        <h2 class="font-title-sm text-title-sm text-primary mb-4 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary">menu_book</span>
                            Informasi Utama Buku
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="title" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Judul Buku <span class="text-error">*</span></label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    value="{{ old('title') }}"
                                    required
                                    placeholder="Contoh: Pemeliharaan Mesin Sepeda Motor"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('title') border-error @enderror"
                                >
                                @error('title')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="author" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Penulis / Pengarang <span class="text-error">*</span></label>
                                <input
                                    type="text"
                                    id="author"
                                    name="author"
                                    value="{{ old('author') }}"
                                    required
                                    placeholder="Contoh: Z. Fahrudin, S.T."
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('author') border-error @enderror"
                                >
                                @error('author')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Kategori <span class="text-error">*</span></label>
                                <select
                                    id="category_id"
                                    name="category_id"
                                    required
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('category_id') border-error @enderror"
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="publisher" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Penerbit <span class="text-error">*</span></label>
                                <input
                                    type="text"
                                    id="publisher"
                                    name="publisher"
                                    value="{{ old('publisher') }}"
                                    required
                                    placeholder="Contoh: Erlangga"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('publisher') border-error @enderror"
                                >
                                @error('publisher')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="publication_year" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Tahun Terbit <span class="text-error">*</span></label>
                                <input
                                    type="number"
                                    id="publication_year"
                                    name="publication_year"
                                    value="{{ old('publication_year', date('Y')) }}"
                                    required
                                    min="1900"
                                    max="{{ date('Y') + 1 }}"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('publication_year') border-error @enderror"
                                >
                                @error('publication_year')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="isbn" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">ISBN</label>
                                <input
                                    type="text"
                                    id="isbn"
                                    name="isbn"
                                    value="{{ old('isbn') }}"
                                    placeholder="Contoh: 978-602-01-2345-6"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('isbn') border-error @enderror"
                                >
                                @error('isbn')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Jumlah Eksemplar (Stok) <span class="text-error">*</span></label>
                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    value="{{ old('stock', 1) }}"
                                    required
                                    min="1"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('stock') border-error @enderror"
                                >
                                <p class="text-xs text-on-surface-variant mt-1">Stok awal yang tersedia otomatis disamakan dengan jumlah eksemplar.</p>
                                @error('stock')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="shelf_location" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Lokasi Rak / Lemari</label>
                                <input
                                    type="text"
                                    id="shelf_location"
                                    name="shelf_location"
                                    value="{{ old('shelf_location') }}"
                                    placeholder="Contoh: Rak TKR-02, Baris 3"
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('shelf_location') border-error @enderror"
                                >
                                @error('shelf_location')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Detail & Sampul -->
                    <div>
                        <h2 class="font-title-sm text-title-sm text-primary mb-4 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary">image</span>
                            Deskripsi & Sampul Buku
                        </h2>

                        <div class="space-y-6">
                            <div>
                                <label for="description" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Sinopsis / Ringkasan Buku</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Tuliskan deskripsi isi buku, cakupan materi, atau target pembaca..."
                                    class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm p-4 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('description') border-error @enderror"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="cover_file" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Unggah File Gambar Sampul</label>
                                    <input
                                        type="file"
                                        id="cover_file"
                                        name="cover_file"
                                        accept="image/*"
                                        class="w-full text-body-sm text-on-surface-variant file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-body-sm file:font-semibold file:bg-surface-container file:text-primary hover:file:bg-surface-container-high cursor-pointer"
                                    >
                                    <p class="text-xs text-on-surface-variant mt-1">Format: JPG, PNG, WEBP (Maksimal 5MB)</p>
                                    @error('cover_file')
                                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cover_image_url" class="block font-title-sm text-body-sm font-semibold text-on-surface mb-2">Atau URL Gambar Sampul Eksternal</label>
                                    <input
                                        type="url"
                                        id="cover_image_url"
                                        name="cover_image_url"
                                        value="{{ old('cover_image_url') }}"
                                        placeholder="https://images.unsplash.com/..."
                                        class="w-full bg-surface-container-lowest text-on-surface font-body-sm text-body-sm px-4 py-3 rounded-xl border border-outline-variant focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary @error('cover_image_url') border-error @enderror"
                                    >
                                    <p class="text-xs text-on-surface-variant mt-1">Gunakan URL jika gambar disimpan di CDN/Cloud</p>
                                    @error('cover_image_url')
                                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="pt-6 border-t border-outline-variant/40 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.books.index') }}" class="px-6 py-3 bg-surface-container hover:bg-surface-container-high rounded-xl text-on-surface-variant font-body-sm text-body-sm font-semibold transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-primary text-on-primary hover:bg-primary/90 rounded-xl font-body-sm text-body-sm font-semibold shadow-md flex items-center gap-2 transition-all">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
