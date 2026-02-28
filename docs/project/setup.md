# Setup

The canonical setup instructions live in `README.md` under **Simple-Setup** and **Cron jobs**.

## Fast Path

1. Install PHP + Composer + a database (MySQL or local SQLite).
2. Run `composer install`.
3. If using MySQL, create a MySQL database.
4. Finish setup via `/public_html/setup` (choose `MYSQL` or `SQLITE (LOCAL FILE)`) or manual SQL import + config file.

## Manual Essentials

- Import `includes/install/DB.sql` (MySQL mode).
- Create `includes/database_info.php` from `includes/database_info.php.template` and set:
  - `driver = 'mysql'` with host/user/password/name/port, or
  - `driver = 'sqlite'` with `sqlite_path`.
- Promote your first user to admin (`user_credentials.group_id = 1`).

## Cron Endpoints

The app expects periodic cron invocations (attacks, hourly, daily, rankings, resources). See README for exact URLs and schedules.
