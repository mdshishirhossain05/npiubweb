<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            // undergraduate | graduate | diploma | certificate
            $table->string('level')->default('undergraduate')->index();
            $table->string('duration')->nullable();
            $table->string('total_credits')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('curriculum')->nullable();
            $table->text('fees')->nullable();
            $table->unsignedSmallInteger('priority')->default(1)->index();
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
