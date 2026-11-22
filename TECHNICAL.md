# asdos-menilai — technical notes

## Stack

- Laravel **v10.13.5** — exact version from `composer.lock` (package `laravel/framework`), not the manifest. `composer.json:10` requires `^10.10`; the lockfile pin satisfies it.
- PHP: `^8.1` platform requirement in `composer.lock` (`platform.php`), confirmed by the runtime images `php:8.1-cli-alpine` (`Dockerfile:2`) and `php:8.1-fpm-alpine` (`Dockerfile:20`). The inventory `php_version: ^8.1` is the manifest minimum, not the resolved truth.
- Other locked Composer packages: `laravel/sanctum` v3.2.5, `laravel/tinker` v2.8.1, `guzzlehttp/guzzle` 7.7.0 (`composer.lock`).
- Front-end: Vite 4 + `laravel-vite-plugin` 0.7 + axios 1.1.2, declared as ranges in `package.json:9-13`. There is **no `package-lock.json`**, so npm versions are not lockfile-verifiable. `npm run build` (`package.json:6`) writes `public/build` via `vite.config.js:3-8`.

## Architecture

Document root is `/app/public` (`Dockerfile:36`), front controller `public/index.php:34-53`. In the shipped image, nginx listens on port 8080, serves static files directly (`try_files $uri $uri/ /index.php?$query_string`, `.containerize/nginx-fpm.conf.template:24-31`) and proxies `.php` to PHP-FPM over the unix socket `/tmp/php-fpm.sock` (`:34`); supervisord runs both programs (`.containerize/supervisord.conf:8-24`). The entrypoint `envsubst`s `${PORT}` and `${DOC_ROOT}` into `/tmp/nginx/nginx.conf` before `exec "$@"` (`.containerize/entrypoint-fpm.sh:4-5`).

Routing: `RouteServiceProvider` loads `api.php` under the `api` / `/api` prefix and `web.php` under `web` (`app/Providers/RouteServiceProvider.php:31-38`). Rendering is 12 Blade page views plus one shared layout (`resources/views/layout/index.blade.php`); there is no SPA or client-side routing. The six `nilai` routes use custom model bindings that call `Laporan::findOrFail($value)` and `Nilai::findOrFail($value)` (`routes/web.php:29-30`), so they 404 when the referenced row is absent. No background work: the queue driver is `sync` (`config/queue.php:16`), no jobs are dispatched, and the scheduler body is commented out (`app/Console/Kernel.php:13-16`).

## Data model

| Table | Key columns | Relationships / computed values |
|---|---|---|
| `matakuliah` | `id`, `nama`, `kelas` (enum 1,2), `nilai_laporan` (int, default 0), `max_nilai` (int, default 100) — migration `2023_06_10_053723_create_matakuliahs_table.php:11-18`, model `app/Models/Matakuliah.php:10-19` | `hasMany Laporan`; appended `nilai_jawaban = max_nilai - nilai_laporan` (`Matakuliah.php:12-18`) |
| `mahasiswa` | `id`, `nim` (**unique**), `nama`, `kelas` (enum 1,2) — migration `2023_06_10_074653_create_mahasiswas_table.php:11-17` | `hasMany Nilai`; **no foreign key to `matakuliah`** — students are matched to a report by comparing `kelas` (`NilaiController.php:19-20`) |
| `laporan` | `id`, `nama`, `jumlah_soal`, `matakuliah_id` (FK → `matakuliah.id`, ON DELETE CASCADE) — migration `2023_06_10_075321_create_laporans_table.php:11-19` | `belongsTo Matakuliah`, `hasMany Nilai` ordered by NIM via a raw subquery (`Laporan.php:20-26`); appended `bobot = matakuliah.nilai_jawaban / jumlah_soal` (`Laporan.php:28-33`) |
| `nilai` | `id`, `jawaban` (JSON array of per-question scores), `nilai_laporan`, `mahasiswa_id` (FK CASCADE), `laporan_id` (FK CASCADE) — migration `2023_06_10_081046_create_nilais_table.php:11-21` | `belongsTo Mahasiswa` and `Laporan`; appended `nilai_jawaban = round(sum(json_decode(jawaban)))` (`Nilai.php:24-29`); final displayed grade is `nilai_jawaban + nilai_laporan` (`resources/views/nilai/index.blade.php:23`) |

Scaffolding tables also exist: `users` (`app/Models/User.php`, uses `HasApiTokens`, `HasFactory`, `Notifiable`), `password_reset_tokens`, `failed_jobs`, `personal_access_tokens` (Sanctum tokens), and `migrations`. No app-owned controller reads `users`.

Tables queried with no migration and no dump: **none found** — every table read by a controller or model has a matching migration, including the raw `mahasiswa` subquery at `app/Models/Laporan.php:24`. No `.sql` dump is committed. `DatabaseSeeder.php:12-23` inserts only 2 `matakuliah` rows; the populated demo content (6 courses / 12 students / 9 reports / 54 grades) is in `database/seeders/DemoContentSeeder.php`.

## Auth

Session guard (`web` guard, `session` driver — `config/auth.php:16-19,38-40`) plus Sanctum v3.2.5 for the single API route (`routes/api.php:17`). No login implementation exists: no login route, controller, or view; `app/Http/Middleware/Authenticate.php:15` references `route('login')`, but no route named `login` is declared. No registration or password-reset UI either.

Only `GET /api/user` is protected (`auth:sanctum`, `routes/api.php:17`). The `web` middleware group carries encryption, session, CSRF and bindings but no `auth` middleware (`app/Http/Kernel.php:32-39`), so all 25 web routes are public, including grade entry and deletion. No global auth or API-key gate exists (`app/Http/Kernel.php:16-24`). CSRF is applied to the web forms via `@csrf` and `VerifyCsrfToken` (`app/Http/Kernel.php:37`).

## External services

- Database: default `mysql` in code (`config/database.php:18`, `inventory.json:1257`); a `pgsql` connection is configured (`:66-79`) and selected at runtime by `DB_CONNECTION` — in this workspace the deployed database is PostgreSQL `asdos-menilai-db`. Both `pdo_mysql` and `pdo_pgsql` are compiled into the image (`Dockerfile:6,23`). Env names: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
- Cache `file` (`config/cache.php:18`), session `file` (`config/session.php:21`), queue `sync` (`config/queue.php:16`), mail `smtp` (`config/mail.php:16`, no mail sent), filesystem `local` with an optional S3 disk (`config/filesystems.php:16,33-57`), broadcasting `null` (`config/broadcasting.php:18`). Config-only env names include `CACHE_DRIVER`, `SESSION_DRIVER`, `QUEUE_CONNECTION`, `MAIL_*`, `AWS_*`, `PUSHER_*`, `VITE_PUSHER_*`; names only, no values recorded.
- No third-party HTTP APIs, OAuth, payment, messaging or maps integrations in application code. The only external request is a client-side jQuery CDN tag on the two grade forms (`resources/views/nilai/create.blade.php:4`, `nilai/edit.blade.php:18`).
- Actual values are UNKNOWN — requires human input: `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, and `APP_KEY` above all (report §12).

## Operational risks

- `file` sessions and cache write to the local container filesystem (`storage/framework/sessions`, `storage/framework/cache`, created at `Dockerfile:34-35`). They are lost on pod restart and break above one replica without sticky sessions or a shared store; flash `status` messages and per-pod `storage/logs` have the same problem.
- DB driver mismatch: code default `mysql` points at `127.0.0.1:3306` (`config/database.php:49-51`), which does not exist in this workspace; correct operation depends on overriding `DB_CONNECTION` to `pgsql` at runtime.
- Boot side effects: `post-autoload-dump` runs `artisan package:discover` (`composer.json:36-39`). The Dockerfile mitigates this with `--no-scripts` on `composer install` (`Dockerfile:10`), but the separate `composer dump-autoload` (`Dockerfile:12`) can still fire it. No provider queries the DB at boot (`AppServiceProvider.php:20-23`). `php artisan storage:link` at build (`:13`) also boots the app.
- Every controller `catch (err $err)` references an undefined class `err`, so genuine exceptions are not converted into the intended "Gagal" flash and surface as 500s (`MatakuliahController.php:31`, `MahasiswaController.php:30`, `LaporanController.php:32`, `NilaiController.php:47`).
- Division by zero in the `bobot` accessor when `jumlah_soal` is 0 (`app/Models/Laporan.php:31`); the report create form sets no `min` on that field (`resources/views/laporan/create.blade.php:14`).
- The grade forms depend on jQuery from a public CDN; they lose their dropdown/weight behaviour if that host is unreachable.
- No queue or scheduler is started by the image, but none is needed: scheduler commented out, queue `sync`, no `ShouldQueue` or `dispatch` calls, no jobs table migration. Nothing silently goes un-run.
- No hardcoded credentials were found (`DB_PASSWORD` uses `env('DB_PASSWORD','')` — an empty default, not a secret). `APP_KEY` must be supplied via env, not baked into the image.
- UNKNOWN — requires human input: whether the deployment's database has `GRANT CREATE, USAGE ON SCHEMA public` applied, and whether the client-side CDN is reachable there.

## Container layout

Four build stages: `composer-bin`, `vendor` (`php:8.1-cli-alpine`; `composer install --no-dev --no-scripts --no-autoloader` at `Dockerfile:10`, then `composer dump-autoload --optimize --no-dev` at `:12`), `assets` (`node:24-alpine`; `npm install` `:17`, `npm run build` `:19`), and `runtime` (`php:8.1-fpm-alpine`, `:20`). The runtime adds nginx, supervisord, gettext, curl, and both `pdo_mysql` and `pdo_pgsql` (`:22-23`); writable directories are created and chowned to `www-data` (`:34-35`) and the process runs as `USER www-data` (`:37`). Vite assets are baked at build (`:27`).

This is **not** one of the six never-re-render repos, so regeneration from `Dockerfile.php-fpm` is expected to be reproducible. If the image is regenerated, preserve the dual DB drivers — `pdo_pgsql` is beyond the stock php-fpm template. Last recorded smoke: `boot=PASS http=302 db=skipped` (`CONTAINERIZE.md:39-40`).
