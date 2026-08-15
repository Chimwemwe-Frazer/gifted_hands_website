<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $details = [
            'name' => 'Dr Allan Faiti',
            'specialization' => 'Clinical Associate Obstetrics and Gynaecology',
            'qualification' => 'Clinical Associate Obstetrics and Gynaecology',
            'experience' => 'Years of experience: To be confirmed',
            'bio' => 'Clinical Associate Obstetrics and Gynaecology.',
            'languages' => json_encode(['English', 'Chichewa'], JSON_THROW_ON_ERROR),
            'image_path' => 'imgs/doctors/Allan Faiti.jpg',
            'status' => 'Active',
            'display_order' => 2,
            'updated_at' => now(),
        ];

        if (DB::table('doctors')->where('name', 'Dr Allan Faiti')->exists()) {
            DB::table('doctors')
                ->where('name', 'Dr Allan Faiti')
                ->update($details);

            return;
        }

        DB::table('doctors')
            ->where('name', 'Dr. Thoko Phiri')
            ->update($details);
    }

    public function down(): void
    {
        DB::table('doctors')
            ->where('name', 'Dr Allan Faiti')
            ->update([
                'name' => 'Dr. Thoko Phiri',
                'specialization' => 'Obstetrics & Gynaecology',
                'qualification' => 'MBBS, MMED Obstetrics & Gynaecology',
                'experience' => 'Years of experience: To be confirmed',
                'bio' => 'Dr. Phiri supports women with antenatal care, reproductive health guidance, family planning, and routine gynaecological reviews.',
                'languages' => json_encode(['English', 'Chichewa'], JSON_THROW_ON_ERROR),
                'image_path' => null,
                'status' => 'Active',
                'display_order' => 2,
                'updated_at' => now(),
            ]);
    }
};
