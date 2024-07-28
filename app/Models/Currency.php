<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Currency
 * @package App\Models
 * @property string $currency_code
 * @property string $name
 */

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'currency_code',
        'name'
    ];


    public function exchange(): HasMany
    {
        return $this->hasMany(CurrencyExchange::class);
    }

}
