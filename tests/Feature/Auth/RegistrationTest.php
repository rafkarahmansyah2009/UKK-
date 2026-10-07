<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('siswa registration screen can be rendered', function () {
    $response = $this->get(route('register.siswa'));

    $response->assertStatus(200);
});

test('guru registration screen can be rendered', function () {
    $response = $this->get(route('register.guru'));

    $response->assertStatus(200);
});

test('new siswa can register', function () {
    $response = $this->post('/register/siswa', [
        'name' => 'Siswa Baru',
        'email' => 'siswa.baru@smkn5.sch.id',
        'username' => 'siswa_baru',
        'nis' => '20261099',
        'class' => 'X RPL 1',
        'major' => 'Rekayasa Perangkat Lunak',
        'phone' => '08123456789',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => '1',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('member.dashboard', absolute: false));
});

test('new guru can register', function () {
    $response = $this->post('/register/guru', [
        'name' => 'Guru Baru',
        'email' => 'guru.baru@smkn5.sch.id',
        'username' => 'guru_baru',
        'nip' => '198501012020011009',
        'subject' => 'Pemrograman Berorientasi Objek',
        'phone' => '08129876543',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => '1',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('member.dashboard', absolute: false));
});
