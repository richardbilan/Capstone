<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

public function up()
{
    Schema::create('alerts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('hazard_type')->nullable();
        $table->string('level');
        $table->text('description')->nullable();
        $table->dateTime('date')->nullable();
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
