# Laravel Sanctum User Management API

A secure RESTful API built with Laravel and Sanctum that provides authentication, role-based authorization, and user management features.

## Features

### Authentication
- User Registration
- User Login
- User Logout
- Protected Routes with Laravel Sanctum
- User Profile Endpoint

### Authorization
- Role-Based Access Control (RBAC)
- Admin Middleware
- Protected Admin Routes

## Tech Stack

- Laravel
- Laravel Sanctum
- MySQL
- REST API

## Roles

The system currently supports:

- admin
- user

## Installation

```bash
git clone https://github.com/L1m1tlesAyman/laravel-sanctum-auth-api.git

cd laravel-sanctum-auth-api

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve
```

## Future Improvements

- Policies
- API Resources
- Pagination
- Search & Filtering
- Password Reset
- Email Verification
- Unit Testing
- GraphQL Integration

## Author
1m1tlesAyman