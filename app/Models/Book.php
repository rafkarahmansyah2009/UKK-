<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'stock',
        'available_stock',
        'shelf_location',
        'description',
        'cover_image',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publication_year' => 'integer',
            'stock' => 'integer',
            'available_stock' => 'integer',
        ];
    }

    /**
     * Get the category that owns the book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the borrowings for the book.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Determine if the book is available for borrowing.
     */
    public function isAvailable(): bool
    {
        return $this->available_stock > 0;
    }

    /**
     * Decrement available stock safely.
     *
     * @throws InvalidArgumentException
     */
    public function decrementAvailableStock(int $amount = 1): void
    {
        if ($this->available_stock < $amount) {
            throw new InvalidArgumentException("Stok buku '{$this->title}' tidak mencukupi untuk dipinjam.");
        }

        $this->decrement('available_stock', $amount);
    }

    /**
     * Increment available stock safely without exceeding total stock.
     *
     * @throws InvalidArgumentException
     */
    public function incrementAvailableStock(int $amount = 1): void
    {
        if ($this->available_stock + $amount > $this->stock) {
            throw new InvalidArgumentException('Stok tersedia tidak boleh melebihi total stok buku.');
        }

        $this->increment('available_stock', $amount);
    }
}
