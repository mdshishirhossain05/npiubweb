<?php

namespace App\Support\Legacy;

use App\Models\Department;
use Illuminate\Support\Str;

/**
 * Resolves legacy free-text "department" strings to Department records,
 * seeding canonical departments and creating unknown ones on the fly so
 * that no legacy association is ever silently dropped.
 */
class DepartmentResolver
{
    /** @var array<string,int> normalized alias/slug => department id */
    private array $lookup = [];

    private bool $seeded = false;

    public function seed(): void
    {
        if ($this->seeded) {
            return;
        }

        foreach (config('legacy.departments', []) as $index => $def) {
            $department = Department::firstOrCreate(
                ['slug' => $def['slug']],
                [
                    'name' => $def['name'],
                    'short_name' => $def['short_name'] ?? null,
                    'legacy_key' => $def['slug'],
                    'priority' => $index + 1,
                ]
            );

            $this->index($department->id, array_merge(
                [$def['slug'], $def['name'], $def['short_name'] ?? ''],
                $def['aliases'] ?? []
            ));
        }

        $this->seeded = true;
    }

    /**
     * Resolve a legacy department string to a department id, or null for
     * site-wide values. Unknown non-empty strings create a new department.
     */
    public function resolve(?string $legacyValue): ?int
    {
        $this->seed();

        $normalized = $this->normalize($legacyValue);

        if ($normalized === '' || in_array($normalized, config('legacy.site_wide_values', ['all']), true)) {
            return null;
        }

        if (isset($this->lookup[$normalized])) {
            return $this->lookup[$normalized];
        }

        // Unknown department: create it rather than drop the association.
        $name = Str::title(str_replace(['-', '_'], ' ', trim((string) $legacyValue)));
        $department = Department::firstOrCreate(
            ['slug' => Str::slug($name) ?: Str::slug($normalized)],
            ['name' => $name, 'legacy_key' => $normalized, 'priority' => 99]
        );

        $this->index($department->id, [$normalized, $department->slug, $name]);

        return $department->id;
    }

    private function index(int $departmentId, array $keys): void
    {
        foreach ($keys as $key) {
            $normalized = $this->normalize($key);
            if ($normalized !== '') {
                $this->lookup[$normalized] = $departmentId;
            }
        }
    }

    private function normalize(?string $value): string
    {
        return Str::lower(trim((string) $value));
    }
}
