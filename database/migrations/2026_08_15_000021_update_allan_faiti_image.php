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
                'image_path' => 'imgs/doctors/Allan Faiti.jpg',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('doctors')
            ->where('name', 'Dr Allan Faiti')
            ->where('image_path', 'imgs/doctors/Allan Faiti.jpg')
            ->update([
                'image_path' => null,
                'updated_at' => now(),
            ]);
    }
};
