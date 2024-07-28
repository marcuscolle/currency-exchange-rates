<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currency_exchange', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('currency_id')->constrained()->onDelete('cascade');
            $table->string('currency_code');
            $table->string('name')->nullable();
            //used decimal as stares the exact value of the exchange rate
            $table->decimal('exchange_rate', 20, 20);
            $table->date('exchange_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_exchange');
    }
};
