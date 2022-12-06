<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('course_price', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('price_id')->constrained()->onDelete('cascade');

            $table->primary(['course_id', 'price_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('course_price');
    }
};
