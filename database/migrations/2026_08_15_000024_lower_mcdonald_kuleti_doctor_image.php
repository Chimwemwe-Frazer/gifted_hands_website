<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('doctors')
            ->where('name', 'McDonald Kuleti')
            ->update([
                'image_path' => 'imgs/doctors/mcdonald-kuleti-lowered.jpg',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('doctors')
            ->where('name', 'McDonald Kuleti')
            ->where('image_path', 'imgs/doctors/mcdonald-kuleti-lowered.jpg')
            ->update([
                'image_path' => 'imgs/doctors/mcdonald-kuleti.jpg',
                'updated_at' => now(),
            ]);
    }
};
