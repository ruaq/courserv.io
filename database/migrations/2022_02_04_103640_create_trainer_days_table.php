<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('trainer_days', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_day_id')->nullable()->constrained('course_days')->cascadeOnDelete();
            $table->foreignId('position')->nullable()->constrained('positions')->nullOnDelete();
            $table->tinyInteger('order')->default(0);
            $table->string('option')->nullable();
            $table->timestamps();

            $table->unique(['course_id', 'user_id', 'course_day_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_days');
    }
};
