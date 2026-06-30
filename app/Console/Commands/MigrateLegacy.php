<?php

namespace App\Console\Commands;

use App\Models\Alumnus;
use App\Models\ContactMessage;
use App\Models\Department;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use App\Models\News;
use App\Models\Notice;
use App\Models\Person;
use App\Models\Research;
use App\Models\User;
use App\Support\Legacy\DepartmentResolver;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Throwable;

class MigrateLegacy extends Command
{
    protected $signature = 'migrate:legacy
        {--only=* : Limit to specific entities (departments,people,alumni,notices,news,research,galleries,contact_messages,users)}
        {--report : Only print the reconciliation report; do not import}';

    protected $description = 'Idempotently import data from the legacy database (read-only) into the new schema.';

    private DepartmentResolver $departments;

    /** @var array<string,array{legacy:int,new:int}> */
    private array $stats = [];

    private const ENTITIES = [
        'departments', 'people', 'alumni', 'notices',
        'news', 'research', 'galleries', 'contact_messages', 'users',
    ];

    public function handle(DepartmentResolver $departments): int
    {
        $this->departments = $departments;

        if (! $this->legacyReachable()) {
            $this->error('Legacy database connection is not configured/reachable. Set LEGACY_DB_* in .env.');

            return self::FAILURE;
        }

        $only = $this->option('only') ?: self::ENTITIES;
        $report = (bool) $this->option('report');

        $this->info($report ? 'Reconciliation report (no import):' : 'Importing from legacy database...');

        foreach (self::ENTITIES as $entity) {
            if (! in_array($entity, $only, true)) {
                continue;
            }

            if (! $report) {
                $method = 'import'.Str::studly($entity);
                $this->line("→ {$entity}");
                $this->{$method}();
            }
        }

        $this->renderReport($only);

        return self::SUCCESS;
    }

    /* ------------------------------------------------------------------ */
    /* Entity importers (each transaction-wrapped + idempotent) */
    /* ------------------------------------------------------------------ */

    private function importDepartments(): void
    {
        DB::transaction(fn () => $this->departments->seed());
    }

    private function importPeople(): void
    {
        DB::transaction(function () {
            // faculty
            foreach ($this->legacy('faculties') as $row) {
                $this->upsertPerson($row, Person::TYPE_FACULTY, [
                    'department_id' => $this->departments->resolve($row->department ?? null),
                    'research_interests' => $this->json($row->research_interests ?? null),
                    'priority' => $row->priority ?? 1,
                ]);
            }
            // officers
            foreach ($this->legacy('officers') as $row) {
                $this->upsertPerson($row, Person::TYPE_OFFICER, [
                    'department_id' => $this->departments->resolve($row->department ?? null),
                ]);
            }
            // offices (leadership) — no department column, but has a "type"
            foreach ($this->legacy('offices') as $row) {
                $this->upsertPerson($row, Person::TYPE_LEADERSHIP, [
                    'office_type' => $row->type ?? null,
                    'research_interests' => $this->json($row->research_interests ?? null),
                    'priority' => $row->priority ?? 1,
                ]);
            }
        });
    }

    private function upsertPerson(object $row, string $type, array $extra): void
    {
        $attributes = array_merge([
            'name' => $row->name,
            'position' => $row->position ?? '',
            'biography' => $row->biography ?? null,
            'contact' => $row->contact ?? null,
            'email' => $row->email ?? null,
            'facebook' => $row->facebook ?? null,
            'linkedin' => $row->linkedin ?? null,
            'whatsapp' => $row->whatsapp ?? null,
            'degrees' => $this->json($row->degrees ?? null),
            'type' => $type,
            'legacy_image' => $row->image ?? null,
            'slug' => $this->uniqueSlug(Person::class, $row->slug ?? $row->name, ['legacy_table' => $type === Person::TYPE_FACULTY ? 'faculties' : ($type === Person::TYPE_OFFICER ? 'officers' : 'offices'), 'legacy_id' => $row->id]),
            'created_at' => $row->created_at ?? now(),
            'updated_at' => $row->updated_at ?? now(),
        ], $extra);

        $legacyTable = $type === Person::TYPE_FACULTY ? 'faculties'
            : ($type === Person::TYPE_OFFICER ? 'officers' : 'offices');

        Person::updateOrCreate(
            ['legacy_table' => $legacyTable, 'legacy_id' => $row->id],
            $attributes
        );

        $this->bump('people');
    }

    private function importAlumni(): void
    {
        DB::transaction(function () {
            foreach ($this->legacy('alumni') as $row) {
                Alumnus::updateOrCreate(
                    ['legacy_id' => $row->id],
                    [
                        'name' => $row->name,
                        'department_label' => $row->department ?? null,
                        'department_id' => $this->departments->resolve($row->department ?? null),
                        'batch' => $row->batch ?? null,
                        'graduation_year' => $row->graduation_year ?? null,
                        'current_position' => $row->current_position ?? null,
                        'bio' => $row->bio ?? null,
                        'email' => $row->email ?? null,
                        'facebook' => $row->facebook ?? null,
                        'linkedin' => $row->linkedin ?? null,
                        'whatsapp' => $row->whatsapp ?? null,
                        'legacy_image' => $row->image ?? null,
                        'slug' => $this->uniqueSlug(Alumnus::class, $row->slug ?? $row->name, ['legacy_id' => $row->id]),
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => $row->updated_at ?? now(),
                    ]
                );
                $this->bump('alumni');
            }
        });
    }

    private function importNotices(): void
    {
        DB::transaction(function () {
            foreach ($this->legacy('notices') as $row) {
                Notice::updateOrCreate(
                    ['legacy_id' => $row->id],
                    [
                        'title' => $row->title,
                        'description' => $row->description ?? '',
                        'category' => $row->category ?? 'general',
                        'notice_date' => $row->date ?? now()->toDateString(),
                        'published_by' => $row->published_by ?? null,
                        'views' => $row->views ?? 0,
                        'is_important' => (bool) ($row->important ?? false),
                        'status' => 'published',
                        'legacy_file' => $row->file ?? null,
                        'slug' => $this->uniqueSlug(Notice::class, $row->slug ?? $row->title, ['legacy_id' => $row->id]),
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => $row->updated_at ?? now(),
                    ]
                );
                $this->bump('notices');
            }
        });
    }

    private function importNews(): void
    {
        DB::transaction(function () {
            foreach ($this->legacy('news') as $row) {
                News::updateOrCreate(
                    ['legacy_id' => $row->id],
                    $this->articleAttributes($row, News::class)
                );
                $this->bump('news');
            }
        });
    }

    private function importResearch(): void
    {
        DB::transaction(function () {
            foreach ($this->legacy('research') as $row) {
                Research::updateOrCreate(
                    ['legacy_id' => $row->id],
                    $this->articleAttributes($row, Research::class)
                );
                $this->bump('research');
            }
        });
    }

    /** Shared shape for news/research (identical legacy schema). */
    private function articleAttributes(object $row, string $modelClass): array
    {
        return [
            'title' => $row->title,
            'content' => $row->content ?? '',
            'author_name' => $row->author_name ?? null,
            'author_info' => $row->author_info ?? null,
            'category' => $row->category ?? 'general',
            'published_at' => $row->published_at ?? now()->toDateString(),
            'status' => 'published',
            'legacy_image' => $row->image ?? null,
            'legacy_author_image' => $row->author_image ?? null,
            'slug' => $this->uniqueSlug($modelClass, $row->slug ?? $row->title, ['legacy_id' => $row->id]),
            'created_at' => $row->created_at ?? now(),
            'updated_at' => $row->updated_at ?? now(),
        ];
    }

    private function importGalleries(): void
    {
        DB::transaction(function () {
            foreach ($this->legacy('galleries') as $row) {
                $album = $this->resolveAlbum($row->department ?? 'all');

                GalleryImage::updateOrCreate(
                    ['legacy_id' => $row->id],
                    [
                        'gallery_album_id' => $album->id,
                        'title' => $row->title ?? null,
                        'description' => $row->description ?? null,
                        'legacy_image' => $row->image ?? null,
                        'sort_order' => $row->id ?? 0,
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => $row->updated_at ?? now(),
                    ]
                );
                $this->bump('galleries');
            }
        });
    }

    private function resolveAlbum(string $legacyDepartment): GalleryAlbum
    {
        $departmentId = $this->departments->resolve($legacyDepartment);
        $title = $departmentId
            ? Department::find($departmentId)->name.' Gallery'
            : 'General Gallery';
        $key = Str::lower(trim($legacyDepartment)) ?: 'all';

        return GalleryAlbum::firstOrCreate(
            ['legacy_key' => $key],
            [
                'title' => $title,
                'slug' => $this->uniqueSlug(GalleryAlbum::class, $title, ['legacy_key' => $key]),
                'department_id' => $departmentId,
            ]
        );
    }

    private function importContactMessages(): void
    {
        DB::transaction(function () {
            foreach ($this->legacy('contact_messages') as $row) {
                $status = $this->isSpam($row)
                    ? ContactMessage::STATUS_SPAM
                    : (($row->read_at ?? null) ? ContactMessage::STATUS_READ : ContactMessage::STATUS_NEW);

                ContactMessage::updateOrCreate(
                    ['legacy_id' => $row->id],
                    [
                        'name' => $row->name,
                        'email' => $row->email,
                        'phone' => $row->phone ?? null,
                        'message' => $row->message ?? '',
                        'status' => $status,
                        'read_at' => $row->read_at ?? null,
                        'created_at' => $row->created_at ?? now(),
                        'updated_at' => $row->updated_at ?? now(),
                    ]
                );
                $this->bump('contact_messages');
            }
        });
    }

    private function importUsers(): void
    {
        DB::transaction(function () {
            foreach (config('legacy.roles', []) as $role) {
                Role::findOrCreate($role, 'web');
            }

            foreach ($this->legacy('users') as $row) {
                $user = User::firstOrNew(['legacy_id' => $row->id]);

                $user->fill([
                    'name' => $row->name,
                    'email' => $row->email,
                    'department_id' => $this->departments->resolve($row->department ?? null),
                    'is_active' => true,
                ]);
                // legacy_id is guarded, so assign it explicitly (the upsert anchor).
                $user->legacy_id = $row->id;
                $user->email_verified_at = $row->email_verified_at ?? now();
                // Preserve the existing bcrypt hash verbatim (no re-hashing).
                $user->setRawAttributes(array_merge($user->getAttributes(), [
                    'password' => $row->password,
                ]));
                $user->save();

                $role = config('legacy.role_map')[Str::lower($row->role ?? 'user')] ?? 'editor';
                if (($row->is_primary ?? false)) {
                    $role = 'super_admin';
                }
                $user->syncRoles([$role]);

                $this->bump('users');
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /* Helpers */
    /* ------------------------------------------------------------------ */

    private function legacyReachable(): bool
    {
        try {
            DB::connection('legacy')->getPdo();

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    /** @return iterable<int, object> */
    private function legacy(string $table)
    {
        if (! Schema::connection('legacy')->hasTable($table)) {
            return collect();
        }

        return DB::connection('legacy')->table($table)->get();
    }

    private function json(?string $value): ?array
    {
        if (blank($value)) {
            return null;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Generate a slug unique against existing rows, ignoring the row we are
     * upserting (matched by its legacy key columns).
     */
    private function uniqueSlug(string $modelClass, string $source, array $ignoreKeys): string
    {
        $base = Str::slug($source) ?: 'item';
        /** @var Model $model */
        $model = new $modelClass;
        $table = $model->getTable();

        // A row conflicts if its slug matches and it is NOT the row we are
        // upserting (identified by all of $ignoreKeys being equal).
        $conflicts = fn (string $slug) => DB::table($table)
            ->where('slug', $slug)
            ->where(function ($q) use ($ignoreKeys) {
                foreach ($ignoreKeys as $col => $val) {
                    $q->orWhere($col, '!=', $val)->orWhereNull($col);
                }
            })
            ->exists();

        $slug = $base;
        $i = 2;
        while ($conflicts($slug)) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function isSpam(object $row): bool
    {
        $message = Str::lower((string) ($row->message ?? ''));
        $linkCount = substr_count($message, 'http');
        $keywords = ['viagra', 'casino', 'crypto', 'loan', 'seo service', 'backlink', 'bitcoin'];

        if ($linkCount >= 3) {
            return true;
        }

        foreach ($keywords as $kw) {
            if (str_contains($message, $kw)) {
                return true;
            }
        }

        return false;
    }

    private function bump(string $entity): void
    {
        $this->stats[$entity]['new'] = ($this->stats[$entity]['new'] ?? 0) + 1;
    }

    private function renderReport(array $only): void
    {
        $map = [
            'people' => ['faculties', 'officers', 'offices'],
            'alumni' => ['alumni'],
            'notices' => ['notices'],
            'news' => ['news'],
            'research' => ['research'],
            'galleries' => ['galleries'],
            'contact_messages' => ['contact_messages'],
            'users' => ['users'],
        ];

        $rows = [];
        foreach ($map as $entity => $legacyTables) {
            if (! in_array($entity, $only, true)) {
                continue;
            }

            $legacyCount = 0;
            foreach ($legacyTables as $t) {
                $legacyCount += Schema::connection('legacy')->hasTable($t)
                    ? DB::connection('legacy')->table($t)->count()
                    : 0;
            }

            $newCount = $this->newCount($entity);
            $match = $legacyCount === $newCount ? '✓' : '⚠';
            $rows[] = [$entity, $legacyCount, $newCount, $match];
        }

        $this->newLine();
        $this->table(['Entity', 'Legacy rows', 'New rows', 'Match'], $rows);
    }

    private function newCount(string $entity): int
    {
        return match ($entity) {
            'people' => Person::count(),
            'alumni' => Alumnus::count(),
            'notices' => Notice::count(),
            'news' => News::count(),
            'research' => Research::count(),
            'galleries' => GalleryImage::count(),
            'contact_messages' => ContactMessage::count(),
            'users' => User::count(),
            default => 0,
        };
    }
}
