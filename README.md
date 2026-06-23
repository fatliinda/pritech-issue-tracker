# PRITECH Mini Issue Tracker

Laravel technical task implementation for a **Mini Issue Tracker**.

## Features

- Project CRUD
- Project detail page with related issues
- Issue CRUD
- Issue filters by status, priority, tag, and text search
- Tag creation with unique names
- AJAX attach/detach tags on issue detail page
- AJAX paginated comments on issue detail page
- AJAX comment creation with validation errors rendered on the page
- Eloquent relationships with eager loading to avoid N+1 queries
- Migrations, factories, and seeders for demo data
- Additional `start_date` and `deadline` fields added to projects using a separate migration

## Tech Stack

- Laravel 13
- PHP 8.3+
- MySQL
- Blade
- Vanilla JavaScript Fetch API
- Bootstrap 5 CDN

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create a MySQL database:

```sql
CREATE DATABASE pritech_issue_tracker;
```

Update `.env` if needed:

```env
DB_DATABASE=pritech_issue_tracker
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seeders:

```bash
php artisan migrate:fresh --seed
```

Start the server:

```bash
php artisan serve
```

Open:

```txt
http://127.0.0.1:8000
```

## Main URLs

```txt
/projects
/issues
/tags
```

Run `composer install` locally before testing.
