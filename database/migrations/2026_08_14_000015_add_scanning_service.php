<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $service = [
            'name' => 'Scanning',
            'description' => 'Diagnostic scanning support to help assess internal health concerns, monitor pregnancy, and guide next steps in care.',
            'image_path' => 'imgs/services/_MG_2068.jpg',
            'included_items' => [
                'Patient assessment before scanning',
                'Ultrasound scanning where clinically appropriate',
                'Findings explained by the clinic team',
                'Follow-up guidance or referral when needed',
            ],
            'needs_treated' => 'Pregnancy monitoring, abdominal or pelvic concerns, soft tissue checks, and other conditions where scanning can support diagnosis or follow-up care',
            'items_to_bring' => [
                'Health passport or clinic card if available',
                'Referral note or previous scan results if available',
                'Any preparation instructions already given by the clinic',
            ],
            'appointment_details' => 'Appointments are recommended for scanning so the clinic can confirm availability and share any preparation instructions before your visit.',
            'display_order' => 6,
        ];

        $existing = DB::table('services')
            ->where('name', $service['name'])
            ->first();

        $details = [
            'description' => $existing?->description ?: $service['description'],
            'image_path' => $service['image_path'],
            'included_items' => json_encode($service['included_items'], JSON_THROW_ON_ERROR),
            'needs_treated' => $service['needs_treated'],
            'items_to_bring' => json_encode($service['items_to_bring'], JSON_THROW_ON_ERROR),
            'appointment_details' => $service['appointment_details'],
            'display_order' => $service['display_order'],
            'updated_at' => now(),
        ];

        if ($existing) {
            DB::table('services')
                ->where('id', $existing->id)
                ->update($details);

            return;
        }

        DB::table('services')->insert($details + [
            'name' => $service['name'],
            'duration_minutes' => 30,
            'fee' => 0,
            'status' => 'Active',
            'created_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('services')
            ->where('name', 'Scanning')
            ->where('image_path', 'imgs/services/_MG_2068.jpg')
            ->delete();
    }
};
