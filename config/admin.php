<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Initial admin account
    |--------------------------------------------------------------------------
    |
    | Credentials used by AdminUserSeeder to create the first user that can
    | sign in to the Filament panel at /admin. Real values come from the
    | ADMIN_* env vars so secrets stay out of the repository; the defaults
    | below are for local development only.
    |
    */

    'name' => env('ADMIN_NAME', 'NPIUB Administrator'),

    'email' => env('ADMIN_EMAIL', 'admin@npiub.edu.bd'),

    'password' => env('ADMIN_PASSWORD', 'password'),

];
