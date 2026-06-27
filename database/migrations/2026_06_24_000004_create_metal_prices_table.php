<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metal_prices', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('symbol')->unique();
            $table->decimal('price', 18, 4)->nullable();
            $table->string('unit')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('change_amount', 18, 4)->nullable();
            $table->decimal('change_percent', 8, 4)->nullable();
            $table->string('direction')->default('neutral');
            $table->string('source')->nullable();
            $table->string('provider')->nullable();
            $table->timestamp('last_updated_at')->nullable()->index();
            $table->boolean('is_stale')->default(false);
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->json('raw_payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metal_prices');
    }
};
