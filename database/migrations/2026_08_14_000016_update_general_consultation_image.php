<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('services')
            ->where('name', 'General Consultation')
            ->update([
                'image_path' => 'imgs/services/_MG_2064.jpg',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('name', 'General Consultation')
            ->where('image_path', 'imgs/services/_MG_2064.jpg')
            ->update([
                'image_path' => 'imgs/services/general-consultation.png',
                'updated_at' => now(),
            ]);
    }
};
