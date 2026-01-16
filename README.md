# Food Ordering System - Laravel Backend

This is a complete PHP Laravel migration of the Java Spring Boot food ordering backend.

## Technology Stack

- **PHP**: 8.2+
- **Framework**: Laravel 11.x
- **Database**: MySQL/MariaDB (same schema as Java version)
- **Authentication**: JWT (tymon/jwt-auth)
- **ORM**: Eloquent

## Local Development Installation

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

The complete database schema is available in `database/schema.sql`. This SQL file contains:
- All table definitions with proper data types
- Foreign key constraints
- Indexes for optimal performance
- Initial seed data (roles, admin user, sample food items)

### Database Setup

#### Option 1: Using SQL File (Recommended for Production)

1. Create a database in your MySQL/MariaDB:
   ```sql
   CREATE DATABASE food_ordering CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Import the schema file:
   ```bash
   mysql -u your_username -p food_ordering < database/schema.sql
   ```
   
   Or via phpMyAdmin:
   - Login to phpMyAdmin
   - Select your database
   - Go to "Import" tab
   - Choose `database/schema.sql` file
   - Click "Go"

#### Option 2: Using Laravel Migrations

```bash
php artisan migrate
php artisan db:seed
```

### Database Tables

- **roles** - User roles (ADMIN, CUSTOMER)
- **users** - User accounts
- **user_roles** - Many-to-many relationship between users and roles
- **food_items** - Food menu items
- **reviews** - User reviews for food items
- **carts** - Shopping carts (one per user)
- **cart_items** - Items in shopping carts
- **orders** - Customer orders
- **order_items** - Items in orders

### Default Admin Credentials

After importing the schema, you can login with:
- **Phone**: +1234567890
- **Password**: admin123

**⚠️ IMPORTANT**: 
1. Change the admin password immediately after deployment!
2. The default password hash in the SQL file may need to be regenerated. After deployment, update it using:
   ```bash
   php artisan tinker
   ```
   ```php
   $user = App\Models\User::where('phone', '+1234567890')->first();
   $user->password = Hash::make('your_new_secure_password');
   $user->save();
   ```

## Deployment to HosterPK

### Prerequisites

1. **HosterPK Account** with:
   - PHP 8.2 or higher
   - MySQL/MariaDB database
   - SSH access (recommended)
   - Composer support

2. **Domain/Subdomain** configured and pointing to your hosting

### Step 1: Prepare Your Project

**Important**: Ensure you have a complete Laravel installation. If this is a partial codebase, you may need to:
1. Create a new Laravel project: `composer create-project laravel/laravel food_ordering_backend`
2. Copy your application code (app/, routes/, database/, config/) into the new project
3. Install JWT package: `composer require tymon/jwt-auth`

1. **Install dependencies locally** (if not already done):
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

2. **Create production .env file**:
   ```bash
   cp .env.example .env
   ```

3. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

4. **Generate JWT secret**:
   ```bash
   php artisan jwt:secret
   ```

5. **Update admin password** (recommended before deployment):
   ```bash
   php artisan tinker
   ```
   Then in tinker:
   ```php
   $user = App\Models\User::where('phone', '+1234567890')->first();
   $user->password = Hash::make('your_secure_password');
   $user->save();
   exit
   ```

### Step 2: Upload Files to HosterPK

#### Method A: Using FTP/SFTP (cPanel File Manager)

1. **Connect to your HosterPK hosting** via FTP/SFTP client (FileZilla, WinSCP, etc.)

2. **Navigate to your domain's public_html directory** (or subdomain directory)

3. **Upload all project files** except:
   - `.env` (you'll create this on server)
   - `node_modules/` (if exists)
   - `.git/` (if exists)
   - `tests/` (optional)
   - `storage/logs/*` (keep directory, exclude log files)

4. **Important**: Ensure the following directories are writable (755 or 775 permissions):
   - `storage/`
   - `storage/app/`
   - `storage/framework/`
   - `storage/framework/cache/`
   - `storage/framework/sessions/`
   - `storage/framework/views/`
   - `storage/logs/`
   - `bootstrap/cache/`

#### Method B: Using Git (if SSH access available)

1. **SSH into your HosterPK server**:
   ```bash
   ssh username@your-domain.com
   ```

2. **Navigate to your domain directory**:
   ```bash
   cd public_html
   # or
   cd domains/yourdomain.com/public_html
   ```

3. **Clone your repository** (if using Git):
   ```bash
   git clone your-repo-url .
   ```

4. **Install dependencies**:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

### Step 3: Configure Database

1. **Create MySQL Database in cPanel**:
   - Login to cPanel
   - Go to "MySQL Databases"
   - Create a new database (e.g., `username_foodordering`)
   - Create a database user with a strong password
   - Add user to database with ALL PRIVILEGES

2. **Import Database Schema**:
   
   **Option A: Via phpMyAdmin** (Recommended):
   - Go to phpMyAdmin in cPanel
   - Select your database
   - Click "Import" tab
   - Choose `database/schema.sql` file
   - Click "Go"
   
   **Option B: Via SSH**:
   ```bash
   mysql -u database_user -p database_name < database/schema.sql
   ```

### Step 4: Configure Environment Variables

1. **Create .env file on server** (if not uploaded):
   ```bash
   cd /path/to/your/project
   cp .env.example .env
   ```

2. **Edit .env file** with your production settings:
   ```env
   APP_NAME="Food Ordering System"
   APP_ENV=production
   APP_KEY=base64:YOUR_GENERATED_KEY_HERE
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   
   LOG_CHANNEL=stack
   LOG_LEVEL=error
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   
   JWT_SECRET=your_jwt_secret_here
   JWT_TTL=60
   
   BROADCAST_DRIVER=log
   CACHE_DRIVER=file
   FILESYSTEM_DISK=local
   QUEUE_CONNECTION=sync
   SESSION_DRIVER=file
   SESSION_LIFETIME=120
   ```

3. **Generate keys** (if not done locally):
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```

### Step 5: Set Up Web Server Configuration

#### For Apache (.htaccess)

Ensure your `public/.htaccess` file exists and contains:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#### Point Document Root to `public` Directory

**In cPanel**:
1. Go to "Subdomains" or "Addon Domains"
2. Edit your domain/subdomain
3. Set document root to: `public_html/public` (or your project path + `/public`)

**Or via .htaccess in root** (if you can't change document root):
Create `.htaccess` in root directory:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Step 6: Optimize Laravel for Production

1. **Clear and cache configuration**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Set proper permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```
   (Adjust user/group based on your server setup)

### Step 7: Verify Deployment

1. **Test API endpoint**:
   ```bash
   curl https://yourdomain.com/api/foods
   ```

2. **Check logs** (if issues):
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Step 8: Security Checklist

- [ ] Change `APP_DEBUG=false` in `.env`
- [ ] Change default admin password
- [ ] Set strong database passwords
- [ ] Ensure `.env` file is not publicly accessible
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Enable HTTPS/SSL certificate
- [ ] Configure firewall rules if available
- [ ] Set up regular database backups

### Troubleshooting

#### 500 Internal Server Error
- Check file permissions on `storage/` and `bootstrap/cache/`
- Verify `.env` file exists and has correct values
- Check `storage/logs/laravel.log` for errors

#### Database Connection Error
- Verify database credentials in `.env`
- Ensure database user has proper privileges
- Check if database host is `localhost` or IP address

#### JWT Authentication Not Working
- Verify `JWT_SECRET` is set in `.env`
- Run `php artisan jwt:secret` to generate new secret
- Clear config cache: `php artisan config:clear`

#### Routes Not Working
- Ensure document root points to `public/` directory
- Check `.htaccess` file exists in `public/` directory
- Clear route cache: `php artisan route:clear`

### Additional Notes for HosterPK

- **PHP Version**: Ensure PHP 8.2+ is selected in cPanel (MultiPHP Manager)
- **Composer**: If not available, install dependencies locally and upload `vendor/` folder
- **Cron Jobs**: Set up if you need scheduled tasks (cPanel → Cron Jobs)
- **Backups**: Configure automatic backups via cPanel
- **SSL**: Install free SSL certificate via Let's Encrypt in cPanel

### Support

For issues specific to HosterPK hosting, contact HosterPK support. For application issues, check `storage/logs/laravel.log`.

## Quick Reference

### Essential Files
- **Database Schema**: `database/schema.sql` - Complete SQL file with tables and initial data
- **Environment Config**: `.env` - Application configuration (create from `.env.example`)
- **Routes**: `routes/api.php` - API endpoint definitions

### Common Deployment Commands

```bash
# Generate application key
php artisan key:generate

# Generate JWT secret
php artisan jwt:secret

# Run migrations (alternative to SQL import)
php artisan migrate

# Seed database (alternative to SQL import)
php artisan db:seed

# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check application status
php artisan about
```

### Database Management

```bash
# Import SQL file
mysql -u username -p database_name < database/schema.sql

# Export database
mysqldump -u username -p database_name > backup.sql

# Access MySQL via command line
mysql -u username -p database_name
```

### File Permissions (Linux/Unix)

```bash
# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Set writable directories
chmod -R 775 storage bootstrap/cache
```

## Project Summary

This Laravel backend provides a complete REST API for a food ordering system with:
- User authentication (JWT-based)
- Role-based access control (Admin/Customer)
- Food item management
- Shopping cart functionality
- Order processing
- Review system
- Admin dashboard and reporting

The database schema includes 9 tables with proper relationships, indexes, and foreign key constraints for optimal performance and data integrity.

