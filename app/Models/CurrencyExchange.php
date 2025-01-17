<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CurrencyExchange
 * @package App\Models
 * @property string $uuid
 * @property int $currency_id
 * @property string $code
 * @property string $name
 * @property string $date
 */

class CurrencyExchange extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'currency_id',
        'code',
        'name',
        'rate',
        'date'
    ];

    protected $casts = [
        'rate' => 'decimal:8',
        'date' => 'date',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }


}
