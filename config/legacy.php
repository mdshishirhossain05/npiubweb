<?php

use App\Models\Category;
use App\Models\Department;
use App\Models\Event;
use App\Models\FacultyMember;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Post;
use App\Models\Program;
use App\Models\Slide;

return [

    /*
    |--------------------------------------------------------------------------
    | Legacy connection
    |--------------------------------------------------------------------------
    |
    | The (read-only) database connection the importer reads from. It is
    | defined in config/database.php and wired from the LEGACY_DB_* env vars.
    | The legacy database is preserved untouched as the rollback of record.
    |
    */

    'connection' => env('LEGACY_DB_CONNECTION', 'legacy'),

    /*
    |--------------------------------------------------------------------------
    | Import map
    |--------------------------------------------------------------------------
    |
    | A purely declarative description of how legacy tables map onto the new
    | models — deliberately closure-free so the file survives `config:cache`
    | on the production server.
    |
    | Each entry:
    |   model    => target Eloquent model (must expose a `legacy_id` column)
    |   table    => legacy table name
    |   key      => legacy primary key, stored as `legacy_id` for idempotency
    |   columns  => [ 'legacy_column' => 'new_attribute' ]
    |   dates    => new attributes to coerce through Carbon (junk dates -> null)
    |   defaults => attributes always applied (e.g. a default status)
    |
    | The legacy column names below are best-effort guesses against a typical
    | CMS dump; adjust them once the real legacy schema is in front of you.
    | Tables that do not exist in a given dump are skipped, not fatal, so it is
    | safe to leave entries here that a particular database does not contain.
    |
    */

    'imports' => [

        [
            'model' => Category::class,
            'table' => 'categories',
            'key' => 'id',
            'columns' => [
                'name' => 'name',
                'slug' => 'slug',
                'type' => 'type',
                'description' => 'description',
            ],
        ],

        [
            'model' => Page::class,
            'table' => 'pages',
            'key' => 'id',
            'columns' => [
                'title' => 'title',
                'slug' => 'slug',
                'excerpt' => 'excerpt',
                'content' => 'body',
                'meta_title' => 'meta_title',
                'meta_description' => 'meta_description',
                'published_at' => 'published_at',
            ],
            'dates' => ['published_at'],
            'defaults' => ['status' => 'published'],
        ],

        [
            'model' => Post::class,
            'table' => 'posts',
            'key' => 'id',
            'columns' => [
                'category_id' => 'legacy_category_ref',
                'title' => 'title',
                'slug' => 'slug',
                'excerpt' => 'excerpt',
                'content' => 'body',
                'meta_title' => 'meta_title',
                'meta_description' => 'meta_description',
                'published_at' => 'published_at',
            ],
            'dates' => ['published_at'],
            'defaults' => ['status' => 'published'],
        ],

        [
            'model' => Notice::class,
            'table' => 'notices',
            'key' => 'id',
            'columns' => [
                'title' => 'title',
                'slug' => 'slug',
                'body' => 'body',
                'notice_date' => 'notice_date',
                'published_at' => 'published_at',
            ],
            'dates' => ['notice_date', 'published_at'],
            'defaults' => ['status' => 'published'],
        ],

        [
            'model' => Event::class,
            'table' => 'events',
            'key' => 'id',
            'columns' => [
                'title' => 'title',
                'slug' => 'slug',
                'description' => 'description',
                'starts_at' => 'starts_at',
                'ends_at' => 'ends_at',
                'location' => 'location',
                'published_at' => 'published_at',
            ],
            'dates' => ['starts_at', 'ends_at', 'published_at'],
            'defaults' => ['status' => 'published'],
        ],

        [
            'model' => Department::class,
            'table' => 'departments',
            'key' => 'id',
            'columns' => [
                'name' => 'name',
                'slug' => 'slug',
                'short_name' => 'short_name',
                'description' => 'description',
                'sort_order' => 'sort_order',
            ],
        ],

        [
            'model' => Program::class,
            'table' => 'programs',
            'key' => 'id',
            'columns' => [
                'name' => 'name',
                'slug' => 'slug',
                'level' => 'level',
                'duration' => 'duration',
                'description' => 'description',
                'sort_order' => 'sort_order',
            ],
        ],

        [
            'model' => FacultyMember::class,
            'table' => 'faculty_members',
            'key' => 'id',
            'columns' => [
                'name' => 'name',
                'slug' => 'slug',
                'designation' => 'designation',
                'email' => 'email',
                'phone' => 'phone',
                'bio' => 'bio',
                'sort_order' => 'sort_order',
            ],
        ],

        [
            'model' => Slide::class,
            'table' => 'slides',
            'key' => 'id',
            'columns' => [
                'title' => 'title',
                'subtitle' => 'subtitle',
                'link_url' => 'link_url',
                'sort_order' => 'sort_order',
                'is_active' => 'is_active',
            ],
        ],

    ],

];
