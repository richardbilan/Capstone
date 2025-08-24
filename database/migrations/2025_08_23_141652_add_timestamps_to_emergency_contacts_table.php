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
    Schema::table('emergency_contacts', function (Blueprint $table) {
        $table->timestamps(); // Adds created_at and updated_at
    });}
    
    public function down()
    {
    Schema::table('emergency_contacts', function (Blueprint $table) {
        $table->dropColumn(['created_at', 'updated_at']);
    });}

};

