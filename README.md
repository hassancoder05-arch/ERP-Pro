# ERP Pro

> A modern Enterprise Resource Planning (ERP) system built with Laravel, MySQL, Bootstrap, and Livewire.

## Overview

ERP Pro is a full-stack business management application designed to manage core business operations from a centralized dashboard.

The system includes inventory management, products, customers, suppliers, sales, invoicing, finance, accounting, reports, notifications, and role-based access control.

## Features

### Dashboard

* Business overview
* Sales statistics
* Inventory statistics
* Low-stock alerts
* Out-of-stock alerts

### Product Management

* Product CRUD
* Product categories
* Brands
* Purchase and selling prices
* Stock tracking
* Minimum-stock thresholds

### Inventory Management

* Stock IN
* Stock OUT
* Stock validation
* Inventory transaction history
* Stock-before and stock-after tracking
* Low-stock monitoring

### Sales & Invoicing

* Customer sales
* Sale items
* Automatic stock deduction
* Invoice generation
* Invoice details
* PDF invoice

### Customers & Suppliers

* Customer management
* Supplier management
* Contact information
* Balance tracking
* Protected deletion for records linked to transactions

### Finance

* Income management
* Expense management
* Expense categories
* Customer payments
* Supplier payments
* Finance dashboard

### Accounting & Reports

* Accounting dashboard
* Business reports
* Financial summaries
* Transaction-based reporting

### Authentication & Security

* Authentication
* Role-based authorization
* CSRF protection
* Request validation
* Password hashing
* Session regeneration
* Security headers
* Protected environment configuration

## User Roles

| Role       | Access                                   |
| ---------- | ---------------------------------------- |
| Admin      | Full system access                       |
| Manager    | Business and operational modules         |
| Sales      | Customers, Products, Inventory and Sales |
| Accountant | Finance, Accounting and Reports          |

## Technology Stack

| Technology      | Purpose                 |
| --------------- | ----------------------- |
| Laravel 12      | Backend framework       |
| PHP 8.2         | Server-side programming |
| MySQL / MariaDB | Database                |
| Blade           | Server-rendered UI      |
| Livewire 3      | Interactive components  |
| Bootstrap 5     | UI framework            |
| Bootstrap Icons | Interface icons         |
| JavaScript      | Frontend interaction    |
| Vite            | Asset bundling          |

## Project Structure

```text
ERP-Pro/
├── app/
│   ├── Http/
│   ├── Livewire/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
├── storage/
├── tests/
├── artisan
├── composer.json
├── package.json
└── README.md
```

## Installation

### Requirements

* PHP 8.2+
* Composer
* Node.js
* NPM
* MySQL / MariaDB
* XAMPP or another PHP development environment

### Clone

```bash
git clone https://github.com/hassancoder05-arch/ERP-Pro.git
cd ERP-Pro
```

### Install PHP dependencies

```bash
composer install
```

### Install frontend dependencies

```bash
npm install
```

### Environment

Create `.env` from `.env.example`:

```bash
copy .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database in `.env`.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erp_pro
DB_USERNAME=root
DB_PASSWORD=
```

### Database

Run migrations:

```bash
php artisan migrate
```

### Storage

```bash
php artisan storage:link
```

### Frontend

```bash
npm run build
```

### Clear Cache

```bash
php artisan optimize:clear
```

### Start Application

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Security

Sensitive configuration is stored in `.env` and excluded from version control.

The project uses:

* CSRF protection
* Password hashing
* Request validation
* Role-based middleware
* Session security
* Security response headers
* Environment-based configuration

## Database

The application uses relational database tables for:

* Users
* Employees
* Customers
* Suppliers
* Products
* Inventory transactions
* Sales
* Sale items
* Expenses
* Expense categories
* Incomes
* Payments
* Settings

Database migrations are included in the repository.

## Testing

Laravel's testing infrastructure is included under:

```text
tests/
```

Run:

```bash
php artisan test
```

## Project Status

**Development status:** Portfolio-ready ERP application.

## Developer

**Hassan Mehmood**

Full-Stack Web Developer

GitHub:
https://github.com/hassancoder05-arch

Portfolio:
https://hassan-portfolio-first.netlify.app/

## License

This project is intended for educational and portfolio purposes.

