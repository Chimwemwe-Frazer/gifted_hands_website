<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('appointments')) {
            return;
        }

        Schema::table('appointments', function (Blueprint $table) {
            if (! Schema::hasColumn('appointments', 'client_name')) {
                $table->string('client_name')->default('Appointment request')->after('id');
            }

            if (! Schema::hasColumn('appointments', 'client_phone')) {
                $table->string('client_phone')->nullable()->after('client_name');
            }

            if (! Schema::hasColumn('appointments', 'client_email')) {
                $table->string('client_email')->nullable()->after('client_phone');
            }
        });

        if (
            Schema::hasColumn('appointments', 'appointment_at')
            && DB::getDriverName() === 'mysql'
        ) {
            DB::statement('ALTER TABLE appointments MODIFY appointment_at DATETIME NULL');
        }

        if (Schema::hasColumn('appointments', 'patient_id')) {
            try {
                Schema::table('appointments', function (Blueprint $table) {
                    $table->dropForeign(['patient_id']);
                });
            } catch (Throwable) {
                //
            }

            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('patient_id');
            });
        }

        Schema::dropIfExists('patients');
    }

    public function down(): void
    {
        //
    }
};
