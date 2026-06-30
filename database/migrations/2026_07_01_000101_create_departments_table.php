<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_name')->nullable();
            // The original free-text department key (e.g. "cse") from the
            // legacy data, used by the importer to map rows onto departments.
            $table->string('legacy_key')->nullable()->index();
            $table->text('summary')->nullable();
            $table->longText('overview')->nullable();
            $table->unsignedSmallInteger('established_year')->nullable();
            $table->unsignedTinyInteger('priority')->default(1)->index();
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
