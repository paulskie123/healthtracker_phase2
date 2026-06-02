# HealthTracker Phase 2

This is a PHP web app for tracking personal health details. It was built with a small home-grown MVC setup, and it helps patients keep track of health metrics, medications, and appointments.

## What this app does

From one place, a patient can:

- sign up and sign in
- turn on two-factor authentication (2FA)
- add, edit, view, and delete health records
- export those records to CSV
- manage medications and treatment schedules
- keep appointment details and upcoming visits
- check BMI and progress summaries
- update profile settings

## How it is built

The app lives inside `healthtracker/` and follows a simple MVC-like structure:

- `healthtracker/public/index.php` handles every request and maps `?page=` values to controller actions
- `healthtracker/app/controllers/` contains the application's controllers
- `healthtracker/app/models/` contains classes for database access
- `healthtracker/app/views/` contains the PHP templates shown in the browser
- `healthtracker/config/config.php` stores the database and app config

## What it uses

Composer is used for external libraries.

- `bacon/bacon-qr-code` generates QR codes for 2FA
- `pragmarx/google2fa-qrcode` does the 2FA secret and code checks

## Setup steps

1. Run Composer from the repository root:

```bash
composer install
```

2. Edit `healthtracker/config/config.php` if your MySQL credentials are different:

```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'healthtracker');
define('DB_USER', 'root');
define('DB_PASS', '');
```

3. Create the database and tables manually. The app does not include an installer.

### Database schema example

```sql
CREATE DATABASE IF NOT EXISTS healthtracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE healthtracker;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'patient',
  allergies TEXT DEFAULT 'None',
  plan VARCHAR(100) DEFAULT 'Basic Member',
  two_fa_secret VARCHAR(255) DEFAULT NULL,
  two_fa_enabled TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE health_records (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  date DATE NOT NULL,
  systolic_bp INT NOT NULL,
  diastolic_bp INT NOT NULL,
  heart_rate INT NOT NULL,
  weight DECIMAL(8,2) NOT NULL,
  blood_sugar DECIMAL(8,2) NOT NULL,
  notes TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE medications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  type VARCHAR(100) NOT NULL,
  dosage VARCHAR(100) NOT NULL,
  schedule VARCHAR(255) NOT NULL,
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL,
  prescriber VARCHAR(255) DEFAULT NULL,
  notes TEXT,
  status VARCHAR(50) DEFAULT 'Active',
  icon VARCHAR(10) DEFAULT '💊',
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  doctor VARCHAR(255) NOT NULL,
  specialty VARCHAR(255) NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  location VARCHAR(255) DEFAULT NULL,
  type VARCHAR(100) DEFAULT 'Check-up',
  status VARCHAR(100) DEFAULT 'Scheduled',
  notes TEXT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

> The app expects a MySQL database named `healthtracker` and, by default, uses `root` with no password.

## Running the app locally

From the repository root:

```bash
php -S localhost:8000 -t healthtracker/public
```

Then open this URL in your browser:

```
http://localhost:8000/index.php?page=login
```

## Pages you can visit

The router maps `?page=` values to actions inside `healthtracker/public/index.php`.

Available pages:

- `login`
- `register`
- `logout`
- `setup-2fa`
- `verify-2fa`
- `dashboard`
- `progress`
- `reminders`
- `profile`
- `settings`
- `bmi`
- `health-records`
- `health-records-create`
- `health-records-store`
- `health-records-edit`
- `health-records-update`
- `health-records-delete`
- `health-records-view`
- `medication`
- `medication-create`
- `medication-store`
- `medication-edit`
- `medication-update`
- `medication-delete`
- `appointments`
- `appointments-create`
- `appointments-store`
- `appointments-edit`
- `appointments-update`
- `appointments-delete`

## Notes

- Protected pages require a logged-in user.
- Health records can be exported directly to a CSV file.
- The 2FA flow uses a QR code and a time-based code.
- Sessions are handled through PHP's native session system.

## Possible improvements

- Add database migrations or a setup script.
- Improve validation and add CSRF protection.
- Add a password reset flow.
- Add roles beyond the default patient account.