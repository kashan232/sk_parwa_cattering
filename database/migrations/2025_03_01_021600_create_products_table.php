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
            $table->foreignId('category_id');//pakistani
            $table->foreignId('subcategory_id');//biryani
            $table->foreignId('unit_id');//15kg pot
            $table->string('name');// Tika Biryani
            $table->string('image');// Tika Biryani image
            $table->string('price');//15000
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
