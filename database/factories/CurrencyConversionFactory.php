<?php

namespace Database\Factories;

use App\Models\CurrencyConversion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyConversionFactory extends Factory
{
    protected $model = CurrencyConversion::class;

    public function definition(): array
    {
        $from = $this->faker->currencyCode;
        $to = $this->faker->currencyCode;
        while ($from === $to) {
            $to = $this->faker->currencyCode;
        }
        return [
            'from_currency' => $from,
            'to_currency' => $to,
            'from_amount' => $this->faker->numberBetween(1, 1000),
            'to_amount' => $this->faker->numberBetween(1, 1000),
            'api_provider' => $this->faker->company,
        ];
    }
}
