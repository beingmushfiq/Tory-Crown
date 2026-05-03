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
        Schema::create('gold_rates', function (Blueprint $table) {
            $table->id();
            $table->string('karat'); // 18K, 21K, 22K, 24K
            $table->decimal('price_per_gram', 12, 2);
            $table->date('effective_date')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_rates');
    }
};
