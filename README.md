# নবদুর্গা (Navadurga) — জ্ঞান, সাধনা, পূজা ও সেবা

A modular, database-driven PHP website about Navadurga, Navaratri, puja planning, daily
spiritual practice and modern seva (social-service) suggestions, built for Bengali-speaking
users in Bangladesh and West Bengal.

> **Important content note.** Everything under "seva" (social-service suggestions), the
> day-by-day "modern focus" table, and the "what can I do today" recommender are this
> website's own modern, values-based proposals — not scriptural injunctions. Pages that
> present them say so explicitly. Scriptural/traditional claims are marked as such
> ("শাস্ত্রীয় বর্ণনায়", "প্রচলিত বিশ্বাস অনুযায়ী", "আঞ্চলিক রীতিতে") and no source or
> quotation is fabricated — if a claim can't be sourced, the `source` field is left empty
> rather than invented.

---

## 1. Overview

- **Backend:** plain PHP 8 (no framework), a small hand-written MVC-ish core
  (router, PDO repository layer, session/auth, CSRF, validation) in `app/core`.
- **Frontend:** hand-written HTML/CSS/JS (no Bootstrap dependency), Noto Sans/Serif Bengali,
  light/dark theme (persisted in `localStorage`), a working Bengali/English UI toggle.
- **Database:** MySQL/MariaDB via PDO + prepared statements everywhere.
- **No Composer dependency required to run.** The app ships its own PSR-4-*like*
  autoloader (`app/core/Autoloader.php`), so it runs on plain XAMPP/Laragon/shared hosting
  with zero `composer install`. `composer.json` exists only so you can *optionally* add a
  package later (e.g. PHPMailer) — it is not loaded by the app today.

### Why no framework / no Bootstrap?
This keeps the app runnable on the cheapest shared hosting (no CLI/Composer access needed),
keeps the codebase small enough to fully audit, and avoids a large unused CSS framework
when the design calls for a specific, restrained visual language.

## 2. Feature summary (what's real vs. simplified)

Fully implemented and wired to the database, with working admin CRUD:
Navadurga (9 forms), Navaratri (9 days + per-year calendar), Puja planning checklist
(guest = localStorage, logged-in = DB), Puja Samagri with purchased/prepared toggles,
Seva module with filters (beneficiary/difficulty/budget/time) and the "আজ আমি কী করতে
পারি?" recommender, Children/Family/Environment activities, 9-day Family Challenge,
Daily reflections, Mantras (with copy/print/font-size controls), Articles, FAQ, Gallery,
global Search, Contact form, full auth (register/login/logout, `password_hash`/
`password_verify`, sessions), role-based Admin panel for every content type, site
settings, EN/BN language toggle, SEO (sitemap.xml, robots.txt, canonical/OG tags),
CSRF protection, RBAC middleware, responsive layout, print stylesheets, and a basic
installable PWA shell (manifest + service worker with an offline fallback page).

Deliberately kept simple: gamification is a handful of non-competitive badges (no
leaderboards, as the spec asked); the PWA caches the app shell only, it does not attempt
full offline CRUD; English content is available for UI chrome and any field an admin fills
in (`name_en`, `title_en`, …) — long-form Bengali description/story fields are not
auto-translated.

## 3. Requirements

- PHP 8.0+ (uses `match`, constructor property defaults, nullsafe-free code — no 8.1+-only
  syntax, so it also runs on 8.1/8.2/8.3).
- MySQL 5.7+ / MariaDB 10.3+ (schema uses `utf8mb4`, `FULLTEXT`, standard `InnoDB` FKs).
- Apache with `mod_rewrite` (the included `.htaccess` files assume Apache; see §9 for Nginx).
- Composer is **not required**.

## 4. Installation — XAMPP (what this project was built/tested against)

1. Copy the project so it lives at `C:\xampp\htdocs\navadurga`.
2. Start Apache and MySQL from the XAMPP control panel.
3. Create the database and load the schema + seed data. **On Windows/PowerShell, do not
   pipe the files in with `Get-Content | mysql.exe`** — PowerShell's pipeline re-encodes
   text sent to a native process, which silently double-encodes every Bengali/Sanskrit
   string in the seed data (this bit us during development; see §12). Use MySQL's own
   `source` command instead, which makes `mysql.exe` read the file directly:
   ```powershell
   C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS navadurga_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   C:\xampp\mysql\bin\mysql.exe -u root navadurga_db -e "source database/schema.sql"
   C:\xampp\mysql\bin\mysql.exe -u root navadurga_db -e "source database/seed.sql"
   ```
   (On macOS/Linux, the usual redirection is fine — it doesn't go through a text-reencoding
   pipeline: `mysql -u root -e "CREATE DATABASE ..."`, then
   `mysql -u root navadurga_db < database/schema.sql` etc. phpMyAdmin's *Import* tab also
   works correctly on any OS, since it uploads the file's raw bytes.)
4. Copy `.env.example` to `.env` and adjust if your MySQL user/password differ from the
   XAMPP default (`root` / empty password). Set `APP_URL` — see the note below.
5. Visit the site. Because plain XAMPP has no virtual host, this project's **root**
   `.htaccess` transparently forwards every request to `public/`, so you can browse
   `http://localhost/navadurga/` directly (no need to type `/public`).
6. Log into the admin panel at `http://localhost/navadurga/admin` with the seeded admin
   account:
   - **Email:** `admin@navadurga.local`
   - **Password:** `Navadurga@123`

   **Change this password immediately** (Admin → Users, or via Profile after logging in).

### A note on `APP_URL` / subfolder hosting
Because this can run either (a) with the web server's document root pointed straight at
`public/` (recommended for production/shared hosting — see §9), or (b) dropped into a
plain XAMPP `htdocs` subfolder with no vhost, the app detects its own base path at
runtime (`config/bootstrap.php`) by comparing `SCRIPT_NAME` against `REQUEST_URI`, so
links/assets/CSRF-safe forms work correctly either way. `APP_URL` in `.env` is used for
metadata (canonical/OG tags are actually built from the live request, not from `.env`,
so this mostly matters for anything you script outside a request, like CLI tools).

## 5. Installation — Laragon

Same as XAMPP, but Laragon gives every project a `*.test` virtual host automatically
with document root at the project root. Either:
- Point Laragon's auto-vhost at the project root and rely on the root `.htaccess`
  rewrite-to-`public/` trick (works out of the box), **or**
- Edit the auto-generated vhost (Laragon → right-click project → *Apache config*) to set
  `DocumentRoot` to the `public/` folder directly, which is cleaner for anything you intend
  to deploy the same way in production.

## 6. `.env` reference

| Key | Purpose |
|---|---|
| `APP_NAME`, `APP_ENV`, `APP_DEBUG` | Branding + whether PHP errors are displayed. Set `APP_DEBUG=false` in production. |
| `APP_URL`, `APP_TIMEZONE`, `APP_LOCALE` | Metadata/timezone (`Asia/Dhaka`) / default UI locale. |
| `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_CHARSET` | PDO connection (`app/core/Database.php`). |
| `SESSION_NAME`, `SESSION_LIFETIME` | Session cookie name/lifetime (minutes). |
| `MAIL_*` | Reserved for a future mail integration; the contact form currently always saves to `contact_messages` (see §11) rather than sending email, since no mail library is wired in yet. |
| `CURRENT_NAVARATRI_YEAR` | Which `festival_calendar` year is treated as "this year" on the homepage/daily guide. **Update this every year** (see §11). |

Never commit `.env` — it's in `.gitignore`. Keep `.env.example` in sync with any new keys
you add.

## 7. Folder structure

```
/app
  /config        app.php, database.php, lang/{bn,en}.php   (PHP config arrays, not secrets)
  /core          Router, Request, Database (PDO), Repository base class, Auth, Session, Csrf, Controller, Autoloader
  /controllers   one per public route group, + /admin for the admin panel
  /repositories  one per DB table — all queries live here (prepared statements only)
  /middleware    AuthMiddleware, GuestMiddleware, AdminMiddleware, CsrfMiddleware
  /validators    Validator.php (rule-based: required/email/min/max/same/unique/numeric/in)
  /helpers       functions.php — e(), url(), asset(), t(), bn_digits(), bn_date(), setting(), …
  /views
    /layouts     layouts/app.php (public site), layouts/admin.php (admin panel, own sidebar)
    /components  header, footer, alerts, breadcrumb (shared partials)
    /pages       one folder per module (navadurga/, navaratri/, seva/, articles/, mantras/, …)
    /admin       admin/crud/{index,form}.php — ONE generic table+form view reused by every
                 admin entity (see §8), plus a few bespoke admin pages (dashboard, settings, messages)
    /auth        login.php, register.php
    /errors      404 / 403 / 500 / 400 (see §10 re: why not "419")
/public          the actual document root: index.php (front controller), assets/, uploads/,
                 robots.txt, manifest.json, sw.js, offline.html
/routes          web.php (public+user), admin.php (admin panel), api.php (3 small AJAX endpoints)
/database        schema.sql, seed.sql
/config          bootstrap.php (the only file included by public/index.php; wires
                 autoload → env → error handling → base-path detection → session)
/storage         logs/, cache/, uploads/ (all outside public/, `.htaccess`-denied)
```

## 8. How the admin panel avoids 12x duplicated CRUD code

`app/controllers/admin/AdminCrudController.php` is an abstract base class. A concrete
admin controller (e.g. `NavadurgaController`) just declares, in its constructor: which
repository it uses, its field list (`key`, Bengali `label`, input `type`:
text/textarea/select/number/date/checkbox/image, and `options` for selects), which
columns show in the list table, and which columns are searchable. The base class then
handles listing+search+pagination, create/edit form rendering, validation, image upload
(MIME-checked, size-capped, renamed to a random filename), and delete — all through two
shared view templates (`admin/crud/index.php`, `admin/crud/form.php`). This is also why
adding a 13th content type later is ~40 lines, not a new set of views.

`SettingsController` (key/value site settings) and `MessageController` (contact inbox)
don't fit the list+form shape, so they're small bespoke controllers instead of forcing
them through the generic base.

## 9. Deployment (shared hosting / VPS with a real domain)

1. Point the web server's document root at `public/` directly (not the project root).
   With Apache this makes `public/.htaccess`'s rewrite-to-`index.php` the only rewriting
   in play, and the root `.htaccess` (which exists purely for the no-vhost XAMPP case)
   is simply never reached — you can leave it in place, it's harmless.
2. **Nginx:** there's no `.htaccess` equivalent — add to your server block:
   ```nginx
   root /path/to/navadurga/public;
   index index.php;
   location / {
       try_files $uri $uri/ /index.php?$query_string;
   }
   location ~ \.php$ {
       fastcgi_pass unix:/run/php/php8.2-fpm.sock;
       fastcgi_index index.php;
       include fastcgi_params;
       fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
   }
   location ~ /\. { deny all; }
   ```
3. Upload everything **except** `.env` (create it directly on the server with production
   values), and make sure `storage/logs`, `storage/cache`, and `public/uploads` are
   writable by the web server user.
4. Set `APP_DEBUG=false` and a real `APP_URL` in the server's `.env`.
5. Import `database/schema.sql` then `database/seed.sql` via your host's phpMyAdmin or
   `mysql` CLI, matching the credentials in `.env`.
6. Log in as the seeded admin and **change the password immediately** (see §4).
7. If your host's document root can only point at the account root (common on shared
   hosting with no vhost control), keep the project as-is: the root `.htaccess` will
   transparently serve everything from `public/`, exactly like the local XAMPP setup.

### Backup / restore
- **Backup:** `mysqldump -u <user> -p navadurga_db > backup.sql`, plus copy `public/uploads/`
  (admin-uploaded images live there, not in the database).
- **Restore:** `mysql -u <user> -p navadurga_db < backup.sql` (Linux/macOS), or on Windows
  PowerShell `mysql -u <user> -p navadurga_db -e "source backup.sql"` for the same reason
  described in §4/§12 — restore `public/uploads/`, and use the same `.env` (or update
  `DB_*` to match the new server).

## 10. Security notes

- All SQL goes through `App\Core\Repository` or explicit `PDO::prepare()` calls with bound
  parameters — no string-concatenated queries anywhere in the codebase.
- `PDO::ATTR_EMULATE_PREPARES` is deliberately **`true`**. Several read queries legitimately
  reuse the same named placeholder twice in one query (e.g.
  `WHERE title_bn LIKE :q OR excerpt LIKE :q`), which MySQL's *native* prepared statements
  reject outright (`SQLSTATE[HY093]`). Emulated mode still fully parameter-binds every
  value (it is not string interpolation) and is what most PHP frameworks default to for
  exactly this reason.
- All output is escaped through `e()` (`htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`) except
  a handful of deliberate, clearly-marked `nl2br(e($x))` calls (escape happens *before*
  the `<br>` injection, so this is still safe) and the admin table's thumbnail `<img>` tag,
  which only ever renders a server-generated upload path, never raw user input.
- Every state-changing `POST` route runs `CsrfMiddleware` (`app/middleware/CsrfMiddleware.php`),
  which checks a per-session token via `hash_equals()`. On failure it returns HTTP
  **400**, not the more conventional "419" — 419 isn't a registered HTTP status, and on
  this project's actual Apache/mod_php stack, calling `http_response_code(419)` crashes
  with a blank 500 instead of sending a response. This was caught during testing (see the
  git history / this file) and fixed by using the standard 400 instead.
- Passwords: `password_hash()` / `password_verify()`, PHP's defaults (currently bcrypt).
- Sessions: `httponly`, `SameSite=Lax`, `secure` auto-enabled under HTTPS, regenerated on
  login (`session_regenerate_id(true)`) to prevent fixation.
- File uploads (admin image fields): MIME-sniffed via `mime_content_type()` (not the
  client-supplied `Content-Type`), capped at 3MB, renamed to a random filename before
  being written under `public/uploads/<subdir>/`.
- `app/`, `config/`, `database/`, `routes/`, `storage/` each carry their own
  `Require all denied` `.htaccess` as defense-in-depth, in case a misconfigured host ever
  points its document root above `public/`.
- Role-based access: `AdminMiddleware` checks both "logged in" and "`role_id` is admin";
  it's applied to every `/admin/*` route in `routes/admin.php`.

## 11. Content management notes for editors/admins

- **Every year**, before Navaratri, an admin should: update `CURRENT_NAVARATRI_YEAR` in
  `.env`, and add that year's 9 dates (+ Dashami) under **Admin → পঞ্জিকা**. The rest of the
  site (homepage "today", daily guide, countdown) derives "today" from whatever row in
  `festival_calendar` matches today's date for that year — nothing about dates is hardcoded
  in PHP.
- **Contact form submissions** are not emailed anywhere yet — `MAIL_*` in `.env` is a
  placeholder for a future integration. Check **Admin → বার্তা** periodically.
- **Sources:** the `scriptural_sources` / `source` fields on Navadurga and Mantras are
  intentionally left blank in the seed data wherever a specific citation couldn't be
  verified, per the "never fabricate a source" instruction this project was built under.
  If you (the admin) have a verifiable citation, add it there — don't invent one.
- Any content field ending in `_bn`/`_en` (e.g. `sevas.title_bn`/`title_en`,
  `navadurga.name_bn`/`name_en`) is what currently powers the partial EN/BN experience —
  fill in the `_en` companion field and it will show up automatically once a visitor
  switches to English via the header toggle.

## 12. Troubleshooting

| Symptom | Likely cause |
|---|---|
| Blank page / 500 on every page | Check `storage/logs/php-error.log` first. If it's empty too, check Apache's own `error.log` — some failures (like the 419-status one above) happen before your app's own error handler gets a chance to log anything. |
| "SQLSTATE[HY093]: Invalid parameter number" | You're re-emulating prepares as `false` somewhere — see §10, keep it `true`. |
| Bengali text shows as `à¦¶à§ˆ...`-style mojibake **in a terminal** (e.g. `mysql` CLI output in PowerShell) | Usually just that terminal's font/codepage misrendering correct UTF-8 bytes — open the actual page in a browser to check before assuming the data is wrong. |
| Bengali text shows as mojibake **in the actual browser**, on the live site | This is a real data problem, not a display one — most likely the database was seeded by piping a `.sql` file through PowerShell (`Get-Content \| mysql.exe`), which re-encodes the text and *double-encodes* every non-ASCII byte on the way in (confirmed during this project's own build — see §4/§9 for the fix: re-import using `mysql.exe -e "source file.sql"` instead, which makes the MySQL client read the file's bytes directly rather than routing them through PowerShell's pipeline). If a table's data is already corrupted this way, re-importing from the original (uncorrupted) `.sql` files via `source` fixes it — you do not need to edit `schema.sql`/`seed.sql` themselves, they were never the problem. |
| Bengali text renders in a plain/incorrect-looking font | The page loads Noto Sans/Serif Bengali from Google Fonts; if that's blocked (offline, ad-blocker stripping `@import`/stylesheet `<link>`s, etc.) it falls back to `Nirmala UI`/`Vrinda` (bundled with Windows) before a generic sans-serif — you should still get *correct* Bengali glyphs, just from a different font. |
| Pretty URLs don't work (`?p=...`-style only) | `mod_rewrite` isn't enabled, or `AllowOverride` isn't `All` for the htdocs/vhost directory in your Apache config. |
| Admin login works but every `/admin/*` page 403s | The seeded user's `role_id` must be `2`. Check `SELECT role_id FROM users WHERE email='admin@navadurga.local';`. |
| CSRF error ("সেশন মেয়াদোত্তীর্ণ") on a form that should be fine | Session cookie not being sent/kept — check `SESSION_NAME`/cookie settings aren't being stripped by a proxy, and that the form was loaded (not cached) after your last deploy (CSRF tokens are per-session, not per-deploy, so this is rarely the actual cause, but a stale cached page with an old token can trigger it). |

---

Built module-by-module (architecture → base UI → Navadurga → Navaratri → puja planning →
seva → children/family/environment → mantra/learning/articles/FAQ → auth → admin →
SEO/security/accessibility → testing), with real, database-backed CRUD everywhere the
brief asked for it — nothing here is a static mockup.
