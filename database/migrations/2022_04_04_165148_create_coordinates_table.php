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
        Schema::create('coordinates', function (Blueprint $table) {
            $table->id();
            $table->string('country_code', 2);
            $table->string('zipcode', 5);
            $table->text('location');
            $table->text('state');
            $table->text('lat');
            $table->text('lon');
            $table->timestamps();

            if (getenv('DB_CONNECTION') === 'mysql') { // prevent errors in sqlite (pest)
                $table->fullText(['zipcode', 'location'], 'fulltext_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinates');
    }
};
