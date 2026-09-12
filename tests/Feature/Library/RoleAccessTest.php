<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\User;

test('guest is redirected to login when accessing admin dashboard', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});

test('member cannot access admin dashboard', function () {
    $member = User::factory()->create([
        'role' => 'member',
        'status' => 'active',
    ]);

    $response = $this->actingAs($member)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('admin can access admin dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'active',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
});

test('member can access member dashboard and catalog', function () {
    $member = User::factory()->create([
        'role' => 'member',
        'member_type' => 'siswa',
        'nis' => '999901',
        'status' => 'active',
    ]);

    $response = $this->actingAs($member)->get(route('member.dashboard'));
    $response->assertOk();

    $catalogResponse = $this->actingAs($member)->get(route('member.books.index'));
    $catalogResponse->assertOk();
});

test('dashboard route redirects user according to role', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $member = User::factory()->create(['role' => 'member', 'status' => 'active']);

    $this->actingAs($admin)->get('/dashboard')->assertRedirect(route('admin.dashboard'));
    $this->actingAs($member)->get('/dashboard')->assertRedirect(route('member.dashboard'));
});

test('inactive member is blocked from borrowing books', function () {
    $inactiveMember = User::factory()->create([
        'role' => 'member',
        'status' => 'inactive',
    ]);

    $category = Category::factory()->create();
    $book = Book::create([
        'category_id' => $category->id,
        'title' => 'Buku Uji Coba',
        'author' => 'Penulis Uji Coba',
        'publisher' => 'Penerbit Uji Coba',
        'publication_year' => 2024,
        'stock' => 5,
        'available_stock' => 5,
    ]);

    $response = $this->actingAs($inactiveMember)->post(route('member.borrowings.store'), [
        'book_id' => $book->id,
    ]);

    $response->assertSessionHas('error');
    $this->assertDatabaseMissing('borrowings', [
        'user_id' => $inactiveMember->id,
        'book_id' => $book->id,
    ]);
});
