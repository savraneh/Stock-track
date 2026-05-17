<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('unit')->default('pcs');
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('min_stock')->default(0);
            $table->unsignedInteger('safe_stock')->default(0);
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'name']);
            $table->index(['supplier_id', 'name']);
            $table->index(['stock', 'min_stock', 'safe_stock']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
