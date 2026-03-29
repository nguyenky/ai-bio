# Deployment Plan

This project is prepared for:

- private GitHub repository
- pull request based workflow
- GitHub Actions CI on every PR to `main`
- deployment from `main` after merge

## GitHub Flow

1. Initialize Git locally:

```bash
git init
git branch -M main
git add .
git commit -m "Initial AI Bio app"
```

2. Create a private GitHub repository.

3. Push the code:

```bash
git remote add origin <your-private-repo-url>
git push -u origin main
```

4. Use this branch workflow:

- create a feature branch from `main`
- open a pull request into `main`
- let GitHub Actions run CI
- merge into `main`

## CI

GitHub Actions workflow:

- file: `.github/workflows/ci.yml`
- trigger: `pull_request` to `main`
- checks:
  - `composer validate --no-check-publish`
  - `composer install`
  - `php artisan test`

## Production Setup

This app now defaults to SQLite. That means your production server must have:

- a writable `database/` directory
- a persistent filesystem for the SQLite file
- PHP with `pdo_sqlite` enabled

If your host wipes the filesystem on each deploy, SQLite data will be recreated and you can lose content. In that setup, use a host with persistent disk or switch back to MySQL/PostgreSQL later.

Laravel Cloud is not a good fit for persistent SQLite production data because its environment filesystems are ephemeral. Keep SQLite for local development or deploy this SQLite version to a VPS / host with persistent writable storage instead.

## Production Environment Variables

Use `.env.production.example` as the reference for production values.

Important values:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=<production-url>`
- `DB_CONNECTION=sqlite`
- leave `DB_DATABASE` unset to use Laravel's default `database/database.sqlite`
- `FILESYSTEM_DISK=local`
- `UPLOADS_DISK=public`
- `SEED_DEMO_CONTENT=false`

Do not keep a long-lived production admin password in deploy config.

## Deploy Command

Run these commands during deployment:

```bash
php artisan app:prepare-sqlite
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## First Production Admin User

After the first successful deploy, create the admin user manually:

```bash
php artisan app:create-admin admin@example.com --name="Site Owner" --password="your-strong-password"
```

## Production Smoke Check

After the first live deployment:

- homepage loads
- blog list loads
- post detail loads
- admin login works
- admin database page shows the SQLite file as ready
