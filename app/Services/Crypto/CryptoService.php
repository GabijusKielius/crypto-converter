<?php

namespace App\Services\Crypto;

use App\Models\CurrencyConversion;
use Illuminate\Http\Client\Response;

interface CryptoService {
    public function getCrypto(): CurrencyConversion;
    public function call(): Response;
}
