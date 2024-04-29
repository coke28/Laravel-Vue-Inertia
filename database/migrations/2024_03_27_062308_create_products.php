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
      
        //
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index('user_id')->constrained();
            $table->foreignId('category_id')->index('category_id')->constrained();
            $table->string('product_name');
            $table->string('product_description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('products');
    }
};
