<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category', 80);
            $table->string('title');
            $table->text('message');
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_position', 10)->default('left');
            $table->string('status', 20)->default('Draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });

        $now = now();

        DB::table('announcements')->insert([
            [
                'category' => 'Clinic hours',
                'title' => 'Weekend Schedule Update',
                'message' => 'Saturday services are available from 08:00 AM to 01:00 PM. Please call ahead for availability.',
                'image_position' => 'left',
                'status' => 'Published',
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'Services',
                'title' => 'Laboratory Services Available',
                'message' => 'Reliable diagnostic and laboratory testing services are available during normal clinic hours.',
                'image_position' => 'left',
                'status' => 'Published',
                'published_at' => $now->copy()->subMinute(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'Appointments',
                'title' => 'Book Before Your Visit',
                'message' => 'Visitors are encouraged to request appointments in advance so the team can confirm service availability.',
                'image_position' => 'left',
                'status' => 'Published',
                'published_at' => $now->copy()->subMinutes(2),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'Under-5 Clinic',
                'title' => 'Child Wellness Services',
                'message' => 'Growth monitoring, immunizations, and routine child wellness checks are available for young children.',
                'image_position' => 'left',
                'status' => 'Published',
                'published_at' => $now->copy()->subMinutes(3),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'Women\'s Health',
                'title' => 'Obstetrics & Gynaecology Care',
                'message' => 'Pregnancy care, reproductive health, and family planning support are available at the clinic.',
                'image_position' => 'left',
                'status' => 'Published',
                'published_at' => $now->copy()->subMinutes(4),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
