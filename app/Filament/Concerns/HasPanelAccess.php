<?php

namespace App\Filament\Concerns;

/**
 * Gates an entire Filament resource behind a single Spatie permission.
 * super_admin bypasses all checks via the Gate::before rule in
 * AppServiceProvider, so this only constrains editors / department admins.
 */
trait HasPanelAccess
{
    public static function canAccess(): bool
    {
        return (bool) auth()->user()?->can(static::$accessPermission ?? 'manage_content');
    }
}
