<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('services')
            ->where('name', 'Laboratory Services')
            ->update([
                'image_path' => 'imgs/services/_MG_2134.jpg',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('name', 'Laboratory Services')
            ->where('image_path', 'imgs/services/_MG_2134.jpg')
            ->update([
                'image_path' => 'imgs/services/laboratory-services.png',
                'updated_at' => now(),
            ]);
    }
};
