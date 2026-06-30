<?php

namespace App\Models\Concerns;

use App\Services\Legacy\LegacyImporter;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Opinionated wrapper around Spatie's {@see LogsActivity} so every audited
 * model shares one configuration: log the fillable attributes, only when they
 * actually changed, and never write an empty "nothing changed" entry.
 *
 * Bulk operations (notably the legacy importer) should disable logging around
 * their work rather than fighting this per-model — see
 * {@see LegacyImporter}.
 */
trait RecordsActivity
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
