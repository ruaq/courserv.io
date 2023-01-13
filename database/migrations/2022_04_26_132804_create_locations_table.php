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
        Schema::create('locations', function (Blueprint $table) {
            $table->string('zipcode', 5);
            $table->string('location', 255);
            $table->string('state', 255);

            if (getenv('DB_CONNECTION') === 'mysql') { // prevent errors in sqlite (pest)
                $table->fullText(['zipcode', 'location'], 'fulltext_index');
            }

            $table->unique(['zipcode', 'location']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
