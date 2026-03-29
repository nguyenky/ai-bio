# Deployment Plan

This project is prepared for:

- private GitHub repository
- pull request based workflow
- GitHub Actions CI on every PR to `main`
- Laravel Cloud production auto-deploy from `main`

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

## Laravel Cloud Setup

1. Create a Laravel Cloud project.
2. Connect the GitHub repository.
3. Create one production environment.
4. Set `main` as the auto-deploy branch.
5. Attach a managed MySQL database.
6. Attach Laravel Object Storage or another S3-compatible bucket.

## Production Environment Variables

Use `.env.production.example` as the reference for production values.

Important values:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=<production-url>`
- `DB_CONNECTION=mysql`
- production database credentials from Laravel Cloud
- `FILESYSTEM_DISK=s3`
- `UPLOADS_DISK=s3`
- `SEED_DEMO_CONTENT=false`

Do not keep a long-lived production admin password in deploy config.

## Deploy Command

Use this Laravel Cloud deploy command:

```bash
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
- create one upload and confirm it still renders after redeploy
