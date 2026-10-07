<?php

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\User;
use Carbon\Carbon;

test('dual stock logic decrements available stock on borrow and increments on return', function () {
    $category = Category::factory()->create();
    $book = Book::factory()->create([
        'category_id' => $category->id,
        'stock' => 5,
        'available_stock' => 5,
    ]);

    $member = User::factory()->create([
        'role' => 'member',
        'status' => 'active',
    ]);

    // Member borrows book
    $response = $this->actingAs($member)->post(route('member.borrowings.store'), [
        'book_id' => $book->id,
        'notes' => 'Pinjam untuk tugas kejuruan',
    ]);

    $response->assertRedirect(route('member.borrowings.current'));
    $book->refresh();
    expect($book->available_stock)->toBe(4);

    $borrowing = Borrowing::where('user_id', $member->id)->where('book_id', $book->id)->first();
    expect($borrowing)->not->toBeNull()
        ->and($borrowing->status)->toBe('borrowed');

    // Admin processes return
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

    $returnResponse = $this->actingAs($admin)->post(route('admin.returns.process', $borrowing));
    $returnResponse->assertRedirect();

    $book->refresh();
    $borrowing->refresh();

    expect($book->available_stock)->toBe(5)
        ->and($borrowing->status)->toBe('returned')
        ->and($borrowing->return_date)->not->toBeNull();
});

test('member cannot borrow book when available stock is 0', function () {
    $category = Category::factory()->create();
    $book = Book::factory()->create([
        'category_id' => $category->id,
        'stock' => 2,
        'available_stock' => 0,
    ]);

    $member = User::factory()->create([
        'role' => 'member',
        'status' => 'active',
    ]);

    $response = $this->actingAs($member)->post(route('member.borrowings.store'), [
        'book_id' => $book->id,
    ]);

    $response->assertSessionHas('error');
    $book->refresh();
    expect($book->available_stock)->toBe(0);

    $this->assertDatabaseMissing('borrowings', [
        'user_id' => $member->id,
        'book_id' => $book->id,
    ]);
});

test('prevent double return on already returned borrowing', function () {
    $category = Category::factory()->create();
    $book = Book::factory()->create([
        'category_id' => $category->id,
        'stock' => 3,
        'available_stock' => 3,
    ]);

    $member = User::factory()->create(['role' => 'member', 'status' => 'active']);
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

    $borrowing = Borrowing::create([
        'transaction_code' => 'PJ-TEST001',
        'user_id' => $member->id,
        'book_id' => $book->id,
        'borrow_date' => Carbon::today()->subDays(3),
        'due_date' => Carbon::today()->addDays(4),
        'return_date' => Carbon::today(),
        'status' => 'returned',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.returns.process', $borrowing));

    $response->assertSessionHas('error');
    $book->refresh();
    // Available stock should NOT exceed total stock
    expect($book->available_stock)->toBe(3);
});

test('returning overdue book automatically records fine and calculates Rp 1000 per day', function () {
    $category = Category::factory()->create();
    $book = Book::factory()->create([
        'category_id' => $category->id,
        'stock' => 5,
        'available_stock' => 4,
    ]);

    $member = User::factory()->create(['role' => 'member', 'status' => 'active']);
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

    // Borrowed 10 days ago, due 3 days ago (overdue by 3 days)
    $borrowing = Borrowing::create([
        'transaction_code' => 'PJ-OVERDUE01',
        'user_id' => $member->id,
        'book_id' => $book->id,
        'borrow_date' => Carbon::today()->subDays(10),
        'due_date' => Carbon::today()->subDays(3),
        'status' => 'borrowed',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.returns.process', $borrowing));
    $response->assertRedirect();

    $borrowing->refresh();
    expect($borrowing->status)->toBe('returned');

    $fine = Fine::where('borrowing_id', $borrowing->id)->first();
    expect($fine)->not->toBeNull()
        ->and($fine->days_overdue)->toBe(3)
        ->and((float) $fine->amount)->toBe(3000.0)
        ->and($fine->status)->toBe('unpaid');
});

test('admin can settle fine and cannot double pay fine', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $member = User::factory()->create(['role' => 'member', 'status' => 'active']);
    $category = Category::factory()->create();
    $book = Book::factory()->create(['category_id' => $category->id]);

    $borrowing = Borrowing::create([
        'transaction_code' => 'PJ-FINE01',
        'user_id' => $member->id,
        'book_id' => $book->id,
        'borrow_date' => Carbon::today()->subDays(10),
        'due_date' => Carbon::today()->subDays(2),
        'return_date' => Carbon::today(),
        'status' => 'returned',
    ]);

    $fine = Fine::create([
        'borrowing_id' => $borrowing->id,
        'user_id' => $member->id,
        'amount' => 2000,
        'days_overdue' => 2,
        'status' => 'unpaid',
    ]);

    // Admin pays fine
    $payResponse = $this->actingAs($admin)->post(route('admin.fines.pay', $fine), [
        'notes' => 'Lunas dibayar tunai di kasir',
    ]);

    $payResponse->assertRedirect();
    $fine->refresh();

    expect($fine->status)->toBe('paid')
        ->and($fine->paid_to_user_id)->toBe($admin->id)
        ->and($fine->payment_date)->not->toBeNull();

    // Attempt double pay
    $doublePayResponse = $this->actingAs($admin)->post(route('admin.fines.pay', $fine));
    $doublePayResponse->assertSessionHas('error');
});

test('admin can deactivate (soft delete) a book without active borrowings and restore it', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $category = Category::factory()->create();
    $book = Book::factory()->create(['category_id' => $category->id]);

    // Deactivate book
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.books.destroy', $book));
    $deleteResponse->assertRedirect(route('admin.books.index'));

    expect(Book::count())->toBe(0)
        ->and(Book::withTrashed()->count())->toBe(1);

    // Restore book
    $restoreResponse = $this->actingAs($admin)->post(route('admin.books.restore', $book->id));
    $restoreResponse->assertRedirect(route('admin.books.index'));

    expect(Book::count())->toBe(1);
});

test('admin cannot deactivate book that is currently borrowed', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $member = User::factory()->create(['role' => 'member', 'status' => 'active']);
    $category = Category::factory()->create();
    $book = Book::factory()->create(['category_id' => $category->id]);

    Borrowing::create([
        'transaction_code' => 'PJ-BORROWED-DEL',
        'user_id' => $member->id,
        'book_id' => $book->id,
        'borrow_date' => Carbon::today(),
        'due_date' => Carbon::today()->addDays(7),
        'status' => 'borrowed',
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.books.destroy', $book));
    $response->assertSessionHas('error');

    expect(Book::count())->toBe(1)
        ->and($book->fresh()->deleted_at)->toBeNull();
});

test('deactivated book preserves relation in borrowings and returns history without crashing', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
    $member = User::factory()->create(['role' => 'member', 'status' => 'active']);
    $category = Category::factory()->create();
    $book = Book::factory()->create(['category_id' => $category->id]);

    $borrowing = Borrowing::create([
        'transaction_code' => 'PJ-HIST-001',
        'user_id' => $member->id,
        'book_id' => $book->id,
        'borrow_date' => Carbon::today()->subDays(5),
        'due_date' => Carbon::today()->addDays(2),
        'return_date' => Carbon::today(),
        'status' => 'returned',
    ]);

    // Soft delete the book
    $book->delete();

    // Verify relation resolves soft-deleted book
    $borrowing->refresh();
    expect($borrowing->book)->not->toBeNull()
        ->and($borrowing->book->id)->toBe($book->id);

    // Verify returns page and borrowings page render without error
    $returnsPage = $this->actingAs($admin)->get(route('admin.returns.index'));
    $returnsPage->assertOk();

    $borrowingsPage = $this->actingAs($admin)->get(route('admin.borrowings.index'));
    $borrowingsPage->assertOk();
});
