<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('currency_conversions', function (Blueprint $table) {
            $table->id();

            $table->string('from_currency');
            $table->float('from_amount');
            $table->string('to_currency');
            $table->float('to_amount');
            $table->string('api_provider');

            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_conversions');
    }
};
