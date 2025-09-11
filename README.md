# SimpleTime OS

Self-hosted time tracker built with Laravel 12 and Hotwire. Single-user, no bloat, MIT licensed.

![SimpleTime OS Dashboard](public/screenshots/dashboard.png)

## What it is

A time tracker for freelancers and consultants who need to track billable hours. Built for one person, not teams. Your data stays on your server.

Good fit if you:
- Bill by the hour and need simple time tracking
- Want to self-host and own your data
- Like clean Laravel codebases
- Don't need project management features or team collaboration

Not for you if you need multi-user support or enterprise features

## Features

### Timer
![Running Timer](public/screenshots/time-running-dashboard.png)

One-click start/stop, keyboard shortcuts (`Ctrl+Shift+S/T/Space`), survives page refreshes. Only one timer runs at a time.

### Clients & Projects
![Create Client On The Fly](public/screenshots/start-tracking-with-new-client-dashboard.png)

Create clients/projects inline while starting a timer. Set hourly rates at client or project level (56 currencies). Project rates override client rates.

### Reports
![Reports and CSV Export](public/screenshots/reports.png)

Filter by date range, client, or project. Export to CSV. Multi-currency totals.

### Preferences
Choose date format (US/UK/EU) and time format (12/24-hour). Applies everywhere in the app.

## Tech Stack

**Backend:** Laravel 12, PHP 8.4, SQLite/MySQL/PostgreSQL
**Frontend:** Hotwire Turbo, Stimulus, Tailwind + DaisyUI, Importmap
**Testing/QA:** PHPUnit, Pint, Larastan, Rector

Hotwire means SPA-like UX without heavy JS. Importmap means no build step for JavaScript.

## Installation

Requires PHP 8.4+

```bash
git clone <repository-url>
cd simple
./install.sh
php artisan app:create-user
php artisan serve
```

Manual install steps in `install.sh` if you prefer to do it yourself

## Common Commands

```bash
# User management
php artisan app:create-user
php artisan user:reset-password user@email.com

# Development
php artisan serve
php artisan migrate
php artisan optimize:clear  # Clear all caches when things break
```

## Single User Setup

App is designed for one user. Registration is disabled after first user is created.

Create account after install:
```bash
php artisan app:create-user
```

Reset password if needed:
```bash
php artisan user:reset-password your-email@example.com
```

Need a second user for testing? Use `php artisan app:create-user --force`

## Usage

Start timer from dashboard - pick client/project, hit play or `Ctrl+Shift+S`. Create clients inline while starting a timer.

Reports page lets you filter and export to CSV. Set your preferred date/time formats in Settings.

## Configuration

Main settings in `.env`:
```env
DB_CONNECTION=sqlite
APP_TIMEZONE=UTC  # Set to your timezone
```

User preferences (date/time formats, hourly rates) configurable in Settings page.

## Contributing

PRs welcome. Standard fork → branch → PR workflow.

If you're good with UI/UX and want to help make it more minimal/clean, that'd be great.

## License

MIT licensed - do what you want with it.

## Support

Open an issue if something breaks. Common fixes:
- Forgot password: `php artisan user:reset-password your-email@example.com`
- App errors: `php artisan optimize:clear`

## Future Plans

Core stays free and open source. Might add optional paid features later to support development, but the base app will always be MIT licensed.
