<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyConversion extends Model
{
    use HasFactory;

    public const CURRENCY_EUR = 'EUR';
    public const CURRENCY_USD = 'USD';
    public const CURRENCY_PLN = 'PLN';

    public const AVAILABLE_MONEY_CURRENCIES = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_PLN
    ];

    protected $fillable = [
        'from_currency',
        'from_amount',
        'to_currency',
        'to_amount',
        'provider',
    ];
}
