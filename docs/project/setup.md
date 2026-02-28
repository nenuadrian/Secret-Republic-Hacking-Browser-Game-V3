# Setup

The canonical setup instructions live in `README.md` under **Simple-Setup** and **Cron jobs**.

## Fast Path

1. Install PHP + Composer + MySQL.
2. Run `composer install`.
3. Create a MySQL database.
4. Finish setup via `/public_html/setup` or manual SQL import + config file.

## Manual Essentials

- Import `includes/install/DB.sql`.
- Create `includes/database_info.php` from `includes/database_info.php.template`.
- Promote your first user to admin (`user_credentials.group_id = 1`).

## Cron Endpoints

The app expects periodic cron invocations (attacks, hourly, daily, rankings, resources). See README for exact URLs and schedules.
