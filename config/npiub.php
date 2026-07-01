<?php

return [

    /*
    | Default super-administrator created by the database seeder. Override via
    | .env for real deployments and change the password after first login.
    */
    'admin' => [
        'name' => env('ADMIN_NAME', 'Site Administrator'),
        'email' => env('ADMIN_EMAIL', 'admin@npiub.edu.bd'),
        'password' => env('ADMIN_PASSWORD', 'password'),
    ],

];
