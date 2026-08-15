<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('doctors')
            ->where('name', 'Dr Allan Faiti')
            ->update([
                'display_order' => 1,
                'updated_at' => now(),
            ]);

        DB::table('doctors')
            ->where('name', 'Dr. Mercy Banda')
            ->update([
                'display_order' => 2,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('doctors')
            ->where('name', 'Dr. Mercy Banda')
            ->update([
                'display_order' => 1,
                'updated_at' => now(),
            ]);

        DB::table('doctors')
            ->where('name', 'Dr Allan Faiti')
            ->update([
                'display_order' => 2,
                'updated_at' => now(),
            ]);
    }
};
