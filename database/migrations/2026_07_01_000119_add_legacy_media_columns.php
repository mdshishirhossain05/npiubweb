<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The legacy database stored images/files as relative path strings.
     * We keep those paths so a later, file-aware media step can copy the
     * actual files into the media library — without re-querying legacy.
     */
    public function up(): void
    {
        Schema::table('people', fn (Blueprint $t) => $t->string('legacy_image')->nullable());
        Schema::table('alumni', fn (Blueprint $t) => $t->string('legacy_image')->nullable());
        Schema::table('gallery_images', fn (Blueprint $t) => $t->string('legacy_image')->nullable());
        Schema::table('notices', fn (Blueprint $t) => $t->string('legacy_file')->nullable());

        Schema::table('news', function (Blueprint $t) {
            $t->string('legacy_image')->nullable();
            $t->string('legacy_author_image')->nullable();
        });
        Schema::table('research', function (Blueprint $t) {
            $t->string('legacy_image')->nullable();
            $t->string('legacy_author_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('people', fn (Blueprint $t) => $t->dropColumn('legacy_image'));
        Schema::table('alumni', fn (Blueprint $t) => $t->dropColumn('legacy_image'));
        Schema::table('gallery_images', fn (Blueprint $t) => $t->dropColumn('legacy_image'));
        Schema::table('notices', fn (Blueprint $t) => $t->dropColumn('legacy_file'));
        Schema::table('news', fn (Blueprint $t) => $t->dropColumn(['legacy_image', 'legacy_author_image']));
        Schema::table('research', fn (Blueprint $t) => $t->dropColumn(['legacy_image', 'legacy_author_image']));
    }
};
