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
            'from_currency' => ['required', 'string', Rule::in(CurrencyConversion::AVAILABLE_MONEY_CURRENCIES)],
            'from_amount'   => ['required', 'numeric'],
            'to_currency'   => ['required', 'string', 'max:10', 'alpha:ascii'],
        ];
    }

    /**
     * @return CurrencyConversionDTO
     */
    public function toDTO(): CurrencyConversionDTO
    {
        $data = $this->validated();

        return new CurrencyConversionDTO(
            $data['from_currency'],
            $data['from_amount'],
            $data['to_currency'],
        );
    }
}
