<?php

use App\Models\Department;
use App\Models\Page;
use App\Models\Post;
use App\Services\Legacy\LegacyImporter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

/**
 * Stand up a throwaway in-memory "legacy" connection and seed it with rows
 * shaped the way the importer expects to read them.
 */
function seedLegacyDatabase(): void
{
    Config::set('database.connections.legacy', [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ]);

    // Drop any connection from a previous test so we get a fresh in-memory DB.
    DB::purge('legacy');

    $schema = DB::connection('legacy')->getSchemaBuilder();

    $schema->create('pages', function (Blueprint $table) {
        $table->integer('id');
        $table->string('title');
        $table->string('slug')->nullable();
        $table->text('content')->nullable();
        $table->string('published_at')->nullable();
    });

    $schema->create('departments', function (Blueprint $table) {
        $table->integer('id');
        $table->string('name');
        $table->string('slug')->nullable();
        $table->integer('sort_order')->nullable();
    });

    DB::connection('legacy')->table('pages')->insert([
        ['id' => 11, 'title' => 'About Us', 'slug' => 'about-us', 'content' => 'We are NPIUB.', 'published_at' => '2020-01-15 09:00:00'],
        // No slug supplied -> the model should generate one.
        ['id' => 12, 'title' => 'Our Mission', 'slug' => null, 'content' => 'Mission text.', 'published_at' => '0000-00-00 00:00:00'],
    ]);

    DB::connection('legacy')->table('departments')->insert([
        ['id' => 5, 'name' => 'Computer Science', 'slug' => 'cse', 'sort_order' => 3],
    ]);
}

/** @return list<array<string, mixed>> */
function legacyImportsFor(string ...$models): array
{
    /** @var list<array<string, mixed>> $imports */
    $imports = Config::get('legacy.imports', []);

    return array_values(array_filter(
        $imports,
        fn (array $map): bool => in_array($map['model'], $models, true),
    ));
}

beforeEach(function () {
    seedLegacyDatabase();
});

it('imports legacy rows keyed by legacy_id', function () {
    $importer = new LegacyImporter(app('db'), 'legacy', legacyImportsFor(Page::class, Department::class));

    $results = $importer->run();

    expect($results[Page::class])->toBe(2)
        ->and($results[Department::class])->toBe(1)
        ->and(Page::count())->toBe(2)
        ->and(Department::count())->toBe(1);

    $about = Page::where('legacy_id', 11)->firstOrFail();
    expect($about->title)->toBe('About Us')
        ->and($about->slug)->toBe('about-us')
        ->and($about->body)->toBe('We are NPIUB.')        // content -> body
        ->and($about->status->value)->toBe('published')   // applied default
        ->and($about->published_at->format('Y-m-d'))->toBe('2020-01-15');
});

it('generates a slug when the legacy row has none and nulls junk dates', function () {
    (new LegacyImporter(app('db'), 'legacy', legacyImportsFor(Page::class)))->run();

    $mission = Page::where('legacy_id', 12)->firstOrFail();

    expect($mission->slug)->toBe('our-mission')
        ->and($mission->published_at)->toBeNull(); // 0000-00-00 coerced to null
});

it('is idempotent: re-running updates in place instead of duplicating', function () {
    $importer = new LegacyImporter(app('db'), 'legacy', legacyImportsFor(Page::class));
    $importer->run();

    // Mutate a legacy row, then re-import.
    DB::connection('legacy')->table('pages')->where('id', 11)->update(['title' => 'About NPIUB']);
    $importer->run();

    expect(Page::count())->toBe(2)
        ->and(Page::where('legacy_id', 11)->value('title'))->toBe('About NPIUB');
});

it('skips legacy tables that do not exist without failing', function () {
    // Post/Notice/etc. tables were never created in the legacy DB.
    $importer = new LegacyImporter(app('db'), 'legacy', Config::get('legacy.imports', []));

    $results = $importer->run();

    expect($results[Post::class])->toBe(0)
        ->and($results[Page::class])->toBe(2);
});

it('does not write activity-log entries during import', function () {
    (new LegacyImporter(app('db'), 'legacy', legacyImportsFor(Page::class)))->run();

    expect(DB::table('activity_log')->count())->toBe(0);
});
