<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('services')
            ->where('name', 'Physiotherapy')
            ->update([
                'image_path' => 'imgs/services/physiotherapy picture.jpeg',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('name', 'Physiotherapy')
            ->where('image_path', 'imgs/services/physiotherapy picture.jpeg')
            ->update([
                'image_path' => 'imgs/services/physiotherapy.png',
                'updated_at' => now(),
            ]);
    }
};
