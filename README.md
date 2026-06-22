# ReRead

ReRead is a PHP and MySQL book exchange platform where users can list books, browse available titles, reserve items, chat with other users, manage wishlists, and follow community discussions. The project also includes an admin dashboard for approving listings, reviewing reports, and monitoring platform activity.

## Features

- User registration, login, password recovery, and profile management
- Book listing and approval workflow for sellers
- Browse, search, wishlist, reserve, and purchase flow for books
- User-to-user chat and community messaging
- Notifications for approvals, reservations, cancellations, and updates
- Admin dashboard for users, book listings, archived items, and community reports

## Tech Stack

- PHP
- MySQL
- HTML, CSS, and JavaScript
- Bootstrap and icon/CDN assets for parts of the UI

## Project Structure

- `commonconnect.php` - shared database connection
- `user/` - user-facing pages for login, products, cart, wishlist, chat, notifications, community, and profile
- `admin/` - admin dashboard, moderation, product approval, and reporting pages
- `userinfo (27).sql` - database dump for the `userinfo` database

## Requirements

- PHP 8.x or compatible
- MySQL / MariaDB
- Apache or another PHP-capable web server
- A local environment such as XAMPP, WAMP, or Laragon

## Setup

1. Place the project folder in your web server root, for example `htdocs/miniproject`.
2. Create a MySQL database named `userinfo`.
3. Import `userinfo (27).sql` into that database.
4. Verify the database credentials in `commonconnect.php`.
   - Current connection values:
     - host: `localhost`
     - user: `root`
     - password: empty
     - database: `userinfo`
5. Open the project in your browser through the server, for example:
   - `http://localhost/miniproject/user/welcomepage/homepage.php`

## Default Entry Points

- User homepage: `user/welcomepage/homepage.php`
- User login: `user/login/login.php`
- Seller product submission: `user/sellproduct/sellproduct.php`
- Admin dashboard: `admin/adminpage/adminhome.php`

## Notes

- Some pages expect the session and database schema from the imported SQL file.
- The admin dashboard uses `tbl_products`, `tbl_users`, and `tbl_reports` counts, so the database import must be complete.
- Uploaded images and chat/community content are stored in the database in several tables.

## Troubleshooting

- If the site shows a database connection error, check `commonconnect.php` and confirm MySQL is running.
- If pages redirect to login unexpectedly, clear browser cookies or verify session handling in your PHP environment.
- If images or assets do not load, confirm the project path is exactly `/miniproject` or update the hardcoded paths accordingly.
