# Quick Start Guide

## Prerequisites
- PHP 8.2+
- Composer
- MySQL/MariaDB
- Laravel 11.x

## Installation Steps

### 1. Install Dependencies
```bash
cd laravel_migration
composer install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

### 3. Database Configuration
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=food_ordering_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Seed Database
```bash
php artisan db:seed
```

This creates:
- Roles (ADMIN, CUSTOMER)
- Admin user (phone: +1234567890, password: admin123)
- 15 sample food items

### 6. Start Server
```bash
php artisan serve
```

API will be available at: `http://localhost:8000`

## Testing the API

### 1. Register a User
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "fullName": "John Doe",
    "phone": "+1234567891",
    "email": "john@example.com",
    "password": "password123"
  }'
```

### 2. Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "+1234567890",
    "password": "admin123"
  }'
```

Save the token from the response.

### 3. Get Food Items
```bash
curl http://localhost:8000/api/foods
```

### 4. Add to Cart (with token)
```bash
curl -X POST http://localhost:8000/api/cart \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "foodItemId": 1,
    "quantity": 2
  }'
```

### 5. Create Order
```bash
curl -X POST http://localhost:8000/api/orders \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d '{
    "deliveryAddress": "123 Main St",
    "phone": "+1234567891",
    "notes": "Ring doorbell"
  }'
```

## Project Structure

```
laravel_migration/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # API Controllers
│   │   ├── Middleware/       # Role middleware
│   │   ├── Requests/         # Form validation
│   │   └── Resources/        # API response formatting
│   ├── Models/               # Eloquent models
│   ├── Services/             # Business logic
│   └── Exceptions/           # Custom exceptions
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/              # Initial data
├── routes/
│   └── api.php               # API routes
└── config/
    └── auth.php              # Auth configuration
```

## Key Files

- **Routes**: `routes/api.php`
- **Controllers**: `app/Http/Controllers/`
- **Services**: `app/Services/`
- **Models**: `app/Models/`
- **Migrations**: `database/migrations/`

## Default Admin Credentials

- **Phone**: `+1234567890`
- **Password**: `admin123`
- **Role**: ADMIN

## API Base URL

All endpoints are prefixed with `/api`:
- Development: `http://localhost:8000/api`
- Production: `https://your-domain.com/api`

## Next Steps

1. Review `MIGRATION_SUMMARY.md` for complete feature mapping
2. Check `API_EXAMPLES.md` for detailed request/response examples
3. Configure CORS in `config/cors.php` for frontend integration
4. Set up proper logging and monitoring for production

## Troubleshooting

### JWT Secret Not Set
```bash
php artisan jwt:secret
```

### Database Connection Error
- Check `.env` database credentials
- Ensure MySQL/MariaDB is running
- Verify database exists: `CREATE DATABASE food_ordering_db;`

### Migration Errors
```bash
php artisan migrate:fresh --seed
```

### Token Expired
Default JWT TTL is 86400 seconds (24 hours). Adjust in `.env`:
```env
JWT_TTL=86400
```

