<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restock_recommendations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('recommended_amount');
            $table->decimal('daily_usage_avg', 10, 2)->default(0);
            $table->string('status')->default('draft');
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->index(['item_id', 'generated_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restock_recommendations');
    }
};
