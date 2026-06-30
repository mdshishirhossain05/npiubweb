# NPI University of Bangladesh — Website

Modern rebuild of the official website of **NPI University of Bangladesh**
(`npiub.edu.bd`). Public site + admin panel, built to run on **HostGator shared
hosting** (no Node, no Redis, no long-running workers in production).

## Tech stack

| Layer | Choice |
|---|---|
| Framework | Laravel 12 (PHP 8.4+) |
| Admin panel | Filament 4 |
| Auth & RBAC | Laravel auth + `spatie/laravel-permission` |
| Media | `spatie/laravel-medialibrary` (PHP/GD image pipeline — no Node on server) |
| Audit log | `spatie/laravel-activitylog` |
| Front-end | Blade + Tailwind CSS 4 + Alpine/Livewire (where genuinely interactive) |
| Build tooling | Vite (local / CI only — **never** on the server) |
| Database | MySQL 8 / MariaDB (cache, session, queue all use the `database` driver) |
| Testing | Pest 4 |
| Code quality | Laravel Pint + Larastan (PHPStan) |

## Hosting constraints (these shape every decision)

- **No Node in production.** Assets are built locally or in CI; the compiled
  `public/build` is what the server serves.
- **No Redis / no daemons.** `cache`, `session`, and `queue` use `database`/`file`/`sync`.
  Scheduled work runs via cPanel cron hitting `php artisan schedule:run`.
- App code lives outside the web root; only Laravel's `public/` is exposed.
- Composer/Artisan on the server use the explicit cPanel PHP CLI binary
  (e.g. `/opt/cpanel/ea-php84/bin/php`). Select PHP 8.4 in cPanel — the
  locked dependencies require it.

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate          # against a LOCAL dev DB — never production
npm install && npm run build # or `npm run dev`
php artisan serve
```

Admin panel: <http://localhost:8000/admin>

## Quality checks

```bash
./vendor/bin/pint --test      # code style
./vendor/bin/phpstan analyse  # static analysis (Larastan)
./vendor/bin/pest             # tests
```

CI (`.github/workflows/ci.yml`) runs all three plus the Vite asset build on every push.

## Data safety

The production database is **sacred and read-only** until final cutover. All
development runs against a separate copy (`npiub_new`). Never run destructive
migration commands (`migrate:fresh`, `migrate:refresh`, `db:wipe`, etc.) against
any database that can reach real data. Legacy data is imported via a repeatable,
idempotent importer; the old database is preserved intact as rollback.

## Content schema & legacy import

The new schema models the site's content as discrete, slugged, auditable
entities:

| Model | Table | Notes |
|---|---|---|
| `Page` | `pages` | Static content; soft-deletes, SEO meta, media |
| `Post` | `posts` | News/articles in an optional `Category`; soft-deletes, media |
| `Category` | `categories` | Taxonomy for posts |
| `Notice` | `notices` | Circulars with a date + downloadable attachment (media) |
| `Event` | `events` | Calendar events with start/end + location |
| `Department` | `departments` | Owns programs & faculty |
| `Program` | `programs` | Academic program under a department |
| `FacultyMember` | `faculty_members` | Teacher/staff with photo (media) |
| `Slide` | `slides` | Homepage hero/carousel slides (media) |

Shared behaviour lives in small concerns: `HasSlug` (stable, unique slugs
generated once on create), `RecordsActivity` (Spatie audit log), plus
`spatie/laravel-medialibrary` for images/attachments. Publication state is the
`ContentStatus` enum (`draft` / `published`).

### Importing legacy data

Every imported row carries a `legacy_id` mapping it back to the old database,
so the importer is **idempotent** — re-running updates in place rather than
duplicating. The old database is treated as strictly read-only.

```bash
# Point LEGACY_DB_* in .env at a *copy* of the old site database, then:
php artisan legacy:import
```

The mapping (legacy table → model, column → attribute) is declared
declaratively in `config/legacy.php` — no closures, so it survives
`config:cache` in production. Legacy tables absent from a given dump are skipped
rather than failing, and junk dates (`0000-00-00`) are coerced to `null`. The
column names there are best-effort guesses; reconcile them against the real
legacy schema before the first production import run.

## Project phases

- [x] **Phase 0** — Backup & legacy schema inspection
- [x] **Phase 1** — Plan & scaffold
- [x] **Phase 2** — New schema, models & legacy data importer
- [ ] **Phase 3** — Admin panel (Filament resources + RBAC)
- [ ] **Phase 4** — Design system
- [ ] **Phase 5** — Public site
- [ ] **Phase 6** — SEO, performance, hardening
- [ ] **Phase 7** — Deployment & staging
- [ ] **Phase 8** — Verified cutover & go-live
