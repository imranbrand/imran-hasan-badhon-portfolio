# Imran Hasan Badhon, Laravel Blade portfolio

Dark 3D developer portfolio for job applications and freelance clients.
Laravel 11 or newer (PHP 8.2+), Blade views, plain CSS and JavaScript (no npm build step).

## What is inside

| Part | File |
| --- | --- |
| All text, projects, skills, links | `config/portfolio.php` (edit this file to change the site) |
| Routes | `routes/web.php` (`/`, `/projects/{slug}`, `/cv`, `POST /contact`) |
| Controllers | `app/Http/Controllers/PortfolioController.php`, `ContactController.php` |
| Contact validation (with honeypot) | `app/Http/Requests/ContactRequest.php` |
| Stored messages | `app/Models/ContactMessage.php` + migration |
| Read messages in terminal | `php artisan portfolio:messages` (`--all`, `--read`) |
| Views | `resources/views/layouts`, `pages`, `partials` |
| 3D styling and behaviour | `public/css/portfolio.css`, `public/js/portfolio.js` |
| Tests | `tests/Feature/PortfolioTest.php` |

Pages: home (hero, about, services, projects, Vision Lab, skills, education, contact) and one case-study page per project.

## Run locally

    php artisan migrate
    php artisan serve
    php artisan test

Open http://127.0.0.1:8000

## Edit content

Open `config/portfolio.php`. Set `projects[].link` to a live URL when IBL CART 24 is public, and change `profile.status` or `profile.available` as your situation changes.

## Email notifications (optional)

Messages are always saved in the database. To also receive them by email, set real SMTP values in `.env` (`MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`) and:

    PORTFOLIO_NOTIFY_EMAIL=imranhasan10022@gmail.com

## Before going live

1. `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://your-domain.com`.
2. Replace `public/images/og.jpg` text if you want your real domain on the share image.
3. Run once on the server:

       composer install --no-dev --optimize-autoloader
       php artisan key:generate   (only if APP_KEY is empty)
       php artisan migrate --force
       php artisan config:cache && php artisan route:cache && php artisan view:cache

4. Point the web root to the `public` folder.
   - VPS (Nginx or Apache): set the document root to `.../public`.
   - cPanel: upload the project one level above `public_html`, then copy the contents of `public/` into `public_html/` and edit the two paths in `public_html/index.php` (`__DIR__.'/../vendor/autoload.php'` and `__DIR__.'/../bootstrap/app.php'`) so they point to your project folder.
   - Vercel does not run PHP/Laravel natively, so use cPanel, a VPS, or a PHP host such as Railway or Render instead.
5. Make `storage/` and `bootstrap/cache/` writable by the web server.
6. Keep HTTPS on. The contact form is rate limited (5 per minute per visitor).
