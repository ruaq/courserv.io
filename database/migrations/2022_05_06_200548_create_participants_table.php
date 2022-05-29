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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->foreignId('contact_id')->nullable()->constrained('contact_people')->nullOnDelete();
            $table->string('lastname');
            $table->string('firstname');
            $table->date('date_of_birth');
            $table->string('company')->nullable();
            $table->string('street')->nullable();
            $table->string('zipcode', 5)->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('email_reminder')->nullable();
            $table->boolean('rating')->default(0);
            $table->string('payee')->nullable();
            $table->boolean('participated')->default(0);
            $table->decimal('price_net', 8, 2)->default(0);
            $table->decimal('price_gross', 8, 2)->default(0);
            $table->string('currency', 10);
            $table->tinyText('payment');
            $table->unsignedBigInteger('price_id');
            $table->boolean('payed')->default(0);
            $table->string('transaction_id')->nullable()->unique();
            $table->boolean('cancelled')->default(0);
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
        Schema::dropIfExists('participants');
    }
};
