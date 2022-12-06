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
        Schema::create('course_days', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->date('date');
            $table->time('startPlan');
            $table->time('startReal')->nullable();
            $table->time('endPlan');
            $table->time('endReal')->nullable();
            $table->unsignedMediumInteger('unitsPlan')->default(0);
            $table->unsignedMediumInteger('unitsReal')->default(0);
            $table->timestamps();

            $table->unique(['course_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('course_days');
    }
};
