# NPI University of Bangladesh — Website

Modern rebuild of the official website of **NPI University of Bangladesh**
(`npiub.edu.bd`). Public site + admin panel, built to run on **HostGator shared
hosting** (no Node, no Redis, no long-running workers in production).

## Tech stack

| Layer | Choice |
|---|---|
| Framework | Laravel 12 (PHP 8.2+) |
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
  (e.g. `/opt/cpanel/ea-php82/bin/php`).

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

## Project phases

- [x] **Phase 0** — Backup & legacy schema inspection
- [x] **Phase 1** — Plan & scaffold
- [x] **Phase 2** — New schema, models & legacy data importer (see `docs/DATA-MIGRATION.md`)
- [x] **Phase 3** — Admin panel: Filament resources + RBAC (menus & site-settings UI pending)
- [x] **Phase 4** — Design system (Modern Minimal: Space Grotesk + Inter, brand-green accent)
- [x] **Phase 5** — Public site (all pages + working forms + search)
- [x] **Phase 6** — SEO, performance, hardening
- [x] **Phase 7** — Deployment & staging (see `DEPLOYMENT.md`)
- [ ] **Phase 8** — Verified cutover & go-live
