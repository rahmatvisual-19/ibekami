<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('product_id')->primary();
            $table->string('name');
            $table->foreignId('product_type')->default(0)->constrained('types')->onDelete('cascade');
            $table->foreignId('category_type')->default(0)->constrained('categories')->onDelete('cascade');
            $table->integer('discount')->default(0);
            $table->integer('price')->default(0);
            $table->json('image_url')->nullable();
            $table->json('detail')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('click_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
