<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_type_id');
            $table->unsignedBigInteger('team_id');
            $table->string('internal_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->text('seminar_location');
            $table->text('street');
            $table->text('zipcode');
            $table->text('location');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->dateTime('cancelled')->nullable();
            $table->unsignedSmallInteger('seats');
            $table->timestamps();

            $table->foreign('course_type_id')->references('id')->on('course_types')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
