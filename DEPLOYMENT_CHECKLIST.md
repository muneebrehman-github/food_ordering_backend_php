# HosterPK Deployment Checklist

Use this checklist to ensure a smooth deployment to HosterPK.

## Pre-Deployment

- [ ] All code changes committed and tested locally
- [ ] Database schema exported to `database/schema.sql`
- [ ] `.env.example` file updated with all required variables
- [ ] Dependencies installed: `composer install --no-dev --optimize-autoloader`
- [ ] Application key generated: `php artisan key:generate`
- [ ] JWT secret generated: `php artisan jwt:secret`
- [ ] Tested locally with production-like settings

## Files to Upload

### Required Files & Directories
- [ ] `app/` - Application code
- [ ] `bootstrap/` - Bootstrap files
- [ ] `config/` - Configuration files
- [ ] `database/` - Migrations and seeders
- [ ] `public/` - Public files (document root)
- [ ] `routes/` - Route definitions
- [ ] `storage/` - Storage directories (must be writable)
- [ ] `vendor/` - Composer dependencies (or install on server)
- [ ] `artisan` - Artisan command file
- [ ] `.htaccess` - Root .htaccess (if needed)
- [ ] `composer.json` - Dependencies
- [ ] `composer.lock` - Lock file

### Files to Exclude
- [ ] `.env` - Create on server
- [ ] `.git/` - Git repository (if exists)
- [ ] `node_modules/` - Node modules (if exists)
- [ ] `tests/` - Test files (optional)
- [ ] `storage/logs/*.log` - Log files (keep directory)

## Server Setup

### Database
- [ ] Database created in cPanel
- [ ] Database user created
- [ ] User granted ALL PRIVILEGES on database
- [ ] Database credentials noted for `.env` file

### File Upload
- [ ] Connected to server via FTP/SFTP
- [ ] All files uploaded to correct directory
- [ ] File permissions set correctly:
  - Directories: 755
  - Files: 644
  - `storage/`: 775
  - `bootstrap/cache/`: 775

### Configuration
- [ ] `.env` file created on server
- [ ] Database credentials added to `.env`
- [ ] `APP_ENV=production` set
- [ ] `APP_DEBUG=false` set
- [ ] `APP_URL` set to your domain
- [ ] `APP_KEY` generated on server
- [ ] `JWT_SECRET` generated on server

### Database Import
- [ ] Database schema imported via phpMyAdmin or command line
- [ ] Initial data verified (roles, admin user, food items)
- [ ] Admin password changed from default

### Web Server
- [ ] Document root set to `public/` directory
- [ ] `.htaccess` file in `public/` directory
- [ ] PHP version set to 8.2+ in cPanel
- [ ] Required PHP extensions enabled

## Post-Deployment

### Optimization
- [ ] Config cached: `php artisan config:cache`
- [ ] Routes cached: `php artisan route:cache`
- [ ] Views cached: `php artisan view:cache`

### Testing
- [ ] API endpoint accessible: `https://yourdomain.com/api/foods`
- [ ] Authentication working: Test login endpoint
- [ ] Database connection verified
- [ ] JWT tokens generating correctly
- [ ] Admin dashboard accessible (if applicable)

### Security
- [ ] `.env` file not publicly accessible
- [ ] Default admin password changed
- [ ] Strong database passwords set
- [ ] SSL certificate installed
- [ ] File permissions verified

### Monitoring
- [ ] Error logging checked: `storage/logs/laravel.log`
- [ ] Application logs accessible
- [ ] Database backups configured (if available)

## Troubleshooting

If you encounter issues:

1. **500 Error**: Check file permissions and `.env` configuration
2. **Database Error**: Verify credentials in `.env`
3. **Route Not Found**: Clear route cache and verify document root
4. **JWT Error**: Verify `JWT_SECRET` is set

## Support

- Check `storage/logs/laravel.log` for detailed error messages
- Contact HosterPK support for server-specific issues
- Review README.md for detailed deployment instructions

