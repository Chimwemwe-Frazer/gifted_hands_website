<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('services')
            ->where('name', 'Obstetrics & Gynaecology')
            ->update([
                'image_path' => 'imgs/services/obstetrics&gynaecology.jpg',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('name', 'Obstetrics & Gynaecology')
            ->where('image_path', 'imgs/services/obstetrics&gynaecology.jpg')
            ->update([
                'image_path' => null,
                'updated_at' => now(),
            ]);
    }
};
