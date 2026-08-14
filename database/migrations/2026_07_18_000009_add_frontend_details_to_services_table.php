<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
            $table->json('included_items')->nullable()->after('image_path');
            $table->text('needs_treated')->nullable()->after('included_items');
            $table->json('items_to_bring')->nullable()->after('needs_treated');
            $table->text('appointment_details')->nullable()->after('items_to_bring');
            $table->unsignedSmallInteger('display_order')->default(1)->after('appointment_details');
        });

        $services = [
            [
                'name' => 'General Consultation',
                'description' => 'Comprehensive medical assessment for everyday illness, new symptoms, ongoing concerns, and follow-up care.',
                'image_path' => 'imgs/services/_MG_2064.jpg',
                'included_items' => ['Clinical history and examination', 'Diagnosis and treatment plan', 'Prescriptions where appropriate', 'Referral guidance when specialist care is needed'],
                'needs_treated' => 'Fever, cough, headache, stomach pain, infections, fatigue, minor injuries, blood pressure concerns, and general wellness checks',
                'items_to_bring' => ['National ID or clinic card if available', 'Current medicines or prescriptions', 'Previous test results or referral notes'],
                'appointment_details' => 'Appointments are preferred so the clinic can prepare for your visit. Walk-ins may be assisted depending on daily availability.',
                'display_order' => 1,
            ],
            [
                'name' => 'Obstetrics & Gynaecology',
                'description' => 'Respectful women\'s health support, maternity care, reproductive health guidance, and routine gynaecological reviews.',
                'image_path' => 'imgs/services/obstetrics-gynaecology.png',
                'included_items' => ['Antenatal care and pregnancy reviews', 'Family planning counselling', 'Reproductive health consultations', 'Routine gynaecological assessment and follow-up'],
                'needs_treated' => 'Pregnancy care, menstrual concerns, pelvic discomfort, fertility questions, contraception needs, postnatal reviews, and women\'s wellness checks',
                'items_to_bring' => ['Health passport or antenatal records', 'Previous scan or laboratory results', 'Current medicines and any referral notes'],
                'appointment_details' => 'Appointments are strongly recommended for maternity and gynaecology visits so the clinic can confirm provider availability.',
                'display_order' => 2,
            ],
            [
                'name' => 'Under-5 Clinic',
                'description' => 'Child-focused care for infants and young children, including wellness checks, growth monitoring, and parent guidance.',
                'image_path' => 'imgs/services/under-5-clinic.png',
                'included_items' => ['Growth monitoring', 'Child wellness checks', 'Immunization support and guidance', 'Nutrition and caregiver counselling'],
                'needs_treated' => 'Routine child check-ups, feeding concerns, fever, cough, growth concerns, immunization questions, and follow-up reviews',
                'items_to_bring' => ['Child health passport', 'Immunization records', 'Any previous prescriptions or test results'],
                'appointment_details' => 'Appointments are preferred, especially for child wellness reviews. Walk-ins can call ahead to confirm availability.',
                'display_order' => 3,
            ],
            [
                'name' => 'Physiotherapy',
                'description' => 'Rehabilitation support to improve mobility, reduce pain, restore function, and guide recovery after injury or illness.',
                'image_path' => 'imgs/services/physiotherapy picture.jpeg',
                'included_items' => ['Movement and functional assessment', 'Personalized exercise guidance', 'Pain and mobility support', 'Recovery planning and progress reviews'],
                'needs_treated' => 'Back pain, joint pain, muscle strain, post-injury recovery, mobility limitations, weakness, and rehabilitation after medical events',
                'items_to_bring' => ['Referral notes if available', 'Previous scans or reports', 'Comfortable clothing for movement assessment'],
                'appointment_details' => 'Appointments are preferred so the physiotherapy team can plan enough time for assessment and guided exercises.',
                'display_order' => 4,
            ],
            [
                'name' => 'Laboratory Services',
                'description' => 'Diagnostic testing support for accurate assessment, treatment decisions, and follow-up care.',
                'image_path' => 'imgs/services/_MG_2134.jpg',
                'included_items' => ['Sample collection and handling', 'Common tests such as malaria screening, pregnancy testing, urinalysis, blood sugar checks, and other requested tests where available', 'Results support for clinical decision-making', 'Guidance on when results may be ready'],
                'needs_treated' => 'Routine tests, infection checks, pregnancy-related tests, follow-up monitoring, and tests requested during consultation',
                'items_to_bring' => ['Test request form if referred', 'Clinic notes or doctor request', 'Any preparation instructions already given, such as fasting guidance'],
                'appointment_details' => 'Sample collection is available during normal clinic hours. Turnaround time depends on the test type, so patients should ask the clinic team for expected timing.',
                'display_order' => 5,
            ],
        ];

        foreach ($services as $service) {
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

                continue;
            }

            DB::table('services')->insert($details + [
                'name' => $service['name'],
                'duration_minutes' => 30,
                'fee' => 0,
                'status' => 'Active',
                'created_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'image_path',
                'included_items',
                'needs_treated',
                'items_to_bring',
                'appointment_details',
                'display_order',
            ]);
        });
    }
};
