# Loan Products Admin Panel Backend

Internal Laravel API for the Loan Products Admin Panel.

This backend handles JWT authentication, role based access, product management, user management, and the eligibility engine that evaluates loan applicants against all available products.

## Project Overview

The backend is built with Laravel 12 and exposes a REST API for the frontend Vue app.

Admin users can:
- log in with JWT
- create and update loan products
- create loan applicants
- view all users and eligible products

Viewer users can:
- log in with JWT
- view products
- view users
- view eligible products for a user

Eligibility is calculated automatically whenever a user is created, or when a product is created or updated.

## Features

### Authentication
- JWT login
- logout
- current user API

### Role Based Access
- Admin
- Viewer

### Loan Product Management
- create product
- update product
- view products

### User Management
- create user
- view users

### Eligibility Engine
- automatic eligibility calculation
- `Active` / `Rejected` status update
- eligible products mapping

### API Handling
- form request validation
- API resources
- clean JSON responses

## Business Logic

Every user is compared with every loan product.

Eligibility depends only on:
- Age
- Credit Score
- Employment Type
- Salary Type
- Minimum Salary

If one or more products match, the user status becomes `Active`.

If no products match, the user status becomes `Rejected`.

All matching products are stored in the `eligible_products` table.

## Technology Stack

- Laravel 12
- PHP 8.3
- MySQL
- JWT Authentication
- Eloquent ORM
- Form Request Validation
- API Resources
- Carbon

## Database Tables

This project uses only these tables:

- `roles`
- `users`
- `products`
- `eligible_products`

## Project Structure

- `app/`
  - Controllers, Models, Middleware, Form Requests, Resources, and Services
- `routes/`
  - API routes
- `database/`
  - migrations, seeders, and factories
- `resources/`
  - default Laravel frontend assets and views

## Installation

### 1. Go to the backend folder
```bash
cd backend
```

### 2. Install dependencies
```bash
composer install
```

### 3. Copy the environment file
```bash
copy .env.example .env
```

### 4. Set the application key
```bash
php artisan key:generate
```

### 5. Configure the database
Update the MySQL values in `.env`.

### 6. Generate JWT secret
```bash
php artisan jwt:secret
```

### 7. Run migrations and seed data
```bash
php artisan migrate:fresh --seed
```

### 8. Serve the backend
```bash
php artisan serve
```

## Seeders

The backend includes these seeders:

- `RolesSeeder`
- `AdminSeeder`
- `ViewerSeeder`
- `ProductsSeeder`
- `UsersSeeder`

Seeded data includes:
- 3 loan products
- 5 users
- a mix of `Active` and `Rejected` users based on eligibility

## Default Login Credentials

### Admin
- Email: `admin@example.com`
- Password: `password`

### Viewer
- Email: `viewer@example.com`
- Password: `password`

## API Endpoints

All routes are prefixed with `/api`.

### Authentication
- `POST /api/login`
- `POST /api/logout`
- `GET /api/me`

### Products
- `GET /api/products`
- `POST /api/products`
- `PUT /api/products/{id}`

### Users
- `GET /api/users`
- `POST /api/users`
- `GET /api/users/{id}/eligible-products`

## Notes

- Eligibility is recalculated synchronously.
- No queues are used.
- The backend returns JSON responses only.
- Validation is handled through Form Requests.
