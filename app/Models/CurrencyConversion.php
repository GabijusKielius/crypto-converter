<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyConversion extends Model
{
    use HasFactory;

    public const AVAILABLE_MONEY_CURRENCIES = [
        'EUR',
        'USD',
        'PLN'
    ];

    protected $fillable = [
        'currency_money',
        'amount',
        'currency_crypto',
        'amount_crypto'
    ];
}
