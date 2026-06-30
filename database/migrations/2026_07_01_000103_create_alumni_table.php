<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            // Preserved as free text too, since legacy stored a raw department string.
            $table->string('department_label')->nullable();
            $table->string('batch')->nullable();
            $table->unsignedSmallInteger('graduation_year')->nullable();
            $table->string('current_position')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('whatsapp')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('legacy_id')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
