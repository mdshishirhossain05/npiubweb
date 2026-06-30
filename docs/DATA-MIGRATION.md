# Legacy Data Migration

How real production data moves from the legacy database into the new schema.

## Strategy: hybrid (new schema + idempotent importer)

- The new app has a **clean, modernized schema** (normalized `departments`,
  unified `people`, media library, SEO fields, RBAC).
- A repeatable Artisan importer, **`php artisan migrate:legacy`**, reads from a
  **restored copy** of the legacy database (a separate read-only `legacy`
  connection) and upserts into the new schema.
- The legacy database is **never modified** — it remains the source of truth and
  the rollback target.

## How legacy tables map to the new schema

| Legacy table(s) | New table(s) | Notes |
|---|---|---|
| `faculties`, `officers`, `offices` | `people` | Unified; `type` = faculty / officer / leadership. Upsert anchor: `(legacy_table, legacy_id)`. |
| *(department strings)* | `departments` | The free-text `department` values are resolved to real departments (seeded canonical + created-on-the-fly). |
| `alumni` | `alumni` | Upsert by `legacy_id`. |
| `notices` | `notices` | `important`→`is_important`, `date`→`notice_date`, `file`→`legacy_file`. |
| `news` | `news` | Image paths kept in `legacy_image` / `legacy_author_image`. |
| `research` | `research` | Same shape as news (empty in production today). |
| `galleries` | `gallery_albums` + `gallery_images` | Flat images grouped into one album per department. |
| `contact_messages` | `contact_messages` | Spam heuristically flagged; read state preserved. |
| `users` | `users` + spatie roles | **Password hashes preserved verbatim**; `role` mapped to spatie roles; `is_primary`→`super_admin`. |

Image/file references are stored as `legacy_*` path columns so a later,
file-aware step can copy the actual files into the media library on the server
where those files exist.

## Safety properties

- **Idempotent** — every entity upserts on a stable legacy key, so the command
  is safe to run many times (verified by tests); re-running at cutover pulls the
  freshest data without duplicating.
- **Transaction-wrapped** — each entity import runs in a DB transaction.
- **Non-destructive** — reads from `legacy`, writes to the default connection;
  never issues writes against the legacy database.
- **utf8mb4 end to end** — Bangla text migrates intact (verified by tests).

## Running it

1. Restore a copy of the production dump into a **separate** database
   (e.g. `npiub_legacy_copy`). Never point this at live production.
2. Configure the `legacy` connection in `.env`:
   ```env
   LEGACY_DB_DRIVER=mysql
   LEGACY_DB_HOST=127.0.0.1
   LEGACY_DB_DATABASE=npiub_legacy_copy
   LEGACY_DB_USERNAME=...
   LEGACY_DB_PASSWORD=...
   ```
3. Dry-run the reconciliation (no writes):
   ```bash
   php artisan migrate:legacy --report
   ```
4. Run the import:
   ```bash
   php artisan migrate:legacy
   ```
   Or a single entity: `php artisan migrate:legacy --only=people`
5. Review the **reconciliation report** printed at the end (legacy rows vs new
   rows per entity, with a match indicator).

## Tests

`tests/Feature/LegacyImportTest.php` stands up a throwaway sqlite database shaped
like the real legacy schema, seeds representative rows (Bangla text, JSON
columns, spam, an empty table, a shared department), and asserts: correct
mapping, password-hash preservation, role mapping, gallery grouping, spam
detection, and **idempotency** (running twice produces no duplicates).
