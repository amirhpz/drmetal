# Dr Metalinium

Persian RTL Laravel website and lightweight management panel for an aluminium products company.

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
```

## Panel User

The panel seeder does not create a default public credential. To seed an initial panel user locally, set these values in `.env` before running `php artisan db:seed`:

```ini
PANEL_ADMIN_EMAIL=
PANEL_ADMIN_PASSWORD=
```

Use a strong unique password. Do not commit `.env`.

## Local PHP

This project requires PHP 8.3 or newer. On this machine, use Herd PHP rather than XAMPP PHP:

```powershell
C:\Users\Amir\.config\herd\bin\php83\php.exe artisan serve --host=127.0.0.1 --port=8001
```

For uploads, ensure `upload_tmp_dir` is writable.

## Verification

```bash
php artisan test
npm run build
```

## Security

- `.env`, local databases, logs, `vendor`, `node_modules`, build output, and uploaded files are ignored.
- No default admin credentials are committed.
