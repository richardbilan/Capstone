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
        Schema::create('hazard_geometries', function (Blueprint $table) {
            $table->id();
            $table->string('hazard_type', 50); // e.g., flood, landslide, fire, ashfall, lahar, mudflow, wind
            $table->string('name')->nullable();
            $table->string('color', 20)->nullable(); // hex or css color
            $table->json('geometry'); // GeoJSON geometry (Polygon/MultiPolygon/LineString/Point)
            $table->json('properties')->nullable(); // any extra metadata
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index('hazard_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_geometries');
    }
};
