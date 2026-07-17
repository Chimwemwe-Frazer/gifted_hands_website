<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('announcements')) {
            return;
        }

        DB::table('announcements')->update([
            'published_at' => DB::raw('COALESCE(created_at, CURRENT_TIMESTAMP)'),
        ]);

        $hadStatusColumn = Schema::hasColumn('announcements', 'status');

        if ($hadStatusColumn) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->dropIndex(['status', 'published_at']);
            });
        }

        $columns = collect(['image_alt', 'image_position', 'status'])
            ->filter(fn (string $column): bool => Schema::hasColumn('announcements', $column))
            ->values()
            ->all();

        if ($columns !== []) {
            Schema::table('announcements', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }

        if ($hadStatusColumn) {
            Schema::table('announcements', function (Blueprint $table) {
                $table->index('published_at');
            });
        }
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
            $table->string('image_alt')->nullable();
            $table->string('image_position', 10)->default('left');
            $table->string('status', 20)->default('Published');
            $table->index(['status', 'published_at']);
        });
    }
};
