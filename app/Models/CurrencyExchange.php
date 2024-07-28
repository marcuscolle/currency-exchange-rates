<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CurrencyExchange
 * @package App\Models
 * @property string $currency_code
 * @property string $name
 * @property string $exchange_rate
 * @property string $date
 */

class CurrencyExchange extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'currency_id',
        'currency_code',
        'name',
        'exchange_rate',
        'date'
    ];

    protected $casts = [
        'exchange_rate' => 'decimal',
        'date' => 'date',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }


}
