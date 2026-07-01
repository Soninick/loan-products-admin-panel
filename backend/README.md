# Loan Products Admin Panel Backend

Laravel 12 REST API for loan product eligibility.

## Installation

1. Install dependencies:
   ```bash
   composer install
   ```
2. Copy the environment file:
   ```bash
   copy .env.example .env
   ```
3. Set your MySQL credentials in `.env`.
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Generate the JWT secret:
   ```bash
   php artisan jwt:secret
   ```

## JWT Setup

JWT auth is configured through `tymon/jwt-auth` with the `api` guard.

If you need to regenerate the secret, run:

```bash
php artisan jwt:secret
```

## Migration

Run the migrations:

```bash
php artisan migrate:fresh
```

## Seeder

Seed the database:

```bash
php artisan db:seed
```

Or run both migration and seeding together:

```bash
php artisan migrate:fresh --seed
```

## Credentials

Admin:

- Email: `admin@example.com`
- Password: `password`

Viewer:

- Email: `viewer@example.com`
- Password: `password`

## API List

All routes are under the `/api` prefix.

- `POST /api/login`
- `POST /api/logout`
- `GET /api/me`
- `GET /api/products`
- `POST /api/products`
- `PUT /api/products/{id}`
- `GET /api/users`
- `POST /api/users`
- `GET /api/users/{id}/eligible-products`

## Notes

- Admin can create and update products and create users.
- Viewer can only read products, users, and eligible products.
- Eligibility is re-evaluated synchronously when users or products change.
