<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(SiteSeeder::class);

        // Default super administrator. Override via env for real deployments;
        // the password MUST be changed after first login.
        $admin = User::updateOrCreate(
            ['email' => config('npiub.admin.email')],
            [
                'name' => config('npiub.admin.name'),
                'password' => Hash::make(config('npiub.admin.password')),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles(['super_admin']);
    }
}
