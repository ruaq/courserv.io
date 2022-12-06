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
        Schema::create('trainer_days', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->boolean('bookable')->default(0);
            $table->tinyInteger('count')->default(0);
            $table->boolean('confirmed')->default(0);
            $table->timestamps();

            $table->unique(['course_id', 'user_id', 'date', 'bookable']);
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
