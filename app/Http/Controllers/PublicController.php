<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Display the public landing page.
     */
    public function home(): View
    {
        $featuredBooks = Book::with('category')
            ->orderBy('publication_year', 'desc')
            ->take(6)
            ->get();

        $categories = Category::withCount('books')->get();

        $stats = [
            'total_books' => Book::sum('stock'),
            'total_titles' => Book::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_categories' => Category::count(),
        ];

        return view('welcome', compact('featuredBooks', 'categories', 'stats'));
    }

    /**
     * Display the public book catalog.
     */
    public function katalog(Request $request): View
    {
        $query = Book::with('category');

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('author', 'like', "%{$searchTerm}%")
                    ->orWhere('isbn', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('category_id', $request->input('kategori'));
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('books')->get();

        return view('public.katalog', compact('books', 'categories'));
    }

    /**
     * Display the public announcements list.
     */
    public function pengumuman(Request $request): View
    {
        $allAnnouncements = $this->getStaticAnnouncements();
        $categories = $allAnnouncements->pluck('category')->unique()->values();

        $filtered = $allAnnouncements;

        // Search query
        if ($request->filled('q')) {
            $rawTerm = trim((string) $request->input('q'));
            $searchTerm = mb_strtolower($rawTerm);
            $keywords = array_values(array_filter(explode(' ', $searchTerm)));

            $filtered = $filtered->filter(function (array $item) use ($searchTerm, $keywords): bool {
                $searchable = mb_strtolower(
                    $item['title'].' '.
                    $item['excerpt'].' '.
                    strip_tags($item['content']).' '.
                    $item['category'].' '.
                    $item['author']
                );

                // Exact phrase match
                if (str_contains($searchable, $searchTerm)) {
                    return true;
                }

                // Match all words (AND logic)
                foreach ($keywords as $keyword) {
                    if (! str_contains($searchable, $keyword)) {
                        return false;
                    }
                }

                return true;
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $categoryFilter = trim((string) $request->input('kategori'));
            $filtered = $filtered->filter(function (array $item) use ($categoryFilter): bool {
                return $item['category'] === $categoryFilter;
            });
        }

        // Pagination
        $page = max((int) $request->input('page', 1), 1);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;

        $announcements = new LengthAwarePaginator(
            $filtered->slice($offset, $perPage)->values(),
            $filtered->count(),
            $perPage,
            $page,
            [
                'path' => route('pengumuman'),
                'query' => $request->query(),
            ]
        );

        $categoryCounts = $allAnnouncements->groupBy('category')->map->count();

        return view('public.pengumuman.index', compact('announcements', 'categories', 'categoryCounts'));
    }

    /**
     * Display a specific announcement detail.
     */
    public function pengumumanDetail(string $slug): View
    {
        $allAnnouncements = $this->getStaticAnnouncements();
        $announcement = $allAnnouncements->firstWhere('slug', $slug);

        if (! $announcement) {
            abort(404);
        }

        $relatedAnnouncements = $allAnnouncements
            ->where('id', '!=', $announcement['id'])
            ->take(3)
            ->values();

        return view('public.pengumuman.show', compact('announcement', 'relatedAnnouncements'));
    }

    /**
     * Display the library info page.
     */
    public function tentang(): View
    {
        return view('public.tentang');
    }

    /**
     * Get static announcements data.
     *
     * @return Collection<int, array<string, mixed>>
     */
    private function getStaticAnnouncements(): Collection
    {
        return collect([
            [
                'id' => 1,
                'slug' => 'jadwal-operasional-pas-ganjil-2026',
                'title' => 'Penyesuaian Jam Operasional Perpustakaan Selama Penilaian Akhir Semester (PAS) Ganjil',
                'category' => 'Layanan & Operasional',
                'icon' => 'schedule',
                'published_at' => '14 Oktober 2026',
                'author' => 'Pengelola Perpustakaan SMKN 5',
                'read_time' => '3 mnt baca',
                'excerpt' => 'Sehubungan dengan pelaksanaan Penilaian Akhir Semester (PAS) Ganjil Tahun Ajaran 2026/2027, jam operasional ruang baca dan layanan sirkulasi perpustakaan mengalami penyesuaian khusus demi mendukung ketenangan belajar.',
                'content' => '<p>Diberitahukan kepada seluruh peserta didik, bapak/ibu guru, dan tenaga kependidikan SMKN 5 bahwa dalam rangka mendukung kelancaran pelaksanaan <strong>Penilaian Akhir Semester (PAS) Ganjil Tahun Ajaran 2026/2027</strong>, Perpustakaan SMKN 5 melakukan penyesuaian jam layanan operasional dan fasilitas ruang baca mandiri.</p>
                <p>Penyesuaian jadwal ini berlaku mulai tanggal <strong>20 Oktober 2026 hingga 01 November 2026</strong> dengan rincian jadwal sebagai berikut:</p>
                <ul>
                    <li><strong>Senin – Kamis:</strong> Pukul 07.00 – 16.30 WIB (Layanan Sirkulasi & Ruang Belajar Mandiri)</li>
                    <li><strong>Jumat:</strong> Pukul 07.00 – 11.30 WIB dan 13.00 – 16.00 WIB</li>
                    <li><strong>Sabtu & Minggu:</strong> Layanan Tatap Muka Tutup (Layanan Digital E-Library tetap dapat diakses 24 jam)</li>
                </ul>
                <p>Selama periode PAS, kapasitas meja baca mandiri ditingkatkan sebanyak 40 kursi tambahan dan koneksi internet Wi-Fi difokuskan untuk akses materi referensi serta platform ujian daring sekolah. Siswa dihimbau untuk tetap menjaga ketertiban, ketenangan, serta tidak membawa makanan berat ke dalam ruang koleksi utama.</p>',
                'key_points' => [
                    'Perubahan jam buka mulai 07.00 hingga 16.30 WIB selama periode PAS.',
                    'Penambahan 40 kuota meja belajar mandiri dan prioritas bandwidth Wi-Fi edukasi.',
                    'Layanan pengembalian buku tetap dibuka di meja sirkulasi utama atau drop-box depan perpustakaan.',
                ],
                'important_note' => 'Bagi siswa yang membutuhkan modul latihan atau buku paket pelajaran kejuruan dapat langsung menghubungi petugas sirkulasi dengan menunjukkan kartu pelajar.',
            ],
            [
                'id' => 2,
                'slug' => 'koleksi-buku-baru-kejuruan-2026',
                'title' => 'Telah Tersedia: 200+ Eksemplar Koleksi Buku Baru Jurusan RPL, TKJ, dan DKV',
                'category' => 'Koleksi & Referensi',
                'icon' => 'menu_book',
                'published_at' => '10 Oktober 2026',
                'author' => 'Divisi Pengadaan Bahan Pustaka',
                'read_time' => '4 mnt baca',
                'excerpt' => 'Perpustakaan SMKN 5 menambah lebih dari 200 buku referensi terkini seputar Cloud Computing, Artificial Intelligence, Laravel 11, UI/UX Design System, hingga Animasi 3D Blender.',
                'content' => '<p>Kabar gembira untuk seluruh civitas akademika SMKN 5! Guna memperkuat kurikulum vokasi berbasis industri terkini, Perpustakaan SMKN 5 telah mendatangkan dan mengolah <strong>lebih dari 200 eksemplar buku referensi kejuruan edisi terbaru 2026</strong>.</p>
                <p>Buku-buku baru ini telah melalui proses katalogisasi dan klasifikasi DDC (Dewey Decimal Classification), siap dipinjam maupun dibaca langsung di ruang referensi khusus lantai 2. Beberapa topik unggulan meliputi:</p>
                <ul>
                    <li><strong>Rekayasa Perangkat Lunak (RPL):</strong> Fullstack Modern Web Development dengan Laravel 11 & Tailwind CSS, Fundamental Machine Learning dengan Python, serta Arsitektur Microservices.</li>
                    <li><strong>Teknik Komputer & Jaringan (TKJ):</strong> Konfigurasi Keamanan Jaringan MikroTik RouterOS v7, Cloud Architecture AWS/GCP, dan Implementasi Cyber Security Vokasi.</li>
                    <li><strong>Desain Komunikasi Visual (DKV):</strong> Prinsip UI/UX Design System Berstandar Industri, 3D Character Modeling Blender, serta Storyboarding & Visual Storytelling.</li>
                    <li><strong>Koleksi Literasi Umum:</strong> Buku pengembangan diri, motivasi wirausaha muda, dan novel fiksi sains peraih penghargaan nasional.</li>
                </ul>
                <p>Siswa dapat langsung mencari ketersediaan nomor panggil (call number) melalui menu <em>Katalog Buku</em> pada sistem ini sebelum datang ke meja peminjaman.</p>',
                'key_points' => [
                    'Tersedia lebih dari 200 eksemplar buku teknis terbitan terbaru tahun 2025–2026.',
                    'Fasilitas peminjaman maksimal 2 buku per siswa dengan durasi 7 hari kalender.',
                    'Nomor panggil dan status ketersediaan dapat dicek langsung melalui fitur Katalog Perpustakaan.',
                ],
                'important_note' => 'Koleksi bertanda stiker kuning merupakan koleksi referensi khusus ruang baca yang hanya boleh dibaca di tempat atau difotokopi bab tertentu.',
            ],
            [
                'id' => 3,
                'slug' => 'pekan-literasi-dan-bedah-buku-vokasi-2026',
                'title' => 'Pekan Literasi Vokasi SMKN 5: Workshop Bedah Buku & Penulisan Portofolio Ilmiah',
                'category' => 'Kegiatan & Literasi',
                'icon' => 'campaign',
                'published_at' => '05 Oktober 2026',
                'author' => 'Tim Literasi Sekolah & OSIS',
                'read_time' => '5 mnt baca',
                'excerpt' => 'Ikuti rangkaian seminar literasi vokasi yang menghadirkan praktisi industri kreatif, sesi bedah buku teknologi masa depan, serta coaching clinic pembuatan portofolio siswa.',
                'content' => '<p>Dalam upaya menumbuhkan budaya riset, membaca aktif, dan kecakapan dokumentasi teknis di lingkungan sekolah kejuruan, Tim Penggerak Literasi bekerjasama dengan Perpustakaan SMKN 5 menyelenggarakan <strong>Pekan Literasi Vokasi 2026</strong> bertema <em>"Menulis Masa Depan, Membangun Kompetensi Global"</em>.</p>
                <p>Acara ini terbuka bagi seluruh siswa kelas X, XI, XII dan para guru pendamping dengan agenda utama:</p>
                <ul>
                    <li><strong>Hari 1:</strong> Bedah Buku <em>"Ekosistem Startup & Karier Digital Era AI"</em> bersama guest speaker alumni sukses SMKN 5.</li>
                    <li><strong>Hari 2:</strong> Masterclass Teknik Penulisan Portofolio Praktik Kerja Lapangan (PKL) dan Laporan Ilmiah Berbobot Industri.</li>
                    <li><strong>Hari 3:</strong> Pameran Karya Resensi Buku Siswa, Penobatan Duta Baca, serta Bazar Buku Terbitan Edukasi.</li>
                </ul>
                <p>Seluruh peserta yang mengikuti rangkaian kegiatan hingga selesai akan mendapatkan sertifikat resmi literasi sekolah berbobot jam kegiatan ekstrakurikuler serta cinderamata eksklusif perpustakaan.</p>',
                'key_points' => [
                    'Waktu pelaksanaan: 25 – 27 Oktober 2026, bertempat di Aula Graha Widya SMKN 5.',
                    'Pendaftaran gratis untuk seluruh siswa SMKN 5 melalui wali kelas atau pustakawan piket.',
                    'Disediakan total doorprize buku referensi senilai Rp 3.500.000,- bagi peserta teraktif.',
                ],
                'important_note' => 'Kuota peserta luring di aula dibatasi 150 kursi, siaran langsung tersedia di kanal YouTube resmi SMKN 5.',
            ],
            [
                'id' => 4,
                'slug' => 'prosedur-surat-bebas-pustaka-kelas-xii',
                'title' => 'Panduan Pengurusan Surat Keterangan Bebas Perpustakaan (SKBP) Siswa Kelas XII',
                'category' => 'Layanan & Operasional',
                'icon' => 'assignment_turned_in',
                'published_at' => '28 September 2026',
                'author' => 'Bagian Sirkulasi & Administrasi',
                'read_time' => '3 mnt baca',
                'excerpt' => 'Informasi penting bagi calon lulusan mengenai alur pengembalian pinjaman buku, penyelesaian administrasi denda, dan verifikasi Surat Bebas Pustaka sebagai syarat administrasi.',
                'content' => '<p>Diberitahukan kepada seluruh siswa kelas XII calon peserta asesmen kelulusan tahun ajaran 2026/2027 bahwa proses verifikasi <strong>Surat Keterangan Bebas Perpustakaan (SKBP)</strong> telah mulai dibuka. Surat ini merupakan salah satu syarat wajib pengambilan ijazah dan transkrip nilai.</p>
                <p>Berikut alur dan tahapan pengurusan yang harus diperhatikan:</p>
                <ul>
                    <li><strong>Cek Status Peminjaman:</strong> Pastikan Anda telah mengembalikan seluruh buku teks wajib, buku pengayaan kejuruan, maupun novel pinjaman melalui akun member masing-masing.</li>
                    <li><strong>Penyelesaian Denda (Jika Ada):</strong> Jika terdapat catatan keterlambatan pengembalian atau kerusakan buku, selesaikan administrasi di loket sirkulasi perpustakaan.</li>
                    <li><strong>Validasi Petugas:</strong> Tunjukkan Kartu Tanda Pelajar atau scan Kartu Digital Anda kepada staf perpustakaan untuk pengecekan rekam data sistem.</li>
                    <li><strong>Pencetakan Surat:</strong> Petugas akan mengesahkan bukti bebas pustaka digital dan memberikan salinan fisik berstempel resmi perpustakaan.</li>
                </ul>
                <p>Pengurusan bebas perpustakaan dilayani setiap hari kerja pukul 08.00 – 14.30 WIB di Ruang Tata Usaha Perpustakaan SMKN 5.</p>',
                'key_points' => [
                    'SKBP wajib dimiliki seluruh siswa kelas XII sebelum pelaksanaan uji kompetensi keahlian.',
                    'Pengecekan tanggungan buku dapat dilihat secara real-time di halaman Dashboard Member.',
                    'Batas akhir penyerahan berkas bebas pustaka adalah tanggal 30 November 2026.',
                ],
                'important_note' => 'Buku yang hilang atau rusak wajib diganti dengan judul dan edisi yang sama atau buku relevan yang disetujui pustakawan.',
            ],
            [
                'id' => 5,
                'slug' => 'peluncuran-kartu-anggota-digital-barcode',
                'title' => 'Modernisasi Fasilitas: Peluncuran Kartu Anggota Digital Berbasis Barcode & QR Code',
                'category' => 'Fasilitas & Sistem',
                'icon' => 'badge',
                'published_at' => '20 September 2026',
                'author' => 'Tim IT Perpustakaan SMKN 5',
                'read_time' => '3 mnt baca',
                'excerpt' => 'Kini seluruh siswa dan dewan guru dapat memanfaatkan kartu anggota digital yang dapat diakses langsung melalui smartphone untuk presensi kunjungan dan peminjaman kilat.',
                'content' => '<p>Sebagai wujud transformasi digital dan efisiensi ramah lingkungan (paperless school), Perpustakaan SMKN 5 secara resmi meluncurkan fasilitas <strong>Kartu Anggota Digital Terintegrasi</strong>.</p>
                <p>Kartu digital ini tersemat langsung pada akun profil setiap member yang terdaftar di sistem web Library SMKN 5. Fitur utama kartu mencakup:</p>
                <ul>
                    <li><strong>Barcode Cepat Sirkulasi:</strong> Mempercepat proses peminjaman buku di meja layanan hanya dalam hitungan detik.</li>
                    <li><strong>QR Code Presensi Mandiri:</strong> Cukup arahkan layar ponsel ke scanner pintu masuk perpustakaan untuk mencatatkan kunjungan harian.</li>
                    <li><strong>Riwayat Peminjaman Aktif:</strong> Memantau sisa hari pinjam buku secara real-time langsung di bawah kartu anggota.</li>
                </ul>
                <p>Untuk mengakses kartu digital Anda, silakan login ke sistem web Library SMKN 5, pilih menu <em>Dashboard Member</em>, lalu pilih tab <em>Kartu Anggota</em>. Kartu juga dapat disimpan ke galeri ponsel dalam format gambar beresolusi tinggi.</p>',
                'key_points' => [
                    'Tidak perlu khawatir kartu fisik tertinggal atau hilang.',
                    'Dapat disimpan offline pada ponsel cerdas siswa dan guru.',
                    'Mendukung transaksi peminjaman cepat di loket mandiri dan loket petugas.',
                ],
                'important_note' => 'Jika data NISN atau kelas pada kartu anggota digital Anda belum sesuai, harap lakukan pembaruan data di profil atau hubungi admin perpustakaan.',
            ],
            [
                'id' => 6,
                'slug' => 'lomba-duta-baca-dan-resensi-buku-smkn5',
                'title' => 'Pendaftaran Pemilihan Duta Baca & Lomba Resensi Buku SMKN 5 Resmi Dibuka',
                'category' => 'Kegiatan & Literasi',
                'icon' => 'emoji_events',
                'published_at' => '12 September 2026',
                'author' => 'Kelompok Kerja Perpustakaan Sekolah',
                'read_time' => '4 mnt baca',
                'excerpt' => 'Ajang bergengsi pencarian figur inspirator literasi SMKN 5 dengan total hadiah jutaan rupiah, beasiswa pembinaan, dan kesempatan menjadi duta literasi tingkat kota.',
                'content' => '<p>Apakah kamu siswa yang memiliki ketertarikan tinggi pada dunia buku, gemar berbagi pengetahuan, dan berani tampil di depan publik? Inilah saatnya unjuk kemampuan dalam ajang <strong>Pemilihan Duta Baca SMKN 5 & Festival Resensi Karya Siswa Tahun 2026</strong>.</p>
                <p>Kompetisi tahunan ini bertujuan melahirkan figur teladan yang mampu menginspirasi rekan sebaya untuk gemar membaca serta memanfaatkan perpustakaan sekolah secara optimal. Tahapan kompetisi meliputi:</p>
                <ul>
                    <li><strong>Tahap 1 (Pemberkasan & Esai):</strong> Mengirimkan resume buku favorit yang ada di perpustakaan sekolah beserta gagasan program kampanye literasi kreatif.</li>
                    <li><strong>Tahap 2 (Wawancara & Uji Wawasan):</strong> Penilaian pemahaman literasi informasi, etika digital, dan wawasan kejuruan oleh dewan juri ahli.</li>
                    <li><strong>Tahap 3 (Grand Final):</strong> Pidato orasi literasi dan sesi tanya-jawab terbuka di hadapan dewan juri serta perwakilan siswa.</li>
                </ul>
                <p>Pemenang akan mendapatkan Trofi Bergilir Kepala Sekolah, Piagam Penghargaan Resmi Dinas Pendidikan, Tabungan Pendidikan, serta disematkan sebagai Duta Baca SMKN 5 selama 1 tahun masa bakti.</p>',
                'key_points' => [
                    'Terbuka untuk seluruh siswa kelas X dan XI seluruh program keahlian.',
                    'Batas akhir pendaftaran dan pengumpulan esai: 30 Oktober 2026.',
                    'Formulir pendaftaran dapat diambil di meja informasi perpustakaan atau diunduh di dashboard.',
                ],
                'important_note' => 'Resensi yang diikutkan lomba harus mengulas buku yang terdaftar di Katalog Perpustakaan SMKN 5.',
            ],
            [
                'id' => 7,
                'slug' => 'pelatihan-penelusuran-e-journal-nasional',
                'title' => 'Bimtek Penelusuran E-Resources & Jurnal Ilmiah Nasional untuk Laporan PKL',
                'category' => 'Koleksi & Referensi',
                'icon' => 'auto_stories',
                'published_at' => '02 September 2026',
                'author' => 'Pustakawan SMKN 5',
                'read_time' => '3 mnt baca',
                'excerpt' => 'Kuasai teknik mencari referensi jurnal terakreditasi SINTA dan repositori nasional untuk mendukung pembuatan laporan Praktik Kerja Lapangan (PKL) yang berkualitas dan bebas plagiarisme.',
                'content' => '<p>Menyikapi kebutuhan literatur ilmiah bagi siswa yang sedang maupun akan melaksanakan Praktik Kerja Lapangan (PKL), Perpustakaan SMKN 5 menggelar sesi bimbingan teknis <strong>Pemanfaatan E-Resources Perpustakaan Nasional dan Portal Garuda / SINTA</strong>.</p>
                <p>Dalam pelatihan ini, peserta akan dibimbing langkah demi langkah mengenai:</p>
                <ul>
                    <li>Registrasi dan verifikasi keanggotaan online Perpustakaan Nasional RI (PNRI) gratis.</li>
                    <li>Teknik pencarian kata kunci boolean (AND, OR, NOT) untuk menemukan riset teknologi yang tepat sasaran.</li>
                    <li>Etika sitasi dan pengutipan ilmiah guna menghindari plagiarisme pada bab tinjauan pustaka laporan PKL.</li>
                    <li>Penggunaan aplikasi manajer referensi sederhana untuk pembuatan daftar pustaka otomatis.</li>
                </ul>
                <p>Pelatihan diselenggarakan setiap hari Rabu sore di Laboratorium Komputer Perpustakaan dengan durasi 90 menit per kelompok belajar.</p>',
                'key_points' => [
                    'Dikhususkan bagi siswa tingkat XI dan XII yang sedang mempersiapkan laporan PKL.',
                    'Materi panduan format PDF dan video rekaman dibagikan gratis kepada seluruh peserta.',
                    'Disediakan sesi konsultasi privat dengan pustakawan untuk telaah sumber pustaka.',
                ],
                'important_note' => 'Peserta diwajibkan membawa draf topik laporan PKL atau proposal proyek yang sedang dikerjakan.',
            ],
        ]);
    }
}
