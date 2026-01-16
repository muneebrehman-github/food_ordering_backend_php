# Food Ordering System - Laravel Backend

This is a complete PHP Laravel migration of the Java Spring Boot food ordering backend.

## Technology Stack

- **PHP**: 8.2+
- **Framework**: Laravel 11.x
- **Database**: MySQL/MariaDB (same schema as Java version)
- **Authentication**: JWT (tymon/jwt-auth)
- **ORM**: Eloquent

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
php artisan serve
```

## API Endpoints

All endpoints match the Java backend exactly:
- `/api/auth/**` - Authentication
- `/api/foods/**` - Food items (public)
- `/api/cart/**` - Shopping cart
- `/api/orders/**` - Orders
- `/api/foods/{id}/reviews` - Reviews
- `/api/admin/**` - Admin endpoints (ADMIN role required)

## Database Schema

The database schema is identical to the Java version with the same table names, columns, and relationships.

