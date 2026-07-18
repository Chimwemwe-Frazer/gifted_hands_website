<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('preferred_at')->nullable()->after('practitioner_id');
            $table->text('request_message')->nullable()->after('preferred_at');
            $table->text('rejection_reason')->nullable()->after('appointment_at');
            $table->foreignId('reviewed_by')
                ->nullable()
                ->after('rejection_reason')
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');

            $table->index(['status', 'created_at'], 'appointments_status_created_at_index');
            $table->index(['status', 'appointment_at'], 'appointments_status_appointment_at_index');
        });

        DB::table('appointments')
            ->whereNull('request_message')
            ->whereNotNull('reason')
            ->update(['request_message' => DB::raw('reason')]);

        $legacyPendingStatuses = ['New request', 'Contacted'];

        DB::table('appointments')
            ->whereIn('status', $legacyPendingStatuses)
            ->whereNull('preferred_at')
            ->update(['preferred_at' => DB::raw('appointment_at')]);

        DB::table('appointments')
            ->whereIn('status', $legacyPendingStatuses)
            ->update([
                'appointment_at' => null,
                'status' => 'Pending',
            ]);

        DB::table('appointments')
            ->whereIn('status', ['Scheduled', 'Confirmed', 'Completed'])
            ->update(['status' => 'Approved']);

        DB::table('appointments')
            ->where('status', 'Cancelled')
            ->update([
                'status' => 'Rejected',
                'rejection_reason' => DB::raw(
                    "COALESCE(rejection_reason, 'This appointment request was previously cancelled by the clinic.')"
                ),
            ]);

        Schema::table('appointments', function (Blueprint $table) {
            $table->string('status')->default('Pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('status')->default('New request')->change();
            $table->dropIndex('appointments_status_created_at_index');
            $table->dropIndex('appointments_status_appointment_at_index');
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn([
                'preferred_at',
                'request_message',
                'rejection_reason',
                'reviewed_by',
                'reviewed_at',
            ]);
        });
    }
};
