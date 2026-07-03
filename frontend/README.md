# Loan Products Admin Panel Frontend

Vue 3 frontend for the Loan Products Admin Panel.

This app consumes the existing Laravel REST API and provides a simple Bootstrap 5 interface for login, products, users, and eligible products.

## Project Overview

The frontend is a small SPA built with Vue Router and Axios.

It keeps the JWT token in `localStorage`, attaches it to authenticated requests, and logs the user out automatically if the API returns `401`.

## Features

### Authentication
- JWT login
- logout
- current user stored on login

### Route Protection
- login page for guests
- dashboard and internal pages for authenticated users

### Pages
- Login
- Dashboard
- Products
- Users
- 404 page

### Product Management
- view products
- add product for Admin
- edit product for Admin

### User Management
- view users
- add user for Admin
- view eligible products for each user

### UI
- Bootstrap 5 layout
- sidebar
- top navbar
- modals for add and edit forms

## Technology Stack

- Vue 3
- Vite
- Vue Router
- Axios
- Bootstrap 5

## Project Structure

- `src/api`
  - Axios client and API methods
- `src/components`
  - reusable UI components and modals
- `src/layouts`
  - authenticated layout
- `src/pages`
  - page components
- `src/router`
  - routes and route guards
- `src/services`
  - auth state handling
- `src/utils`
  - small helper functions

## Installation

### 1. Go to the frontend folder
```bash
cd frontend
```

### 2. Install dependencies
```bash
npm install
```

### 3. Copy the environment file
```bash
copy .env.example .env
```

### 4. Set the API base URL
Update `VITE_API_BASE_URL` in `.env` if the backend is running on a different address.

### 5. Run the frontend
```bash
npm run dev
```

### 6. Build for production
```bash
npm run build
```

## How It Works

- On login, the JWT token and current user are stored in `localStorage`.
- Axios attaches the token as a Bearer token on authenticated requests.
- If the API returns `401`, the app clears the session and sends the user back to the login page.
- Product and user forms send the same field names expected by the backend validation.
- After a successful save, the related table is refreshed.

## Backend API

The frontend uses the Laravel API documented in `backend/README.md`.

## Screenshots

Add screenshots here.

- Login page
- Dashboard
- Products page
- Users page
- Eligible products modal

## Future Improvements

- Product deletion
- User editing
- Product search
- Pagination

## Author

- Name: `nitesh soni`
