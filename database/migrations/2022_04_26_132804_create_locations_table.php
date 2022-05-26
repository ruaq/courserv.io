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
        Schema::create('locations', function (Blueprint $table) {
//            $table->string('country_code', 2);
            $table->string('zipcode', 5);
            $table->string('location', 255);
            $table->string('state', 255);
//            $table->text('lat');
//            $table->text('lon');
//            $table->timestamps();

            if( getenv('DB_CONNECTION') === 'mysql' ) { // prevent errors in sqlite (pest)
                $table->fullText(['zipcode', 'location'], 'fulltext_index');
            }

            $table->unique(['zipcode', 'location']);
        });

//        DB::statement(
//            'ALTER TABLE locations ADD FULLTEXT fulltext_index(zipcode, location)'
//        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
