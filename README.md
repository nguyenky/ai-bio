# AI Bio

Personal blog web app built with Laravel, Blade, Bootstrap 5, and Alpine.js. It includes a public editorial-style homepage, blog/news pages, and a simple single-admin back office for managing posts, homepage settings, and curated Instagram items.

## Stack

- PHP 8.3
- Laravel 13
- Blade templates
- Bootstrap 5 with custom CSS theme
- Alpine.js
- SQLite by default
- Local/public uploads by default

## Features

- Public homepage with intro, featured post, recent posts, and Instagram grid
- Blog listing page
- Blog detail page
- Admin login for a single site owner
- Post CRUD with publish and featured toggles
- Instagram item CRUD with upload or external image URL
- Bulk Instagram link import with best-effort public metadata fetch
- Homepage/settings editor for intro copy, social links, profile image, and SEO
- SQLite-first setup with automatic database-file creation

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

3. Run migrations and create the public storage link:

```bash
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

This app is prepared to run with SQLite in environments that provide a persistent writable filesystem:

- keep `DB_CONNECTION=sqlite`
- let Laravel use `database/database.sqlite`
- make sure the `database/` directory is writable
- do not seed demo content in production
- create the first admin user with the Artisan command instead of storing a permanent admin password in deploy config

Laravel Cloud is not suitable for persistent SQLite production storage because its filesystem resets across deployments. If you stay on SQLite in production, deploy to a VPS or another host with persistent disk.

Example production environment settings live in [.env.production.example](/Users/kyle/workspaces/kyle/openai/ai-bio/.env.production.example).

Before running migrations in a fresh environment, make sure the SQLite file exists:

```bash
php artisan app:prepare-sqlite
```

To create the initial production admin user after the first deploy:

```bash
php artisan app:create-admin admin@example.com --name="Site Owner" --password="your-strong-password"
```

## Upload Storage

The app now uses `UPLOADS_DISK` for user-uploaded media:

- local development: `UPLOADS_DISK=public`
- production default: `UPLOADS_DISK=public`

If you later move to object storage, you can switch `UPLOADS_DISK` without changing the content-management UI.

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
php artisan app:prepare-sqlite
php artisan app:create-admin admin@example.com --name="Site Owner" --password="your-strong-password"
```
