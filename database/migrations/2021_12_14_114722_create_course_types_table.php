<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTypesTable extends Migration
{
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
            $table->string('units', 10)->default(0);
            $table->string('units_per_day', 10)->default(0);
            $table->string('breaks', 10)->default(0);
            $table->string('seats', 10)->default(0);
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
}
