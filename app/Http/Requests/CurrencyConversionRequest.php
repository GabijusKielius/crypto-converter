<?php

namespace App\Http\Requests;

use App\DTO\CurrencyConversionDTO;
use App\Models\CurrencyConversion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyConversionRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'amount'          => ['required', 'numeric'],
            'currency_money'  => ['required', 'string', Rule::in(CurrencyConversion::AVAILABLE_MONEY_CURRENCIES)],
            'currency_crypto' => ['required', 'string', 'max:10', 'alpha:ascii'],
        ];
    }

    /**
     * @return CurrencyConversionDTO
     */
    public function toDTO(): CurrencyConversionDTO
    {
        $data = $this->validated();

        return new CurrencyConversionDTO(
            $data['amount'],
            $data['currency_money'],
            $data['currency_crypto'],
        );
    }
}
