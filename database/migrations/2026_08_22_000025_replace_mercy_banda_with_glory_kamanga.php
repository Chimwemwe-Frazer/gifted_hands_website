<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('doctors')
            ->where('name', 'Dr. Mercy Banda')
            ->update([
                'name' => 'Glory Kamanga',
                'specialization' => 'Pharmacist',
                'qualification' => 'Pharmacist',
                'experience' => 'Years of experience: To be confirmed',
                'bio' => 'Glory Kamanga supports pharmacy services and patient guidance on medicines at the clinic.',
                'languages' => json_encode(['English', 'Chichewa'], JSON_THROW_ON_ERROR),
                'image_path' => 'imgs/doctors/glory-kamanga-pharmacist.jpg',
                'status' => 'Active',
                'display_order' => 3,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('doctors')
            ->where('name', 'Glory Kamanga')
            ->update([
                'name' => 'Dr. Mercy Banda',
                'specialization' => 'General Practitioner',
                'qualification' => 'MBBS, Diploma in Family Medicine',
                'experience' => 'Years of experience: To be confirmed',
                'bio' => 'Dr. Banda provides first-contact care for patients with everyday health concerns, routine reviews, and ongoing follow-up needs.',
                'languages' => json_encode(['English', 'Chichewa'], JSON_THROW_ON_ERROR),
                'image_path' => 'imgs/doctors/mercy-banda.png',
                'status' => 'Active',
                'display_order' => 3,
                'updated_at' => now(),
            ]);
    }
};
