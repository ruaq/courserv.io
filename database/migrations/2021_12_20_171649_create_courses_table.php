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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_type_id')->constrained('course_types')->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->string('internal_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->text('seminar_location');
            $table->text('street');
            $table->text('zipcode');
            $table->text('location');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->timestamp('cancelled')->nullable();
            $table->unsignedSmallInteger('seats');
            $table->boolean('public_bookable')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
