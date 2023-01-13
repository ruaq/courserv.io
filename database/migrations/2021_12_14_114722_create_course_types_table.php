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
        Schema::create('course_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('wsdl_id')->nullable();
            $table->foreignId('cert_template_id')->nullable()->constrained('cert_templates')->nullOnDelete();
            $table->string('name');
            $table->string('category');
            $table->string('slug');
            $table->string('iframe_url')->nullable();
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
    public function down(): void
    {
        Schema::dropIfExists('course_types');
    }
};
