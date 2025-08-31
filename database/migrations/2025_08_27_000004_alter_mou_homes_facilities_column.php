<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('mou_homes') || !Schema::hasColumn('mou_homes', 'facilities')) {
            return;
        }

        // Try to convert to JSON, fallback to LONGTEXT if JSON not supported
        try {
            DB::statement('ALTER TABLE `mou_homes` MODIFY `facilities` JSON NULL');
        } catch (\Throwable $e) {
            DB::statement('ALTER TABLE `mou_homes` MODIFY `facilities` LONGTEXT NULL');
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('mou_homes') || !Schema::hasColumn('mou_homes', 'facilities')) {
            return;
        }
        // Revert to a generic string to be safe
        try {
            DB::statement('ALTER TABLE `mou_homes` MODIFY `facilities` VARCHAR(255) NULL');
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
