<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('mou_homes')) {
            return; // table not present in this environment
        }

        Schema::table('mou_homes', function (Blueprint $table) {
            if (!Schema::hasColumn('mou_homes', 'facilities')) {
                // Use JSON so we can store multiple facilities and custom entries
                $table->json('facilities')->nullable()->after('capacity');
            }
        });

        // Backfill JSON column from legacy boolean columns if they exist
        $legacy = ['toilet', 'water', 'electricity', 'kitchen', 'parking', 'first_aid'];
        $hasAnyLegacy = false;
        foreach ($legacy as $col) {
            if (Schema::hasColumn('mou_homes', $col)) { $hasAnyLegacy = true; break; }
        }

        if ($hasAnyLegacy) {
            $rows = DB::table('mou_homes')->select(array_merge(['id'], $legacy))->get();
            foreach ($rows as $row) {
                $facilities = [];
                foreach ($legacy as $col) {
                    if (property_exists($row, $col) && (int)($row->{$col}) === 1) {
                        $facilities[] = $col;
                    }
                }
                DB::table('mou_homes')->where('id', $row->id)->update([
                    'facilities' => $facilities ? json_encode($facilities) : null,
                ]);
            }

            // Drop legacy columns if present
            Schema::table('mou_homes', function (Blueprint $table) use ($legacy) {
                foreach ($legacy as $col) {
                    if (Schema::hasColumn('mou_homes', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('mou_homes')) {
            return;
        }

        // Recreate legacy columns
        Schema::table('mou_homes', function (Blueprint $table) {
            foreach (['toilet', 'water', 'electricity', 'kitchen', 'parking', 'first_aid'] as $col) {
                if (!Schema::hasColumn('mou_homes', $col)) {
                    $table->boolean($col)->default(0);
                }
            }
        });

        // Backfill legacy columns from JSON
        if (Schema::hasColumn('mou_homes', 'facilities')) {
            $rows = DB::table('mou_homes')->select(['id', 'facilities'])->get();
            foreach ($rows as $row) {
                $values = [];
                if ($row->facilities) {
                    $decoded = json_decode($row->facilities, true);
                    if (is_array($decoded)) { $values = $decoded; }
                }
                $update = [];
                foreach (['toilet', 'water', 'electricity', 'kitchen', 'parking', 'first_aid'] as $col) {
                    $update[$col] = in_array($col, $values, true) ? 1 : 0;
                }
                DB::table('mou_homes')->where('id', $row->id)->update($update);
            }
        }

        // Drop JSON column
        Schema::table('mou_homes', function (Blueprint $table) {
            if (Schema::hasColumn('mou_homes', 'facilities')) {
                $table->dropColumn('facilities');
            }
        });
    }
};
