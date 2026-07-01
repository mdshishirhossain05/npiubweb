# Deploying to HostGator (shared cPanel hosting)

This guide takes the site live on HostGator. It assumes a standard shared /
Business cPanel plan. Two paths are given — **A (with SSH, recommended)** and
**B (no SSH, File Manager only)**. Do the *Common setup* first, then pick a path.

> The production database is sacred. Only ever run migrations against the new
> `npiub_new` database described below — never against a database that holds
> the live legacy site.

---

## 0. Prerequisites

- A HostGator account with cPanel access.
- The domain (e.g. `npiub.edu.bd`) pointed at the hosting.
- **PHP 8.4** — this project's dependencies require it.

### Set PHP to 8.4
cPanel → **MultiPHP Manager** → tick your domain → set **PHP Version = 8.4** → Apply.
Then cPanel → **Select PHP Version** (or *MultiPHP INI Editor*) and make sure these
extensions are enabled: `bcmath, ctype, curl, dom, fileinfo, gd, intl, mbstring,
openssl, pdo, pdo_mysql, tokenizer, xml, zip`.

---

## 1. Common setup

### 1a. Create the database
cPanel → **MySQL® Databases**:
1. Create a database, e.g. `npiubuser_new`.
2. Create a user, e.g. `npiubuser_app`, with a strong password.
3. **Add the user to the database** with **All Privileges**.
4. Write down the final names — cPanel prefixes them (e.g. `npiubuser_new`).

### 1b. Build front-end assets (once, before uploading)
The server has no Node, so assets are built beforehand. Either download the
`public-build` artifact from a green **CI run** on GitHub, or build locally:

```bash
npm ci && npm run build      # produces public/build/
```

You will upload that `public/build/` folder with the rest of `public/`.

### 1c. Decide the folder layout (important for security)
Only `public_html` is web-exposed. Laravel keeps app code **outside** the web
root. Target layout on the server:

```
/home/<cpaneluser>/
├── npiubweb/            ← the whole project EXCEPT the public/ folder
│   ├── app/ bootstrap/ config/ database/ resources/ routes/ storage/ vendor/ …
│   └── .env
└── public_html/         ← the CONTENTS of the project's public/ folder
    ├── index.php  .htaccess  build/  storage/(symlink) …
```

---

## Path A — With SSH (recommended)

Enable SSH: cPanel → **SSH Access** (or ask HostGator support to enable it),
then connect: `ssh <cpaneluser>@<yourdomain>`.

```bash
# 1. Get the code (outside the web root)
cd ~
git clone https://github.com/mdshishirhossain05/npiubweb.git
# ^ or upload a zip and unzip; result is ~/npiubweb

cd ~/npiubweb

# 2. Install PHP dependencies (production only, no dev tools)
#    Use the cPanel PHP 8.4 CLI binary explicitly:
/opt/cpanel/ea-php84/bin/php $(which composer) install --no-dev --optimize-autoloader

# 3. Environment
cp .env.example .env
/opt/cpanel/ea-php84/bin/php artisan key:generate
nano .env        # fill in the values from section 2 below

# 4. Database + first admin user
/opt/cpanel/ea-php84/bin/php artisan migrate --force
/opt/cpanel/ea-php84/bin/php artisan db:seed --force      # creates the admin login

# 5. Make storage public (uploaded images) & cache config
/opt/cpanel/ea-php84/bin/php artisan storage:link
/opt/cpanel/ea-php84/bin/php artisan config:cache
/opt/cpanel/ea-php84/bin/php artisan route:cache
/opt/cpanel/ea-php84/bin/php artisan view:cache

# 6. Expose public/ as the web root.
#    Easiest: point public_html at the project's public folder.
rm -rf ~/public_html            # back it up first if it has anything you need
ln -s ~/npiubweb/public ~/public_html
```

If HostGator won't allow symlinking `public_html`, instead **copy** the contents
of `~/npiubweb/public/` into `~/public_html/` and edit the two paths in
`~/public_html/index.php` to point at `__DIR__.'/../npiubweb/...'` for
`vendor/autoload.php` and `bootstrap/app.php`.

---

## Path B — No SSH (File Manager only)

Because there's no Composer on the server here, you must upload the `vendor/`
folder that was installed locally.

**On your computer:**
```bash
composer install --no-dev --optimize-autoloader   # needs PHP 8.4 locally
npm ci && npm run build
```
Then zip the whole project (including `vendor/` and `public/build/`).

**In cPanel → File Manager:**
1. Upload the zip to `/home/<cpaneluser>/` and **Extract** it → gives `~/npiubweb`.
2. Move the **contents** of `~/npiubweb/public/` into `~/public_html/`.
3. Edit `~/public_html/index.php`: change the two `require`/path lines from
   `__DIR__.'/../vendor/autoload.php'` and `__DIR__.'/../bootstrap/app.php'` to
   `__DIR__.'/../npiubweb/vendor/autoload.php'` and
   `__DIR__.'/../npiubweb/bootstrap/app.php'`.
4. Create `~/npiubweb/.env` (copy from `.env.example`) and fill it in (section 2).
5. In File Manager, create a folder `~/public_html/storage` and, in
   `.env`, keep the default `public` disk — uploaded media will live under
   `~/npiubweb/storage/app/public`. If you can't create a symlink via File
   Manager, ask HostGator support to run `php artisan storage:link`, or set
   `FILESYSTEM_DISK`/media disk to write directly under `public_html`.
6. Run migrations: the easiest no-SSH way is cPanel → **Cron Jobs**, add a
   one-off command:
   `/opt/cpanel/ea-php84/bin/php /home/<cpaneluser>/npiubweb/artisan migrate --force`
   then a second one: `... artisan db:seed --force`. Remove them after they run.

---

## 2. The `.env` values that matter

```dotenv
APP_NAME="NPI University of Bangladesh"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://npiub.edu.bd

APP_KEY=            # set by `php artisan key:generate`

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=npiubuser_new
DB_USERNAME=npiubuser_app
DB_PASSWORD=your-strong-password

# Shared hosting has no Redis / daemons — keep everything on database/file/sync.
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
MAIL_MAILER=smtp        # fill in your cPanel email SMTP details

# First admin account created by `php artisan db:seed`
ADMIN_NAME="NPIUB Administrator"
ADMIN_EMAIL=admin@npiub.edu.bd
ADMIN_PASSWORD=change-this-now
```

After editing `.env` always re-run (SSH) `php artisan config:cache`.

---

## 3. Scheduler (optional but recommended)

cPanel → **Cron Jobs**, run every minute:

```
* * * * * /opt/cpanel/ea-php84/bin/php /home/<cpaneluser>/npiubweb/artisan schedule:run >> /dev/null 2>&1
```

---

## 4. Go live checklist

- [ ] Visit `https://npiub.edu.bd` → the homepage loads.
- [ ] Visit `https://npiub.edu.bd/admin` → log in with `ADMIN_EMAIL` / `ADMIN_PASSWORD`.
- [ ] **Change the admin password** immediately after first login.
- [ ] Upload a slide image, a faculty photo, a news featured image → confirm they
      appear on the public site (verifies `storage:link`).
- [ ] Enable **AutoSSL** (cPanel → SSL/TLS Status) so the padlock shows.

---

## 5. Updating the site later

**Path A (SSH):**
```bash
cd ~/npiubweb && git pull
/opt/cpanel/ea-php84/bin/php $(which composer) install --no-dev --optimize-autoloader
/opt/cpanel/ea-php84/bin/php artisan migrate --force
/opt/cpanel/ea-php84/bin/php artisan config:cache && php artisan view:cache && php artisan route:cache
```
Upload a freshly built `public/build/` if the front-end changed.

**Path B:** rebuild locally, re-upload the changed files (and `vendor/` if
dependencies changed), then run the migrate cron once.

---

## Legacy data import (when ready)

Once the real legacy database is available as a **copy**, set the `LEGACY_DB_*`
values in `.env`, then run `php artisan legacy:import`. The importer is
idempotent and never writes to the legacy database. Adjust the column mapping in
`config/legacy.php` to match the real legacy schema first.
