<?php

it('renders the public announcements list page successfully', function () {
    $response = $this->get(route('pengumuman'));

    $response->assertOk()
        ->assertSee('Pengumuman Perpustakaan')
        ->assertSee('Pusat warta resmi perpustakaan')
        ->assertSee('Cari judul warta')
        ->assertSee('Semua Kategori')
        ->assertSee('Baca Selengkapnya');
});

it('includes the pengumuman menu and auth links in public navbar with active state', function () {
    $response = $this->get(route('pengumuman'));

    $response->assertOk()
        ->assertSee('Beranda')
        ->assertSee('Katalog')
        ->assertSee('Pengumuman')
        ->assertSee('Informasi')
        ->assertSee('Masuk')
        ->assertSee('Daftar')
        ->assertSee('text-secondary font-bold');
});

it('can filter announcements by category', function () {
    $response = $this->get(route('pengumuman', ['kategori' => 'Layanan & Operasional']));

    $response->assertOk()
        ->assertSee('Penyesuaian Jam Operasional Perpustakaan')
        ->assertDontSee('Pekan Literasi Vokasi SMKN 5');
});

it('can search announcements by query keyword', function () {
    $response = $this->get(route('pengumuman', ['q' => 'Barcode']));

    $response->assertOk()
        ->assertSee('Modernisasi Fasilitas: Peluncuran Kartu Anggota Digital')
        ->assertDontSee('Pekan Literasi Vokasi SMKN 5');
});

it('can search announcements using multi-word queries', function () {
    $response = $this->get(route('pengumuman', ['q' => 'buku rpl']));

    $response->assertOk()
        ->assertSee('Koleksi Buku Baru Jurusan RPL')
        ->assertDontSee('Pekan Literasi Vokasi SMKN 5');
});

it('contains search form and buttons with proper ids and pagination touch styling', function () {
    $response = $this->get(route('pengumuman'));

    $response->assertOk()
        ->assertSee('id="announcementSearchForm"', false)
        ->assertSee('id="searchInput"', false)
        ->assertSee('id="btnApplyFilter"', false)
        ->assertSee('gap-2', false)
        ->assertSee('min-h-[42px]', false)
        ->assertSee('Berikutnya');
});

it('displays empty state when no announcements match criteria', function () {
    $response = $this->get(route('pengumuman', ['q' => 'kata_kunci_acak_yang_pasti_tidak_ada']));

    $response->assertOk()
        ->assertSee('Pengumuman Tidak Ditemukan')
        ->assertSee('Lihat Semua Pengumuman');
});

it('renders an announcement detail page successfully', function () {
    $response = $this->get(route('pengumuman.show', 'jadwal-operasional-pas-ganjil-2026'));

    $response->assertOk()
        ->assertSee('Penyesuaian Jam Operasional Perpustakaan')
        ->assertSee('Layanan & Operasional')
        ->assertSee('Kembali ke Pengumuman')
        ->assertSee('Pengumuman Lainnya');
});

it('returns 404 for non-existent announcement slug', function () {
    $response = $this->get(route('pengumuman.show', 'pengumuman-fiktif-tidak-ada'));

    $response->assertNotFound();
});
