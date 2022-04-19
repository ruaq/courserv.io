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
        Schema::create('course_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('wsdl_id')->nullable();
            $table->string('name');
            $table->string('category');
            $table->string('slug');
            $table->unsignedMediumInteger('units')->default(0);
            $table->unsignedTinyInteger('units_per_day')->default(0);
            $table->unsignedSmallInteger('breaks')->default(0);
            $table->unsignedSmallInteger('seats')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_types');
    }
};
