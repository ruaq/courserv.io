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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->foreignId('cert_template_id')->nullable()->constrained('cert_templates')->nullOnDelete();
            $table->string('title');
            $table->string('description')->nullable();
            $table->decimal('amount_net', 8, 2)->default(0);
            $table->decimal('amount_gross', 8, 2)->default(0);
            $table->string('currency', 10);
            $table->text('payment');
            $table->smallInteger('tax_rate')->default(0)->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('prices');
    }
};
