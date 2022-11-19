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
        Schema::table('course_types', function (Blueprint $table) {
            $table->unsignedBigInteger('cert_template_id')->nullable()->after('wsdl_id');
            $table->foreign('cert_template_id')->references('id')->on('cert_templates')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_types', function (Blueprint $table) {
            $table->dropForeign(['cert_template_id']);
            $table->dropColumn('cert_template_id');
        });
    }
};
