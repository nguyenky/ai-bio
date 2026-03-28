# AI Bio

Personal blog web app built with Laravel, Blade, Bootstrap 5, and Alpine.js. It includes a public editorial-style homepage, blog/news pages, and a simple single-admin back office for managing posts, homepage settings, and curated Instagram items.

## Stack

- PHP 8.3
- Laravel 13
- Blade templates
- Bootstrap 5 with custom CSS theme
- Alpine.js
- MySQL in local and production
- S3-compatible object storage for persistent production uploads

## Features

- Public homepage with intro, featured post, recent posts, and Instagram grid
- Blog listing page
- Blog detail page
- Admin login for a single site owner
- Post CRUD with publish and featured toggles
- Instagram item CRUD with upload or external image URL
- Bulk Instagram link import with best-effort public metadata fetch
- Homepage/settings editor for intro copy, social links, profile image, and SEO
- Portable migrations that avoid database-vendor-specific schema behavior

## Main Routes

- `/`
- `/posts`
- `/posts/{slug}`
- `/admin/login`
- `/admin`
- `/admin/posts`
- `/admin/instagram-items`
- `/admin/settings`

## Local Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Copy environment settings if needed:

```bash
cp .env.example .env
php artisan key:generate
```

3. Create the local MySQL database and run migrations:

```bash
mysql -uroot -e "CREATE DATABASE IF NOT EXISTS ai_bio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate:fresh --seed
php artisan storage:link
```

4. Start the local server:

```bash
php artisan serve
```

## Local Admin Login

The local admin account is seeded from `.env` when `APP_ENV` is not `production` and `ADMIN_PASSWORD` is set.

- Email: `ADMIN_EMAIL`
- Password: `ADMIN_PASSWORD`

Current local defaults:

- Email: `admin@example.com`
- Password: `password`

## Production Notes

This app is prepared for Laravel Cloud style deployment:

- keep production on MySQL
- use object storage for uploads because production filesystems are ephemeral
- do not seed demo content in production
- create the first admin user with the Artisan command instead of storing a permanent admin password in deploy config

Example production environment settings live in [.env.production.example](/Users/kyle/workspaces/kyle/openai/ai-bio/.env.production.example).

To create the initial production admin user after the first deploy:

```bash
php artisan app:create-admin admin@example.com --name="Site Owner"
```

## Upload Storage

The app now uses `UPLOADS_DISK` for user-uploaded media:

- local development: `UPLOADS_DISK=public`
- production: `UPLOADS_DISK=s3`

This lets the app keep simple local uploads while storing persistent production files in S3-compatible object storage.

## Demo Content

Set `SEED_DEMO_CONTENT=true` in `.env` to seed example posts and Instagram items for local review. Set it to `false` for a clean content database. Production should keep this `false`.

## CI

GitHub Actions CI is defined in [ci.yml](/Users/kyle/workspaces/kyle/openai/ai-bio/.github/workflows/ci.yml) and runs on pull requests targeting `main`:

- `composer validate --no-check-publish`
- `composer install`
- `php artisan test`

## Useful Commands

```bash
php artisan route:list
php artisan test
php artisan view:cache
php artisan migrate:fresh --seed
php artisan app:create-admin admin@example.com --name="Site Owner"
```
