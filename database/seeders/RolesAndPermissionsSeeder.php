<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Permission set used across the admin panel. Content management is a
     * single coarse permission for now; sensitive areas are separated so
     * non-super-admins cannot reach them.
     */
    public const PERMISSIONS = [
        'manage_content',   // departments, people, notices, news, events, gallery, etc.
        'manage_users',     // staff accounts
        'manage_roles',     // roles & permissions
        'manage_settings',  // site settings, menus, sliders
        'view_submissions', // contact messages, admission inquiries
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $name) {
            Permission::findOrCreate($name, 'web');
        }

        $superAdmin = Role::findOrCreate('super_admin', 'web');
        $editor = Role::findOrCreate('editor', 'web');
        $departmentAdmin = Role::findOrCreate('department_admin', 'web');

        // super_admin is granted everything via Gate::before, but we still
        // attach the permissions for clarity in the UI.
        $superAdmin->syncPermissions(self::PERMISSIONS);

        $editor->syncPermissions(['manage_content', 'view_submissions', 'manage_settings']);

        $departmentAdmin->syncPermissions(['manage_content', 'view_submissions']);
    }
}
