# Deployment — HostGator (shared, cPanel)

This guide deploys the app to a **staging subdomain** first (against a *copy* of
your data), leaving the live site untouched. Go-live/cutover is Phase 8.

Values below match this account — **adjust if yours differs**:

| Thing | Value |
|---|---|
| cPanel user | `owdfyvte` |
| Home dir | `/home2/owdfyvte` |
| PHP 8.2 CLI | `/opt/cpanel/ea-php82/bin/php` |
| App root (staging) | `/home2/owdfyvte/npiub_staging` |
| Staging subdomain | `staging.npiub.edu.bd` |
| New database | `owdfyvte_npiub_new` |

## The model (why it's safe)

- The Laravel app lives **outside** the web root, at `~/npiub_staging`. Only
  `~/npiub_staging/public` is exposed (as the subdomain's document root).
- The server has **no Node**, so assets are built in GitHub Actions and shipped
  on the **`deploy` branch** (which includes `public/build`). You pull `deploy`.
- The **old site and old DB are never touched.** Staging uses a **new** database
  (`owdfyvte_npiub_new`) populated from a *restored copy* of production.

---

## 1. PHP version

cPanel → **MultiPHP Manager** → select the staging subdomain → set **PHP 8.2**.

## 2. Create the new database + user

cPanel → **MySQL® Databases**:
1. Create database: `owdfyvte_npiub_new`
2. Create user: `owdfyvte_npiubapp` with a **strong** password.
3. Add the user to the database with **ALL PRIVILEGES** (for migrations). You can
   reduce privileges after go-live (remove DROP/ALTER) for least-privilege.
4. Record the values for `.env` (below).

> Create a **second** database `owdfyvte_npiub_legacy` and restore your
> production dump into it (this is the read-only *copy* the importer reads).
> Never point the importer at the live DB.

## 3. Create the staging subdomain

cPanel → **Domains / Subdomains** → create `staging.npiub.edu.bd`.
Set its **Document Root** to:

```
/home2/owdfyvte/npiub_staging/public
```

(You'll create that folder in the next step via Git.)

## 4. Connect GitHub via cPanel Git Version Control

cPanel → **Git™ Version Control** → **Create**:
- **Clone URL**: your GitHub repo (add a **deploy key** first: cPanel shows an
  SSH key under Git; add it to GitHub → repo → Settings → Deploy keys, read
  access is enough).
- **Repository Path**: `/home2/owdfyvte/npiub_staging`
- **Branch**: `deploy`  ← the CI-built branch with compiled assets

After it clones, you'll see the **`.cpanel.yml`** is present.

## 5. One-time server setup

Open cPanel **Terminal** (or SSH) and run:

```bash
cd /home2/owdfyvte/npiub_staging

# Composer (once): grab composer.phar into the app root
/opt/cpanel/ea-php82/bin/php -r "copy('https://getcomposer.org/installer','ci.php');"
/opt/cpanel/ea-php82/bin/php ci.php && rm ci.php   # creates composer.phar

# Install PHP dependencies
/opt/cpanel/ea-php82/bin/php composer.phar install --no-dev --optimize-autoloader

# Create the environment file
cp .env.example .env
/opt/cpanel/ea-php82/bin/php artisan key:generate

# Make storage + cache writable
chmod -R 775 storage bootstrap/cache
```

## 6. Configure `.env` (staging)

Edit `/home2/owdfyvte/npiub_staging/.env`:

```env
APP_NAME="NPI University of Bangladesh"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://staging.npiub.edu.bd

# Shared hosting: no Redis, no queue worker
CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=sync

# New database (NOT the legacy one)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=owdfyvte_npiub_new
DB_USERNAME=owdfyvte_npiubapp
DB_PASSWORD=your-strong-password

# Restored COPY of production, read-only — used only by migrate:legacy
LEGACY_DB_DRIVER=mysql
LEGACY_DB_HOST=localhost
LEGACY_DB_DATABASE=owdfyvte_npiub_legacy
LEGACY_DB_USERNAME=owdfyvte_npiubapp
LEGACY_DB_PASSWORD=your-strong-password

# Email (cPanel → Email Accounts, then SMTP)
MAIL_MAILER=smtp
MAIL_HOST=mail.npiub.edu.bd
MAIL_PORT=465
MAIL_USERNAME=info@npiub.edu.bd
MAIL_PASSWORD=your-mailbox-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@npiub.edu.bd"
MAIL_FROM_NAME="${APP_NAME}"
```

## 7. Deploy

1. In **GitHub Actions**, confirm the **“Build deploy branch”** workflow ran and
   created/updated the `deploy` branch (it builds `public/build`).
2. cPanel → Git Version Control → **Update from Remote**, then
   **Deploy HEAD Commit**. This runs `.cpanel.yml`:
   composer install → `migrate --force` → `storage:link` → config/route/view/event cache.

Then seed roles + the default admin (first deploy only):

```bash
cd /home2/owdfyvte/npiub_staging
/opt/cpanel/ea-php82/bin/php artisan db:seed --force   # roles, permissions, site settings, admin
```

## 8. Import real data (into the NEW db, from the COPY)

```bash
cd /home2/owdfyvte/npiub_staging
/opt/cpanel/ea-php82/bin/php artisan migrate:legacy --report   # dry-run counts
/opt/cpanel/ea-php82/bin/php artisan migrate:legacy            # import
```

Review the reconciliation table (legacy vs new counts). See `docs/DATA-MIGRATION.md`.

## 9. SSL + force HTTPS

- cPanel → **SSL/TLS Status** → run **AutoSSL** for `staging.npiub.edu.bd`.
- Force HTTPS: cPanel → Domains → toggle **Force HTTPS Redirect**, or add to
  `public/.htaccess` (top of the rewrite block):
  ```apache
  RewriteCond %{HTTPS} !=on
  RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
  ```

## 10. Cron (Laravel scheduler)

cPanel → **Cron Jobs** → add (every minute):

```
* * * * * /opt/cpanel/ea-php82/bin/php /home2/owdfyvte/npiub_staging/artisan schedule:run >> /dev/null 2>&1
```

## 11. Admin login

Visit `https://staging.npiub.edu.bd/admin` and log in with the seeded admin
(`ADMIN_EMAIL` / `ADMIN_PASSWORD`, defaults in `config/npiub.php`).
**Change the password immediately.**

---

## Redeploying (every update)

1. Merge/push to the source branch → GitHub Actions rebuilds the `deploy` branch.
2. cPanel Git → **Update from Remote** → **Deploy HEAD Commit**.

## Go-live checklist (before cutover)

- [ ] `APP_ENV=production`, `APP_DEBUG=false`
- [ ] Caches built (config/route/view/event), opcache on
- [ ] Real data imported + reconciliation reviewed
- [ ] Forms tested (contact + admission inquiry arrive by email)
- [ ] Admin login works; password changed; least-privilege DB user
- [ ] SSL active, HTTPS forced
- [ ] Sitemap reachable (`/sitemap.xml`), robots correct
- [ ] Logo + real photos uploaded

## Cutover to production (Phase 8, summary)

1. Verify everything on staging.
2. Put the **old** site in maintenance briefly; take a **final** fresh dump of
   production into `owdfyvte_npiub_legacy`.
3. Re-run `php artisan migrate:legacy` (idempotent) to pull the freshest data.
4. Point the **main domain** `npiub.edu.bd` document root to
   `~/npiub_staging/public` (rename to `~/npiub_app` if you prefer), or repeat
   this deployment at the production path.
5. The **old app + old DB stay intact** as an instant rollback.

## Troubleshooting

- **500 with blank page** → check `storage/logs/laravel.log`; ensure `storage`
  and `bootstrap/cache` are writable (775) and `.env` `APP_KEY` is set.
- **Assets 404 / unstyled** → the deployed branch must be `deploy` (it contains
  `public/build`). Re-run the GitHub Action, re-pull.
- **`php` is the wrong version** → always call `/opt/cpanel/ea-php82/bin/php`.
- **`composer` not found** → use `./composer.phar` (step 5).
- **Symlink disabled** (`storage:link` fails) → copy instead:
  `cp -r storage/app/public public/storage`.
- **After changing `.env`** → re-run `php artisan config:cache`.
