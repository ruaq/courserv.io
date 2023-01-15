<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            // needs to have a defined length for indexing
            $table->string('zipcode', 5);
            $table->string('location', 255);
            $table->string('state', 255);

            $table->unique(['zipcode', 'location']);

            if (getenv('DB_CONNECTION') === 'sqlite') { // prevent errors in sqlite (pest)
                return;
            }

            $table->fullText(['zipcode', 'location'], 'fulltext_index');
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
