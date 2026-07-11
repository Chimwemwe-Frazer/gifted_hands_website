# Gifted Hands Clinic Management System

A Laravel clinic administration system built from the Must Systems starter kit. It keeps the starter kit's authentication, dashboard shell, Tailwind CSS styling, Alpine.js interactions, and role-based authorization, then adds clinic-focused records for patients, services, and appointments.

## Features

- Secure login and password management
- Admin dashboard with clinic activity counts
- Role-based authorization with Spatie permissions
- Patient registration and medical notes
- Clinic service catalogue
- Appointment scheduling with practitioner assignment
- User, role, and permission administration
- Responsive Blade dashboard styled with Tailwind CSS

## Requirements

- PHP >= 8.2
- Composer
- Node.js and npm
- MySQL/MariaDB

## Installation

1. Install PHP dependencies:

```bash
composer install
```

2. Install Node.js dependencies:

```bash
npm install
```

3. Copy the environment file and configure database credentials:

```bash
cp .env.example .env
```

4. Generate the application key:

```bash
php artisan key:generate
```

5. Run migrations and seed the default admin permissions:

```bash
php artisan migrate --seed
```

6. Start the Laravel server, queue listener, logs, and Vite:

```bash
composer run dev
```

## Default Login

- Email: promisemphoola2@gmail.com
- Password: 1234567890

## Main Admin Modules

- Dashboard: clinic counts and upcoming appointments
- Patients: demographic details, contacts, emergency contact, notes, status
- Services: service name, description, duration, fee, status
- Appointments: patient, service, practitioner, date/time, status, reason, notes
- Access Control: users, roles, and permissions

## Useful Commands

```bash
php artisan serve
php artisan migrate
php artisan migrate:fresh --seed
npm run dev
npm run build
```

## Project Structure

```text
app/                 Core application models, controllers, and providers
config/              Laravel and package configuration
database/            Migrations, factories, and seeders
public/              Public assets
resources/           Blade views, CSS, and JavaScript
routes/              Route definitions
tests/               Automated tests
```
