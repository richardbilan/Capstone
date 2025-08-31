<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('map_features', function (Blueprint $table) {
            $table->id();

            // Category: 'infrastructure', 'route', or 'pwd'
            $table->string('category');
            // Type: e.g., 'barangay_hall', 'elementary_school', 'evac_routes', 'pwd_households'
            $table->string('type');

            $table->string('name')->nullable();
            $table->text('description')->nullable();

            // For quick querying and simple usage, store lat/lng explicitly (WGS84)
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Optional raw GeoJSON geometry for flexibility (Point/LineString/Polygon)
            $table->json('geometry')->nullable();

            // Arbitrary additional properties
            $table->json('properties')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_features');
    }
};
