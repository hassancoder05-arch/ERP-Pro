# ERP Pro

A modern and responsive Enterprise Resource Planning (ERP) system built with Laravel, MySQL, Bootstrap, and Livewire.

## Features

* Authentication & Authorization
* Role-Based Access Control
* Dashboard
* Employee Management
* Customer Management
* Supplier Management
* Product Management
* Inventory Management
* Stock IN / OUT
* Inventory History
* Sales Management
* Invoice Generation
* Invoice PDF
* Income Management
* Expense Management
* Expense Categories
* Customer & Supplier Payments
* Finance Dashboard
* Reports
* Accounting
* Notifications & Stock Alerts
* Admin Settings
* Security Middleware

## User Roles

### Admin

Full system access including Settings and user management capabilities.

### Manager

Access to major business and operational modules.

### Sales

Access to customers, products, inventory, and sales modules.

### Accountant

Access to finance, accounting, payments, and reports.

## Technology Stack

* Laravel 12
* PHP 8.2
* MySQL / MariaDB
* Bootstrap 5
* Bootstrap Icons
* Livewire 3
* Blade
* Vite
* JavaScript
* HTML5
* CSS3

## Main Modules

```text
Dashboard
Employees
Customers
Suppliers
Products
Inventory
Sales
Finance
Accounting
Reports
Notifications
Settings
```

## Requirements

* PHP 8.2+
* Composer
* Node.js & NPM
* MySQL / MariaDB
* XAMPP or another PHP development environment

## Installation

Clone or copy the project:

```bash
git clone YOUR_REPOSITORY_URL
cd ERP-Pro
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create environment file:

```bash
copy .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure the database in `.env`.

Run migrations:

```bash
php artisan migrate
```

Create storage link:

```bash
php artisan storage:link
```

Build frontend assets:

```bash
npm run build
```

Clear application cache:

```bash
php artisan optimize:clear
```

Start the development server:

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Security

* CSRF protection
* Password hashing
* Role-based authorization
* Request validation
* Session regeneration on logout
* Security response headers
* Environment secrets stored in `.env`
* `.env` excluded from Git

## Project Status

ERP Pro is a full-stack ERP application developed as a professional portfolio project.

## Developer

Hassan Mehmood

Full-Stack Web Developer
