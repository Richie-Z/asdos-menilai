# CONTAINERIZE - Solo/asdos-menilai

Archetype: laravel. Generated 2026-11-20T22:42:21+07:00 by .opencode/scripts/render.sh on branch chore/containerize (uncommitted).

## Generated files
- Dockerfile (template: Dockerfile.php-fpm)
- Jenkinsfile (CI only; parameters REGISTRY, HARBOR_PROJECT, HARBOR_CRED_ID)
- .dockerignore
- .containerize/nginx-fpm.conf.template
- .containerize/supervisord.conf
- .containerize/php-fpm-pool.conf
- .containerize/entrypoint-fpm.sh

## Local run
```sh
bash .opencode/scripts/build.sh Solo/asdos-menilai
bash .opencode/scripts/smoke.sh Solo/asdos-menilai
```
Manual run: podman run --rm --network=host --env-file /home/richie/Documents/Programming/Projects/.smoke.env -e PORT=<free-port> containerize/asdos-menilai:local

## Required env var NAMES (values never stored here)
APP_DEBUG APP_ENV APP_KEY APP_NAME APP_URL AWS_ACCESS_KEY_ID AWS_BUCKET AWS_DEFAULT_REGION AWS_SECRET_ACCESS_KEY AWS_USE_PATH_STYLE_ENDPOINT BROADCAST_DRIVER CACHE_DRIVER DB_CONNECTION DB_DATABASE DB_HOST DB_PASSWORD DB_PORT DB_USERNAME FILESYSTEM_DISK LOG_CHANNEL LOG_DEPRECATIONS_CHANNEL LOG_LEVEL MAIL_ENCRYPTION MAIL_FROM_ADDRESS MAIL_FROM_NAME MAIL_HOST MAIL_MAILER MAIL_PASSWORD MAIL_PORT MAIL_USERNAME MEMCACHED_HOST PUSHER_APP_CLUSTER PUSHER_APP_ID PUSHER_APP_KEY PUSHER_APP_SECRET PUSHER_HOST PUSHER_PORT PUSHER_SCHEME QUEUE_CONNECTION REDIS_HOST REDIS_PASSWORD REDIS_PORT SESSION_DRIVER SESSION_LIFETIME VITE_PUSHER_APP_CLUSTER VITE_PUSHER_APP_KEY VITE_PUSHER_HOST VITE_PUSHER_PORT VITE_PUSHER_SCHEME 

## Build-arg NAMES (baked at build, non-secret values only)
VITE_PUSHER_APP_KEY
VITE_PUSHER_HOST
VITE_PUSHER_PORT
VITE_PUSHER_SCHEME
VITE_PUSHER_APP_CLUSTER

## DB smoke
boot + healthcheck only (DB not smoke-tested). db_driver: mysql. Never migrate/seed/modify; DBs are live.

## Flags
- PHP 8.1: FrankenPHP image is unpublished upstream; using php-fpm-alpine instead
- verify agent (composer:2, PHP 8.4) newer than repo PHP 8.1: composer install uses --ignore-platform-req=php (lint only)
- agent label 'php' unverified on k3s Jenkins - confirm with user

Smoke results: 2026-11-20T23:07:36+07:00 boot=PASS http=302 db=skipped (artisan db:show not available on this framework version; no read-only DB check)
Smoke results: 2026-11-22T00:53:55+07:00 boot=PASS http=302 db=skipped (artisan db:show not available on this framework version; no read-only DB check)
