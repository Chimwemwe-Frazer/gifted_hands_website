<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('specialization');
            $table->text('qualification');
            $table->string('experience');
            $table->text('bio');
            $table->json('languages')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('Active');
            $table->unsignedSmallInteger('display_order')->default(1);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question', 500)->unique();
            $table->text('brief_answer');
            $table->text('full_answer');
            $table->boolean('show_on_home')->default(false);
            $table->string('status')->default('Active');
            $table->unsignedSmallInteger('display_order')->default(1);
            $table->timestamps();
        });

        $now = now();

        DB::table('doctors')->insert([
            [
                'name' => 'Dr. Mercy Banda',
                'specialization' => 'General Practitioner',
                'qualification' => 'MBBS, Diploma in Family Medicine',
                'experience' => 'Years of experience: To be confirmed',
                'bio' => 'Dr. Banda provides first-contact care for patients with everyday health concerns, routine reviews, and ongoing follow-up needs.',
                'languages' => json_encode(['English', 'Chichewa'], JSON_THROW_ON_ERROR),
                'image_path' => 'imgs/doctors/mercy-banda.png',
                'status' => 'Active',
                'display_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Dr Allan Faiti',
                'specialization' => 'Clinical Associate Obstetrics and Gynaecology',
                'qualification' => 'Clinical Associate Obstetrics and Gynaecology',
                'experience' => 'Years of experience: To be confirmed',
                'bio' => 'Clinical Associate Obstetrics and Gynaecology.',
                'languages' => json_encode(['English', 'Chichewa'], JSON_THROW_ON_ERROR),
                'image_path' => 'imgs/doctors/thoko-phiri.png',
                'status' => 'Active',
                'display_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Dr. Daniel Kamanga',
                'specialization' => 'Physiotherapy & Rehabilitation',
                'qualification' => 'BSc Physiotherapy, Certified Rehabilitation Specialist',
                'experience' => 'Years of experience: To be confirmed',
                'bio' => 'Dr. Kamanga helps patients improve movement, manage pain, and recover strength through practical rehabilitation plans.',
                'languages' => json_encode(['English', 'Chichewa', 'Tumbuka'], JSON_THROW_ON_ERROR),
                'image_path' => 'imgs/doctors/daniel-kamanga.png',
                'status' => 'Active',
                'display_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('faqs')->insert([
            [
                'question' => 'Do I need an appointment?',
                'brief_answer' => 'Appointments are recommended before visiting.',
                'full_answer' => 'Appointments are recommended so the clinic can confirm the right service, provider availability, and the best time for your visit. You can request an appointment through the website or call the clinic before coming.',
                'show_on_home' => true,
                'status' => 'Active',
                'display_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'How does the appointment process work?',
                'brief_answer' => 'Submit a request and wait for clinic confirmation.',
                'full_answer' => 'Send an appointment request with your name, contact details, preferred service, and preferred visit time. The clinic team will review the request and contact you to confirm availability. For same-day or urgent visits, calling before visiting is the best option.',
                'show_on_home' => false,
                'status' => 'Active',
                'display_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Can I walk in without booking?',
                'brief_answer' => 'Walk-ins may be assisted depending on availability.',
                'full_answer' => 'Walk-in patients may be assisted depending on the day, clinic schedule, and patient volume. Booking or calling first is recommended, especially for Obstetrics and Gynae, Under-5 Clinic, Diet and Nutrition, and Physiotherapy services.',
                'show_on_home' => false,
                'status' => 'Active',
                'display_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'How are lab results collected?',
                'brief_answer' => 'The clinic will advise when and how results are ready.',
                'full_answer' => 'After sample collection or testing, the clinic team will advise when results are expected and how they can be collected. Some results may require review by a clinician so the findings can be explained and the next step can be discussed.',
                'show_on_home' => false,
                'status' => 'Active',
                'display_order' => 9,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Is my information private and confidential?',
                'brief_answer' => 'Yes, patient information is handled confidentially.',
                'full_answer' => 'Patient consultations, personal details, and medical information are handled with confidentiality. Information is used for patient care and clinic administration, and sensitive details should only be shared with authorized clinic staff.',
                'show_on_home' => false,
                'status' => 'Active',
                'display_order' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Where is the clinic located?',
                'brief_answer' => 'Gifted Hands Private Clinic is on Barron Avenue, Lilongwe.',
                'full_answer' => 'The clinic is located on Barron Avenue in Lilongwe. If you are unsure of the exact entrance, parking point, or nearby landmark, call the clinic before travelling so the team can guide you using the most current directions.',
                'show_on_home' => false,
                'status' => 'Active',
                'display_order' => 11,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Can I request a specific service?',
                'brief_answer' => 'Yes. Select a service in the booking form and the appointments officer will follow up.',
                'full_answer' => 'Yes. Select or mention the service you need when requesting an appointment, such as General Clinic, Obs and Gynae, Under-5 Clinic, Diet and Nutrition, Physiotherapy, or Laboratory Services. The clinic team will follow up based on availability.',
                'show_on_home' => true,
                'status' => 'Active',
                'display_order' => 12,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question' => 'Is ambulance support available?',
                'brief_answer' => 'Contact the clinic directly for urgent arrangements.',
                'full_answer' => 'The clinic advertises ambulance availability. For urgent arrangements, contact the clinic directly by phone so the team can advise what support is available and what immediate steps to take.',
                'show_on_home' => false,
                'status' => 'Active',
                'display_order' => 13,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('doctors');
    }
};
