<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Creates (or updates) the initial admin account used to sign in to the
 * Filament panel at /admin.
 *
 * Credentials come from ADMIN_* env vars so real passwords never live in the
 * repository; the defaults are for local development only. The seeder is
 * idempotent — keyed on the email, re-running just refreshes the record.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = (string) config('admin.email');
        $name = (string) config('admin.name');
        $password = (string) config('admin.password');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ],
        );
    }
}
