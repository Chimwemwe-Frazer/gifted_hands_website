<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        DB::table('doctors')
            ->where('name', 'Dr Allan Faiti')
            ->update([
                'image_path' => 'imgs/doctors/allan-faiti.jpg',
                'display_order' => 1,
                'updated_at' => $now,
            ]);

        DB::table('doctors')->updateOrInsert(
            ['name' => 'McDonald Kuleti'],
            [
                'specialization' => 'Lab Manager',
                'qualification' => 'Lab Manager',
                'experience' => 'Years of experience: To be confirmed',
                'bio' => 'McDonald Kuleti supports laboratory testing and diagnostic services at the clinic.',
                'languages' => json_encode(['English', 'Chichewa'], JSON_THROW_ON_ERROR),
                'image_path' => 'imgs/doctors/mcdonald-kuleti.jpg',
                'status' => 'Active',
                'display_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('doctors')
            ->where('name', 'Dr. Mercy Banda')
            ->update([
                'display_order' => 3,
                'updated_at' => $now,
            ]);

        DB::table('doctors')
            ->where('name', 'Dr. Daniel Kamanga')
            ->update([
                'display_order' => 4,
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        $now = now();

        DB::table('doctors')
            ->where('name', 'McDonald Kuleti')
            ->delete();

        DB::table('doctors')
            ->where('name', 'Dr Allan Faiti')
            ->where('image_path', 'imgs/doctors/allan-faiti.jpg')
            ->update([
                'image_path' => 'imgs/doctors/Allan Faiti.jpg',
                'display_order' => 1,
                'updated_at' => $now,
            ]);

        DB::table('doctors')
            ->where('name', 'Dr. Mercy Banda')
            ->update([
                'display_order' => 2,
                'updated_at' => $now,
            ]);

        DB::table('doctors')
            ->where('name', 'Dr. Daniel Kamanga')
            ->update([
                'display_order' => 3,
                'updated_at' => $now,
            ]);
    }
};
