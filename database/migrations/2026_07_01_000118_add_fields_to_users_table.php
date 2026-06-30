<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds department scoping + activation to users. Roles themselves are
     * handled by spatie/laravel-permission; the legacy `role` string is
     * mapped onto spatie roles by the importer.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->after('email')->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('department_id');
            $table->unsignedBigInteger('legacy_id')->nullable()->unique()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
            $table->dropColumn(['is_active', 'legacy_id']);
        });
    }
};
