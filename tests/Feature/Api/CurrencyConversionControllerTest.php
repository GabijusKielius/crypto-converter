<?php

namespace Tests\Feature\Api;

use App\Models\CurrencyConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConversionControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Tests a random combination of currencies and amounts
     *
     * @test
     */
    public function test_convert_random_currency(): void
    {
        $response = $this->postJson(route('currency.convert.store'), [
            'from_currency' => CurrencyConversion::CURRENCY_EUR,
            'from_amount' => $this->faker->numberBetween(1, 9999),
            'to_currency' => $this->faker->currencyCode(),
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'from_currency',
                'from_amount',
                'to_currency',
                'to_amount',
                'created_at',
                'updated_at',
            ]);
    }

    /**
     * Tests form request validation rules
     *
     * @test
     */
    public function testConvertCurrencyValidation(): void
    {
        $response = $this->postJson(route('currency.convert.store'), [
            'from_currency' => 'invalid_currency',
            'from_amount' => 'invalid_amount',
            'to_currency' => 'invalid_currency',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'from_currency',
                'from_amount',
                'to_currency',
            ]);
    }
}
