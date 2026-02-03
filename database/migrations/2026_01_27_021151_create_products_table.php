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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->integer('year_made')->nullable();
            $table->string('color')->nullable();
            $table->string('occasion')->nullable();
            $table->string('size_label')->default('M');
            $table->string('measure_bust')->nullable();
            $table->string('measure_waist')->nullable();
            $table->string('measure_hip')->nullable();
            $table->string('measure_length')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('materials')->nullable();
            $table->integer('stock')->default(1);
            $table->integer('wear_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->json('images')->nullable();
            
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
