<?php

return [

    /*
    | The legacy database stored "department" as a free-text string (default
    | "all"). These canonical departments are seeded first; legacy strings are
    | then matched against the slug or any alias to resolve a department_id.
    | Strings that match nothing are created as new departments on the fly so
    | no data is silently dropped. "all" / empty resolves to NULL (site-wide).
    */
    'departments' => [
        [
            'name' => 'Computer Science & Engineering',
            'slug' => 'cse',
            'short_name' => 'CSE',
            'aliases' => ['cse', 'computer science', 'computer science & engineering', 'computer science and engineering'],
        ],
        [
            'name' => 'Electrical & Electronic Engineering',
            'slug' => 'eee',
            'short_name' => 'EEE',
            'aliases' => ['eee', 'electrical', 'electrical & electronic engineering', 'electrical and electronic engineering'],
        ],
        [
            'name' => 'Food Engineering',
            'slug' => 'food-engineering',
            'short_name' => 'Food Engineering',
            'aliases' => ['food', 'food engineering', 'food-engineering', 'food_eng', 'food eng'],
        ],
        [
            'name' => 'Bachelor of Business Administration',
            'slug' => 'bba',
            'short_name' => 'BBA',
            'aliases' => ['bba', 'business administration', 'business'],
        ],
        [
            'name' => 'Master of Business Administration',
            'slug' => 'mba',
            'short_name' => 'MBA',
            'aliases' => ['mba'],
        ],
        [
            'name' => 'English',
            'slug' => 'english',
            'short_name' => 'English',
            'aliases' => ['english', 'department of english'],
        ],
    ],

    // Legacy "department" values that mean "not department specific" → NULL.
    'site_wide_values' => ['all', '', 'none', 'n/a', 'na'],

    /*
    | Map the legacy users.role string onto spatie roles created by the
    | importer. Unknown roles fall back to 'editor'.
    */
    'role_map' => [
        'admin' => 'super_admin',
        'super_admin' => 'super_admin',
        'editor' => 'editor',
        'user' => 'editor',
        'department' => 'department_admin',
        'department_admin' => 'department_admin',
    ],

    'roles' => ['super_admin', 'editor', 'department_admin'],
];
