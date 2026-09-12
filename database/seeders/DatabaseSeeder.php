<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@smkn5.sch.id'],
            [
                'name' => 'Administrator Perpustakaan',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'status' => 'active',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCtm_u3lB6IQEkySkKODBLovGXGMqERI9HrEL6DLkVOQF2JRMIl3N8Zp7MgAr8xlhhoC4B9CAlCMFfQcVSdoHe6NJS-ICGui9xvBBpm6s0g3PcXG-gLSzGdWM2hHzwwFsdBlU5lMS6HXF0m1df4XK5qPf903c14GshWR7p_5CEJ3IRf2Zs9VoNhq7d1vn4A-Uvfh_Msblw5zbNjEue6xsvO8d1EvM_fT12sIw_Mn7MKFD70HKpMzXlI',
            ]
        );

        $siswa1 = User::firstOrCreate(
            ['email' => 'fikri@siswa.smkn5.sch.id'],
            [
                'name' => 'Ahmad Fikri',
                'username' => 'ahmadfikri',
                'password' => Hash::make('password'),
                'role' => 'member',
                'member_type' => 'siswa',
                'nis' => '20231001',
                'class' => 'XI TKJ 1',
                'major' => 'TKJ',
                'phone' => '082111223344',
                'status' => 'active',
            ]
        );

        $siswa2 = User::firstOrCreate(
            ['email' => 'siti@siswa.smkn5.sch.id'],
            [
                'name' => 'Siti Nurhaliza',
                'username' => 'sitinur',
                'password' => Hash::make('password'),
                'role' => 'member',
                'member_type' => 'siswa',
                'nis' => '20231002',
                'class' => 'X AKL 2',
                'major' => 'AKL',
                'phone' => '083111223344',
                'status' => 'active',
            ]
        );

        $siswa3 = User::firstOrCreate(
            ['email' => 'budi@siswa.smkn5.sch.id'],
            [
                'name' => 'Budi Santoso',
                'username' => 'budisantoso',
                'password' => Hash::make('password'),
                'role' => 'member',
                'member_type' => 'siswa',
                'nis' => '20231003',
                'class' => 'XII TSM',
                'major' => 'TSM',
                'phone' => '084111223344',
                'status' => 'active',
            ]
        );

        $siswa4Inactive = User::firstOrCreate(
            ['email' => 'rina@siswa.smkn5.sch.id'],
            [
                'name' => 'Rina Melati',
                'username' => 'rinamelati',
                'password' => Hash::make('password'),
                'role' => 'member',
                'member_type' => 'siswa',
                'nis' => '20231004',
                'class' => 'XI RPL',
                'major' => 'RPL',
                'phone' => '085111223344',
                'status' => 'inactive',
            ]
        );

        $guru1 = User::firstOrCreate(
            ['email' => 'hendro@guru.smkn5.sch.id'],
            [
                'name' => 'Drs. Hendro Wibowo, M.Kom',
                'username' => 'hendrowibowo',
                'password' => Hash::make('password'),
                'role' => 'member',
                'member_type' => 'guru',
                'nip' => '197805122003121002',
                'subject' => 'Pemrograman Web & Perangkat Bergerak',
                'phone' => '081399887766',
                'status' => 'active',
            ]
        );

        // 2. Categories
        $catRpl = Category::firstOrCreate(
            ['code' => 'RPL'],
            ['name' => 'Rekayasa Perangkat Lunak', 'description' => 'Koleksi buku pemrograman, rekayasa software, database, dan web development.']
        );

        $catTkj = Category::firstOrCreate(
            ['code' => 'TKJ'],
            ['name' => 'Teknik Komputer & Jaringan', 'description' => 'Buku seputar infrastruktur jaringan, routing switching, dan keamanan siber.']
        );

        $catTkr = Category::firstOrCreate(
            ['code' => 'TKR'],
            ['name' => 'Teknik Kendaraan Ringan', 'description' => 'Buku mekanik otomotif, mesin sepeda motor, dan teknologi kendaraan modern.']
        );

        $catFiksi = Category::firstOrCreate(
            ['code' => 'FK'],
            ['name' => 'Fiksi & Sastra', 'description' => 'Novel, karya sastra klasik, antologi puisi, dan cerita inspiratif.']
        );

        $catBisnis = Category::firstOrCreate(
            ['code' => 'BM'],
            ['name' => 'Bisnis & Kewirausahaan', 'description' => 'Buku manajemen, akuntansi, kewirausahaan, dan ekonomi kreatif.']
        );

        $catSains = Category::firstOrCreate(
            ['code' => 'SN'],
            ['name' => 'Sains & Matematika', 'description' => 'Koleksi ilmu pengetahuan terapan, fisika, kimia, dan matematika teknik.']
        );

        // 3. Books
        $booksData = [
            [
                'category_id' => $catFiksi->id,
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'publication_year' => 2018,
                'isbn' => '978-979-97312-3-4',
                'stock' => 10,
                'available_stock' => 9,
                'shelf_location' => 'Rak A-01',
                'description' => 'Karya sastra legendaris menceritakan perjalanan Minke di masa kolonial Hindia Belanda.',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA83tMe2BKjTj_WeQeO2idfOOB9-8mrE1pAMKmNKDMu24pUVnHx-lf67o25xIE99_b3Nll6YnuCe6Or74tkh9OCDBb9xjBYv5DbSsDCXap0Of0VRSPjKAovEkoZnHxNisnNngs2qbXZvA9bpuvyHpE6ABtZZ-KVivjFNMzXyzg882LzDovUylmuB7m4xoQbP0tvHXl7obr7G9GsPCKuhcvC3KQzDSraXXL0gKFwZUrsYhS32kC0YW1g',
            ],
            [
                'category_id' => $catRpl->id,
                'title' => 'Dasar Pemrograman Web',
                'author' => 'Budi Raharjo',
                'publisher' => 'Informatika Bandung',
                'publication_year' => 2022,
                'isbn' => '978-602-6232-15-2',
                'stock' => 15,
                'available_stock' => 14,
                'shelf_location' => 'Rak B-03',
                'description' => 'Panduan komprehensif HTML, CSS, JavaScript, dan fondasi backend modern.',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBT1apfy9LYgRPbBsjXjUN_VL8X_j_WAc7VrdskMIix64H3K501XLtUefoo7dLB11ZW5YPPCntoHGUa-NVltXx_PvmG8A5gLKuthYnUNmM6Fcm-ptcijkSR38IfAC_VVD761pmkynDDeQ_VUqphdk9ejp4bb8zBeThavCi3lxOyJnT4if7qRgE9mgAnA0rA95yWw8cNK3fOMvXYot-7qrSaZFrRgLtrWXKumRkMVjq-qMU4eKjfscBC',
            ],
            [
                'category_id' => $catBisnis->id,
                'title' => 'Kewirausahaan SMK',
                'author' => 'Suryana',
                'publisher' => 'Salemba Empat',
                'publication_year' => 2021,
                'isbn' => '978-979-061-820-1',
                'stock' => 8,
                'available_stock' => 8,
                'shelf_location' => 'Rak C-02',
                'description' => 'Menanamkan jiwa inovasi bisnis dan kemandirian usaha untuk lulusan sekolah kejuruan.',
                'cover_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuABWoDIFCufIrFgf7ScbJqxTU9f-bRlBSszA-oeOSSa0BNyKcE_JMLg3yznzWkW8APjGZBWZcFGzrVcksW99SwXdhFZ8237mjb6-vyVYpZwOvgre9gbTjJUk_B-OctNyKBYLsidWOlHg_8imW05TFhy8mNQcAltJSmpkwXAWdXB-DOANLVmJcIZ-b4kjqPJmO2NGSV1XFCpzKuYDANvwRomgLxzELHHI4is-ttxpHkGwo9CDyB7TSV9',
            ],
            [
                'category_id' => $catTkj->id,
                'title' => 'Administrasi Infrastruktur Jaringan',
                'author' => 'Noval Kusuma',
                'publisher' => 'Andi Publisher',
                'publication_year' => 2023,
                'isbn' => '978-979-29-7100-3',
                'stock' => 12,
                'available_stock' => 11,
                'shelf_location' => 'Rak D-05',
                'description' => 'Konfigurasi VLAN, routing OSPF, BGP, firewall, dan manajemen bandwidth Mikrotik & Cisco.',
                'cover_image' => 'https://lh3.googleusercontent.com/aida/AEtjO1W0ocidYHZMWDJlYnp5yQ_bW7RJqBL9Ua2W5N6tKAWYLm5IGWSj5I09qxyLhlEWdTpEC6kaYYVK8vzNYT2VUX7z1Bcn6hjx9Xnqa2Pouc15uIoGN_R45r1OzJ9T8TeR04c6rfffI9WG0JEx9vWVw8WPfWWgkDWsvGBJf558C8gI_umNo5hdFGEoPA6QKDUSvXtcY0NjPsVpBy5JGN2ZMhb9XVwsfxXKL2qXRNjH2izC9XJluG2K1yiOSaM',
            ],
            [
                'category_id' => $catBisnis->id,
                'title' => 'Pengantar Akuntansi',
                'author' => 'Hery, S.E., M.Si.',
                'publisher' => 'Grasindo',
                'publication_year' => 2020,
                'isbn' => '978-602-052-110-5',
                'stock' => 6,
                'available_stock' => 5,
                'shelf_location' => 'Rak C-04',
                'description' => 'Dasar-dasar pembukuan, siklus akuntansi perusahaan jasa dan dagang.',
                'cover_image' => null,
            ],
            [
                'category_id' => $catTkr->id,
                'title' => 'Pemeliharaan Mesin Sepeda Motor',
                'author' => 'Z. Fahrudin',
                'publisher' => 'Bumi Aksara',
                'publication_year' => 2022,
                'isbn' => '978-602-444-991-0',
                'stock' => 5,
                'available_stock' => 5,
                'shelf_location' => 'Rak E-01',
                'description' => 'Panduan praktik servis tune-up, sistem injeksi EFI, dan overhaul mesin sepeda motor.',
                'cover_image' => null,
            ],
            [
                'category_id' => $catRpl->id,
                'title' => 'Mastering React & Tailwind CSS',
                'author' => 'Alex Turner',
                'publisher' => 'Tech Media Press',
                'publication_year' => 2024,
                'isbn' => '978-1-59327-999-1',
                'stock' => 5,
                'available_stock' => 5,
                'shelf_location' => 'Rak B-01',
                'description' => 'Modern front-end engineering with React 19, Tailwind CSS utility-first layouting, and state management.',
                'cover_image' => 'https://lh3.googleusercontent.com/aida/AEtjO1V6ZL49JemJfa2lgMuNoQBrdHnowaWxRAnss51oxYzlr2OCXTjO7YGSVvr9eSS7OmDOg16vnlO_e1TV2Mv30ayDhdw5ARcS_9IbbywAU-sOagClU9NuexdL6ljFqbSV3OUjBgV8STHQ28Kv3jSR13EBdXokpqPiWwDeYb5A7tUkEVxRnIGjyA4xCcyKY7hZKV8RdNbQ1uWlwJlo6zDBbx6F7RVR1G7xosRrtVCBB5f_5vOhRuC5w-yZbZM',
            ],
            [
                'category_id' => $catTkr->id,
                'title' => 'Teknik Kendaraan Ringan Lanjut',
                'author' => 'Bambang Sudarmono',
                'publisher' => 'Erlangga Kejuruan',
                'publication_year' => 2021,
                'isbn' => '978-602-298-500-1',
                'stock' => 2,
                'available_stock' => 2, // low stock warning example
                'shelf_location' => 'Rak E-03',
                'description' => 'Studi mendalam transmisi otomatis, sistem rem ABS, dan electronic control unit (ECU).',
                'cover_image' => null,
            ],
        ];

        $books = [];
        foreach ($booksData as $bData) {
            $books[$bData['title']] = Book::firstOrCreate(
                ['title' => $bData['title']],
                $bData
            );
        }

        // 4. Borrowings & Fines
        // Active Borrowing: Ahmad Fikri borrows Admin. Infrastruktur Jaringan
        $borrow1 = Borrowing::firstOrCreate(
            ['transaction_code' => 'TRX-0982'],
            [
                'user_id' => $siswa1->id,
                'book_id' => $books['Administrasi Infrastruktur Jaringan']->id,
                'borrow_date' => Carbon::now()->subDays(3),
                'due_date' => Carbon::now()->addDays(4),
                'status' => 'borrowed',
                'notes' => 'Peminjaman rutin untuk mata pelajaran Jaringan.',
            ]
        );

        // Overdue Borrowing: Siti Nurhaliza borrows Pengantar Akuntansi (Overdue 5 days)
        $borrow2 = Borrowing::firstOrCreate(
            ['transaction_code' => 'TRX-0981'],
            [
                'user_id' => $siswa2->id,
                'book_id' => $books['Pengantar Akuntansi']->id,
                'borrow_date' => Carbon::now()->subDays(12),
                'due_date' => Carbon::now()->subDays(5),
                'status' => 'overdue',
                'notes' => 'Tenggat pengembalian terlampaui.',
            ]
        );

        // Fine for TRX-0981 (Rp 5.000, 5 days overdue @ Rp 1.000/day)
        Fine::firstOrCreate(
            ['borrowing_id' => $borrow2->id],
            [
                'user_id' => $siswa2->id,
                'amount' => 5000,
                'days_overdue' => 5,
                'status' => 'unpaid',
                'notes' => 'Terlambat 5 hari (Rp 1.000/hari)',
            ]
        );

        // Returned Borrowing: Budi Santoso borrows Pemeliharaan Mesin Sepeda Motor
        $borrow3 = Borrowing::firstOrCreate(
            ['transaction_code' => 'TRX-0980'],
            [
                'user_id' => $siswa3->id,
                'book_id' => $books['Pemeliharaan Mesin Sepeda Motor']->id,
                'borrow_date' => Carbon::now()->subDays(10),
                'due_date' => Carbon::now()->subDays(3),
                'return_date' => Carbon::now()->subDays(3),
                'status' => 'returned',
                'notes' => 'Dikembalikan tepat waktu dalam kondisi baik.',
            ]
        );

        // Returned with Paid Fine: Rina Melati
        $borrow4 = Borrowing::firstOrCreate(
            ['transaction_code' => 'TRX-0979'],
            [
                'user_id' => $siswa4Inactive->id,
                'book_id' => $books['Dasar Pemrograman Web']->id,
                'borrow_date' => Carbon::now()->subDays(20),
                'due_date' => Carbon::now()->subDays(13),
                'return_date' => Carbon::now()->subDays(10),
                'status' => 'returned',
                'notes' => 'Terlambat 3 hari, denda telah diselesaikan.',
            ]
        );

        Fine::firstOrCreate(
            ['borrowing_id' => $borrow4->id],
            [
                'user_id' => $siswa4Inactive->id,
                'amount' => 3000,
                'days_overdue' => 3,
                'status' => 'paid',
                'payment_date' => Carbon::now()->subDays(10),
                'paid_to_user_id' => $admin->id,
                'notes' => 'Denda lunas dibayarkan tunai.',
            ]
        );

        // 5. Activity Logs
        ActivityLog::record('book_created', 'Buku baru ditambahkan: "Mastering React & Tailwind CSS" oleh Admin.', $admin->id);
        ActivityLog::record('borrowing_created', 'Transaksi TRX-0982: Ahmad Fikri meminjam "Administrasi Infrastruktur Jaringan".', $admin->id);
        ActivityLog::record('fine_paid', 'Pembayaran denda TRX-0979 sebesar Rp 3.000 oleh Rina Melati telah diterima.', $admin->id);
        ActivityLog::record('return_processed', 'Pengembalian buku TRX-0980 oleh Budi Santoso telah diproses.', $admin->id);
    }
}
