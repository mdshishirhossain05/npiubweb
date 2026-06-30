<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Unified directory of people. Replaces the legacy `faculties`,
     * `officers`, and `offices` tables, distinguished by `type`.
     */
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            // faculty | officer | leadership
            $table->string('type')->default('faculty')->index();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('position');
            // For legacy "offices" (e.g. Vice-Chancellor's Office category).
            $table->string('office_type')->nullable();
            $table->longText('biography')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('whatsapp')->nullable();
            $table->json('degrees')->nullable();
            $table->json('research_interests')->nullable();
            $table->unsignedSmallInteger('priority')->default(1)->index();
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            // Idempotency anchor for the legacy importer.
            $table->string('legacy_table')->nullable();
            $table->unsignedBigInteger('legacy_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['legacy_table', 'legacy_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
