<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uploaded_images', function (Blueprint $table) {
            $table->id();
            $table->string('path')->unique();
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->mediumText('contents');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uploaded_images');
    }
};
