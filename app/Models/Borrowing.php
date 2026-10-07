<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_code',
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'borrow_date' => 'date',
            'due_date' => 'date',
            'return_date' => 'date',
        ];
    }

    /**
     * Get the user who borrowed the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class)->withTrashed();
    }

    /**
     * Get the fine record if any.
     */
    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    /**
     * Determine if borrowing is overdue.
     */
    public function isOverdue(): bool
    {
        if ($this->status === 'returned') {
            return false;
        }

        return Carbon::today()->gt($this->due_date);
    }

    /**
     * Calculate overdue days based on return_date or today.
     */
    public function calculateOverdueDays(): int
    {
        $comparisonDate = $this->return_date ? Carbon::parse($this->return_date) : Carbon::today();

        if ($comparisonDate->gt($this->due_date)) {
            return $this->due_date->diffInDays($comparisonDate);
        }

        return 0;
    }

    /**
     * Scope for active borrowings (borrowed or overdue).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['borrowed', 'overdue']);
    }

    /**
     * Scope for overdue borrowings.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', 'overdue')
            ->orWhere(function (Builder $q) {
                $q->where('status', 'borrowed')->where('due_date', '<', Carbon::today());
            });
    }
}
