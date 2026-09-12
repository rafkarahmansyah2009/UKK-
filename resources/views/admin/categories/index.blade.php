<x-layouts.admin title="Kategori Buku">
    <div class="flex flex-col w-full p-8 space-y-6 max-w-container-max mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-body-sm text-on-surface-variant mb-1">
                    <span>Manajemen Koleksi</span>
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    <span class="text-primary font-semibold">Kategori</span>
                </nav>
                <h1 class="font-display-lg text-display-lg text-on-surface font-bold">Kategori Buku</h1>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-container hover:bg-primary-container/90 text-on-primary rounded-xl font-title-sm text-title-sm font-semibold shadow-md transition-colors">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Kategori
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/40 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant/30">
                            <th class="font-label-caps text-label-caps text-on-surface-variant py-3.5 px-6 uppercase font-bold">Kode</th>
                            <th class="font-label-caps text-label-caps text-on-surface-variant py-3.5 px-6 uppercase font-bold">Nama Kategori</th>
                            <th class="font-label-caps text-label-caps text-on-surface-variant py-3.5 px-6 uppercase font-bold">Deskripsi</th>
                            <th class="font-label-caps text-label-caps text-on-surface-variant py-3.5 px-6 uppercase font-bold text-center">Jumlah Buku</th>
                            <th class="font-label-caps text-label-caps text-on-surface-variant py-3.5 px-6 uppercase font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="font-body-sm text-body-sm divide-y divide-outline-variant/20">
                        @forelse ($categories as $cat)
                            <tr class="hover:bg-surface-container-low/40 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 bg-secondary-container/15 text-secondary font-mono font-bold text-xs rounded-md">
                                        {{ $cat->code }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-semibold text-on-surface">
                                    {{ $cat->name }}
                                </td>
                                <td class="py-4 px-6 text-on-surface-variant max-w-xs truncate">
                                    {{ $cat->description ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-center font-bold text-primary">
                                    {{ $cat->books_count }}
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.categories.edit', $cat) }}" class="p-1.5 text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors" title="Edit Kategori">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-on-surface-variant hover:text-error rounded-lg hover:bg-error-container/20 transition-colors" title="Hapus Kategori">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-on-surface-variant">Belum ada data kategori buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="p-4 border-t border-outline-variant/30">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
