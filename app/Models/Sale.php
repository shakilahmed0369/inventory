<?php

namespace App\Models;

use Database\Factories\SaleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    /** @use HasFactory<SaleFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'sale_date',
        'notes',
        'gross_amount',
        'discount',
        'vat_rate',
        'vat_amount',
        'net_payable',
        'paid_amount',
        'due_amount',
    ];

    protected function casts(): array
    {
        return [
            'sale_date' => 'date',
            'gross_amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'vat_rate' => 'decimal:2',
            'vat_amount' => 'decimal:2',
            'net_payable' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'due_amount' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class, 'reference_id')
            ->where('reference_type', self::class);
    }

    public function getStatusAttribute(): string
    {
        if ($this->due_amount <= 0) {
            return 'paid';
        }

        if ($this->paid_amount > 0) {
            return 'partial';
        }

        return 'unpaid';
    }
}
