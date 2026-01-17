# Build Instructions for HosterPK Deployment

This guide will help you prepare and build the project for deployment to HosterPK.

## Step 1: Install Dependencies

Before building, ensure all dependencies are installed:

```bash
composer install --no-dev --optimize-autoloader
```

This will:
- Install all required packages
- Optimize autoloader for production
- Exclude development dependencies

## Step 2: Generate Required Keys

Generate application and JWT keys (these will be regenerated on server):

```bash
php artisan key:generate
php artisan jwt:secret
```

**Note**: These will be regenerated on the server with production values.

## Step 3: Verify Project Structure

Ensure the following structure exists:

```
food_ordering_backend_php/
├── app/                    ✓ Application code
├── bootstrap/              ✓ Bootstrap files
│   ├── app.php
│   └── cache/
├── config/                 ✓ Configuration files
├── database/               ✓ Migrations and seeders
│   ├── migrations/
│   ├── seeders/
│   └── schema.sql          ✓ Database schema
├── public/                 ✓ Public directory (document root)
│   ├── index.php
│   └── .htaccess
├── routes/                 ✓ Route definitions
│   ├── api.php
│   ├── web.php
│   └── console.php
├── storage/                ✓ Storage directories
│   ├── app/
│   ├── framework/
│   └── logs/
├── vendor/                 ✓ Composer dependencies
├── artisan                 ✓ Artisan CLI
├── .htaccess               ✓ Root redirect
├── .env.example            ✓ Environment template
├── composer.json           ✓ Dependencies
└── composer.lock           ✓ Lock file
```

## Step 4: Create Deployment Package

### Option A: ZIP File for FTP Upload

1. **Exclude unnecessary files**:
   - `.env` (create on server)
   - `.git/` (if exists)
   - `node_modules/` (if exists)
   - `tests/` (optional)
   - `storage/logs/*.log` (keep directory)

2. **Create ZIP file**:
   ```bash
   # On Windows (PowerShell)
   Compress-Archive -Path app,bootstrap,config,database,public,routes,storage,vendor,artisan,.htaccess,.env.example,composer.json,composer.lock -DestinationPath food_ordering_backend.zip
   
   # On Linux/Mac
   zip -r food_ordering_backend.zip app bootstrap config database public routes storage vendor artisan .htaccess .env.example composer.json composer.lock
   ```

### Option B: Direct Upload via FTP/SFTP

Upload all files except:
- `.env`
- `.git/`
- `node_modules/`
- `storage/logs/*.log`

## Step 5: Files to Upload Checklist

- [ ] `app/` directory
- [ ] `bootstrap/` directory
- [ ] `config/` directory
- [ ] `database/` directory (including `schema.sql`)
- [ ] `public/` directory
- [ ] `routes/` directory
- [ ] `storage/` directory (with subdirectories)
- [ ] `vendor/` directory (or install on server)
- [ ] `artisan` file
- [ ] `.htaccess` file (root)
- [ ] `.env.example` file
- [ ] `composer.json`
- [ ] `composer.lock`

## Step 6: Server-Side Setup

After uploading files:

1. **Create `.env` file** on server from `.env.example`
2. **Set file permissions**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```
3. **Install dependencies** (if vendor not uploaded):
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
4. **Generate keys**:
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```
5. **Import database**:
   - Via phpMyAdmin: Import `database/schema.sql`
   - Or via command line: `mysql -u user -p database < database/schema.sql`
6. **Optimize**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Important Notes

1. **Storage Directory**: Must be writable (775 permissions)
2. **Bootstrap Cache**: Must be writable (775 permissions)
3. **Document Root**: Should point to `public/` directory
4. **PHP Version**: Ensure PHP 8.2+ is selected in cPanel
5. **Composer**: If not available on server, upload `vendor/` directory

## Quick Build Script (Optional)

Create a `build.sh` script for easy building:

```bash
#!/bin/bash
echo "Building project for deployment..."

# Install dependencies
composer install --no-dev --optimize-autoloader

# Create deployment package
zip -r food_ordering_backend.zip \
    app bootstrap config database public routes storage \
    vendor artisan .htaccess .env.example composer.json composer.lock \
    -x "*.git*" -x "*node_modules*" -x "*.env" -x "storage/logs/*.log"

echo "Build complete! Package: food_ordering_backend.zip"
```

## Verification

Before uploading, verify:
- [ ] All files are present
- [ ] `vendor/` directory exists (or plan to install on server)
- [ ] `storage/` directories exist
- [ ] `public/index.php` exists
- [ ] `database/schema.sql` is included
- [ ] `.env.example` is included

## Next Steps

After building, follow the deployment instructions in `README.md` and use `DEPLOYMENT_CHECKLIST.md` for step-by-step deployment.

