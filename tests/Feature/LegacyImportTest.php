<?php

use App\Models\Alumnus;
use App\Models\ContactMessage;
use App\Models\Department;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use App\Models\Notice;
use App\Models\Person;
use App\Models\Research;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

/*
 * Stand up a throwaway sqlite database shaped like the real legacy MySQL
 * schema, then seed representative rows (Bangla text, JSON columns, spam,
 * an empty table, shared department) and run the importer against it.
 */
beforeEach(function () {
    $path = sys_get_temp_dir().'/npiub_legacy_'.uniqid().'.sqlite';
    touch($path);
    $this->legacyPath = $path;

    config()->set('database.connections.legacy', [
        'driver' => 'sqlite',
        'database' => $path,
        'prefix' => '',
        'foreign_key_constraints' => false,
    ]);
    DB::purge('legacy');

    buildLegacySchema();
    seedLegacyData();
});

afterEach(function () {
    DB::purge('legacy');
    @unlink($this->legacyPath);
});

function buildLegacySchema(): void
{
    $s = Schema::connection('legacy');

    $s->create('faculties', function (Blueprint $t) {
        $t->id();
        $t->string('department')->default('all');
        $t->string('image')->nullable();
        $t->string('name');
        $t->string('position');
        $t->string('contact');
        $t->text('biography');
        $t->string('facebook')->nullable();
        $t->string('email');
        $t->string('linkedin')->nullable();
        $t->string('whatsapp')->nullable();
        $t->text('degrees')->nullable();
        $t->text('research_interests')->nullable();
        $t->string('slug');
        $t->integer('priority')->default(1);
        $t->timestamps();
    });

    $s->create('officers', function (Blueprint $t) {
        $t->id();
        $t->string('department')->default('all');
        $t->string('image')->nullable();
        $t->string('name');
        $t->string('position');
        $t->string('contact');
        $t->text('biography')->nullable();
        $t->string('email');
        $t->text('degrees')->nullable();
        $t->string('slug');
        $t->timestamps();
    });

    $s->create('offices', function (Blueprint $t) {
        $t->id();
        $t->string('name');
        $t->string('type');
        $t->integer('priority')->default(1);
        $t->string('position');
        $t->string('image')->nullable();
        $t->text('biography')->nullable();
        $t->text('degrees')->nullable();
        $t->text('research_interests')->nullable();
        $t->string('slug');
        $t->timestamps();
    });

    $s->create('alumni', function (Blueprint $t) {
        $t->id();
        $t->string('name');
        $t->string('department');
        $t->string('batch');
        $t->integer('graduation_year');
        $t->string('current_position')->nullable();
        $t->text('bio')->nullable();
        $t->string('image')->nullable();
        $t->string('email')->nullable();
        $t->string('slug');
        $t->timestamps();
    });

    $s->create('notices', function (Blueprint $t) {
        $t->id();
        $t->string('title');
        $t->string('slug');
        $t->text('description');
        $t->date('date');
        $t->string('published_by');
        $t->integer('views')->default(0);
        $t->string('file')->nullable();
        $t->string('category');
        $t->boolean('important')->default(false);
        $t->timestamps();
    });

    foreach (['news', 'research'] as $table) {
        $s->create($table, function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->text('content');
            $t->string('image');
            $t->string('author_name');
            $t->string('author_image');
            $t->string('author_info');
            $t->date('published_at');
            $t->string('category');
            $t->string('slug');
            $t->timestamps();
        });
    }

    $s->create('galleries', function (Blueprint $t) {
        $t->id();
        $t->string('title');
        $t->text('description')->nullable();
        $t->string('image')->nullable();
        $t->string('slug');
        $t->string('department')->default('all');
        $t->timestamps();
    });

    $s->create('contact_messages', function (Blueprint $t) {
        $t->id();
        $t->string('name');
        $t->string('email');
        $t->string('phone')->nullable();
        $t->text('message');
        $t->timestamp('read_at')->nullable();
        $t->timestamps();
    });

    $s->create('users', function (Blueprint $t) {
        $t->id();
        $t->string('name');
        $t->string('email');
        $t->string('password');
        $t->string('role')->default('user');
        $t->string('department')->default('all');
        $t->boolean('is_primary')->default(false);
        $t->timestamps();
    });
}

function seedLegacyData(): void
{
    $db = DB::connection('legacy');

    $db->table('faculties')->insert([
        ['id' => 1, 'department' => 'cse', 'name' => 'ড. রহিম উদ্দিন', 'position' => 'Professor', 'contact' => '01700', 'biography' => 'Bio', 'email' => 'rahim@npiub.edu.bd', 'degrees' => json_encode(['PhD', 'MSc']), 'research_interests' => json_encode(['AI', 'ML']), 'slug' => 'rahim-uddin', 'priority' => 1],
        ['id' => 2, 'department' => 'eee', 'name' => 'Karim Mia', 'position' => 'Lecturer', 'contact' => '01800', 'biography' => 'Bio2', 'email' => 'karim@npiub.edu.bd', 'degrees' => json_encode(['MSc']), 'research_interests' => null, 'slug' => 'karim-mia', 'priority' => 2],
    ]);

    $db->table('officers')->insert([
        ['id' => 1, 'department' => 'all', 'name' => 'Office Manager', 'position' => 'Manager', 'contact' => '019', 'email' => 'mgr@npiub.edu.bd', 'degrees' => null, 'slug' => 'office-manager'],
    ]);

    $db->table('offices')->insert([
        ['id' => 1, 'name' => 'Prof. Vice Chancellor', 'type' => 'Administration', 'priority' => 1, 'position' => 'Vice Chancellor', 'biography' => 'VC bio', 'degrees' => json_encode(['PhD']), 'research_interests' => null, 'slug' => 'vice-chancellor'],
    ]);

    $db->table('alumni')->insert([
        ['id' => 1, 'name' => 'Old Student', 'department' => 'cse', 'batch' => '2015', 'graduation_year' => 2019, 'current_position' => 'Engineer', 'bio' => 'bio', 'email' => 'alum@x.com', 'slug' => 'old-student'],
    ]);

    $db->table('notices')->insert([
        ['id' => 1, 'title' => 'Exam Notice', 'slug' => 'exam-notice', 'description' => 'desc', 'date' => '2025-01-10', 'published_by' => 'Registrar', 'views' => 5, 'file' => 'files/notice.pdf', 'category' => 'exam', 'important' => true],
    ]);

    $db->table('news')->insert([
        ['id' => 1, 'title' => 'Big News', 'content' => 'content', 'image' => 'images/news.jpg', 'author_name' => 'Admin', 'author_image' => 'images/a.jpg', 'author_info' => 'Staff', 'published_at' => '2025-02-01', 'category' => 'general', 'slug' => 'big-news'],
    ]);

    // research intentionally left EMPTY (mirrors production)

    $db->table('galleries')->insert([
        ['id' => 1, 'title' => 'Convocation 1', 'image' => 'images/g1.jpg', 'slug' => 'conv-1', 'department' => 'cse'],
        ['id' => 2, 'title' => 'Convocation 2', 'image' => 'images/g2.jpg', 'slug' => 'conv-2', 'department' => 'cse'],
    ]);

    $db->table('contact_messages')->insert([
        ['id' => 1, 'name' => 'Real Person', 'email' => 'real@x.com', 'phone' => '017', 'message' => 'I want admission info', 'read_at' => null],
        ['id' => 2, 'name' => 'Spammer', 'email' => 'spam@x.com', 'phone' => null, 'message' => 'cheap viagra http://a http://b http://c', 'read_at' => null],
    ]);

    $db->table('users')->insert([
        ['id' => 1, 'name' => 'Primary Admin', 'email' => 'admin@npiub.edu.bd', 'password' => Hash::make('secret123'), 'role' => 'admin', 'department' => 'all', 'is_primary' => true],
    ]);
}

it('imports all legacy entities into the new schema', function () {
    $this->artisan('migrate:legacy')->assertSuccessful();

    // People unified from 3 tables
    expect(Person::count())->toBe(4);
    expect(Person::faculty()->count())->toBe(2);
    expect(Person::where('type', Person::TYPE_LEADERSHIP)->first()->office_type)->toBe('Administration');

    // Departments resolved from free-text strings
    $cse = Department::where('slug', 'cse')->first();
    expect($cse)->not->toBeNull();
    expect(Person::where('slug', 'rahim-uddin')->first()->department_id)->toBe($cse->id);

    // JSON columns preserved as arrays
    expect(Person::where('slug', 'rahim-uddin')->first()->degrees)->toBe(['PhD', 'MSc']);

    // Bangla text preserved intact
    expect(Person::where('slug', 'rahim-uddin')->first()->name)->toBe('ড. রহিম উদ্দিন');

    // Alumni, notices
    expect(Alumnus::count())->toBe(1);
    expect(Notice::where('slug', 'exam-notice')->first()->is_important)->toBeTrue();
    expect(Notice::where('slug', 'exam-notice')->first()->legacy_file)->toBe('files/notice.pdf');

    // Galleries grouped into one album by department
    expect(GalleryAlbum::count())->toBe(1);
    expect(GalleryImage::count())->toBe(2);
    expect(GalleryAlbum::first()->images()->count())->toBe(2);

    // Spam detection
    expect(ContactMessage::where('email', 'spam@x.com')->first()->status)->toBe(ContactMessage::STATUS_SPAM);
    expect(ContactMessage::where('email', 'real@x.com')->first()->status)->toBe(ContactMessage::STATUS_NEW);
});

it('preserves the original password hash and maps roles', function () {
    $this->artisan('migrate:legacy')->assertSuccessful();

    $user = User::where('email', 'admin@npiub.edu.bd')->first();
    expect($user)->not->toBeNull();
    // Hash preserved verbatim — original password still verifies.
    expect(Hash::check('secret123', $user->password))->toBeTrue();
    // is_primary mapped to super_admin
    expect($user->hasRole('super_admin'))->toBeTrue();
});

it('is idempotent — running twice does not duplicate', function () {
    $this->artisan('migrate:legacy')->assertSuccessful();
    $firstPeople = Person::count();
    $firstAlbums = GalleryAlbum::count();

    $this->artisan('migrate:legacy')->assertSuccessful();

    expect(Person::count())->toBe($firstPeople);
    expect(GalleryAlbum::count())->toBe($firstAlbums);
    expect(GalleryImage::count())->toBe(2);
    expect(ContactMessage::count())->toBe(2);
});

it('handles the empty research table without error', function () {
    $this->artisan('migrate:legacy --only=research')->assertSuccessful();
    expect(Research::count())->toBe(0);
});
