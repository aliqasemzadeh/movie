# QuickPanel

QuickPanel is a modern admin panel starter built on the TALL stack (Tailwind CSS, Alpine.js, Laravel, Livewire). It ships with authentication, authorization, localization, beautiful datagrids, modals/toasts, and developer tooling to help you start building dashboards and back-office applications quickly.

## Tech Stack
- PHP ^8.2, Laravel ^12
- Livewire ^3 (SPA-like interactions without heavy JS)
- Tailwind CSS + Vite
- Alpine.js
- Spatie Laravel Permission ^6 (roles/permissions)
- PowerGrid ^6 (tables, filters, export)
- Livewire Modal (elegantly/livewire-modal)
- Livewire Toaster (masmerise/livewire-toaster)
- Localization: mcamara/laravel-localization, laravel-lang/common
- Social login: laravel/socialite
- Log management: opcodesio/log-viewer

## Requirements
- PHP 8.2+
- Composer
- Node.js 18+ (20+ recommended) and npm
- A database (MySQL/MariaDB/PostgreSQL/SQLite). SQLite works out of the box in dev.
- Redis (optional) for queues/caching

## Getting Started
1) Clone and install dependencies
- git clone <your-repo-url> quickpanel
- cd quickpanel
- composer install
- npm install

2) Environment
- cp .env.example .env (on Windows: copy .env.example .env)
- Set DB connection in .env (or use SQLite by setting DB_CONNECTION=sqlite)
- Set APP_NAME, APP_URL (for example http://localhost:8000), MAIL_ settings for email verification

3) App key and database
- php artisan key:generate
- If using SQLite, ensure database/database.sqlite exists (create an empty file)
- php artisan migrate
- (Optional) php artisan db:seed if you add seeders for roles/users

4) Run the app (two options)
- Separate terminals:
  - php artisan serve
  - php artisan queue:listen --tries=1
  - npm run dev
- Or one command using Composer script:
  - composer run dev
  This uses npx concurrently to run server, queue listener, and Vite.

Open http://localhost:8000 (or your APP_URL).

## Features at a Glance
- Authentication with email verification (Livewire components under resources/views/livewire/auth)
- User dashboard and settings (including password change)
- Role/Permission integration via Spatie Permission
- DataTables/Grids via PowerGrid (filters, export, actions)
- Modals and toast notifications for great UX
- Multi-language and locale-aware routes via Laravel Localization
- Optional social authentication via Socialite
- Log Viewer at /log-viewer (guard as needed)

## Configuration Notes
- Queues: The development script uses queue:listen. For production, use a supervisor with queue:work.
- Localization:
  - mcamara/laravel-localization adds localized routes. Configure locales in config/laravellocalization.php.
  - laravel-lang/common provides language lines. Your custom lines are under lang/<locale>/quickpanel.php
- Permissions:
  - After defining roles/permissions, consider seeding them and calling php artisan permission:cache-reset when changing them.
- Socialite: Add provider credentials to .env (e.g., GITHUB_CLIENT_ID, GITHUB_CLIENT_SECRET, GITHUB_REDIRECT_URL) and wire up controllers/routes.
- Log Viewer: opcodesio/log-viewer exposes a UI to browse logs. Protect the route in production.

## Scripts
- composer run dev: Runs PHP server, queue listener, and Vite together.
- composer test: Clears config and runs test suite.
- npm run dev: Vite dev server.
- npm run build: Production assets build.

## Testing
- php artisan test
- or composer test

## Troubleshooting
- Vite HMR issues: Ensure APP_URL matches the URL you use and that npm run dev is running. If behind proxies, set ASSET_URL.
- Email verification: Configure MAIL_MAILER, MAIL_HOST, MAIL_USERNAME, etc. For local dev, use Mailpit or log mailer.
- Queue not processing: Ensure queue:listen/queue:work is running and QUEUE_CONNECTION is set (database or redis).
- Permission changes not taking effect: php artisan permission:cache-reset
- Windows path issues: Use backslashes in system paths; Laravel handles URLs with forward slashes.

## Directory Hints
- Livewire components: app/Livewire and resources/views/livewire
- Layouts: resources/views/layouts
- Language files: lang/
- Routes: routes/

## Security & Contributions
Please open issues or PRs in this repository. For security concerns, contact the maintainer privately and avoid filing public issues with exploit details.

## License
MIT License. See LICENSE file if present; otherwise assume MIT per composer.json.
