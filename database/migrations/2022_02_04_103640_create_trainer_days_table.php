<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_days', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date')->nullable();
            $table->boolean('bookable')->default(0);
            $table->tinyInteger('count')->default(0);
            $table->boolean('confirmed')->default(0);

            $table->timestamps();

            $table->unique(['course_id', 'user_id', 'date', 'bookable']);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer_days');
    }
};
