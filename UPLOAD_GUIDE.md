# Quick Upload Guide for HosterPK

## What to Upload

Upload ALL of these files and folders to your HosterPK hosting:

### Required Directories
```
✓ app/
✓ bootstrap/
✓ config/
✓ database/
✓ public/
✓ routes/
✓ storage/
✓ vendor/          (if you have it, otherwise install on server)
```

### Required Files
```
✓ artisan
✓ .htaccess        (root directory)
✓ .env.example
✓ composer.json
✓ composer.lock
```

### DO NOT Upload
```
✗ .env            (create on server)
✗ .git/           (if exists)
✗ node_modules/   (if exists)
✗ tests/          (optional)
✗ *.log files     (keep storage/logs/ directory, just not log files)
```

## Upload Methods

### Method 1: cPanel File Manager
1. Login to cPanel
2. Go to File Manager
3. Navigate to `public_html` (or your domain directory)
4. Upload files via "Upload" button
5. Extract ZIP if uploaded as archive

### Method 2: FTP/SFTP Client
1. Use FileZilla, WinSCP, or similar
2. Connect to your server
3. Navigate to `public_html`
4. Upload all files and folders
5. Ensure binary mode for all files

### Method 3: SSH (if available)
```bash
# Upload via SCP
scp -r * username@yourdomain.com:/path/to/public_html/

# Or use Git
git clone your-repo-url
cd food_ordering_backend_php
composer install --no-dev --optimize-autoloader
```

## After Upload

1. **Set Permissions** (via cPanel File Manager or SSH):
   - `storage/` → 775
   - `bootstrap/cache/` → 775
   - All other directories → 755
   - All files → 644

2. **Create `.env` file**:
   - Copy `.env.example` to `.env`
   - Edit with your database credentials

3. **Install Dependencies** (if vendor not uploaded):
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **Generate Keys**:
   ```bash
   php artisan key:generate
   php artisan jwt:secret
   ```

5. **Import Database**:
   - Use phpMyAdmin to import `database/schema.sql`

6. **Set Document Root**:
   - Point to `public/` directory in cPanel

## File Size Note

If `vendor/` folder is large:
- Option 1: Upload it (slower but complete)
- Option 2: Install on server using Composer (faster upload, requires Composer on server)

## Quick Checklist

- [ ] All directories uploaded
- [ ] All files uploaded
- [ ] Permissions set correctly
- [ ] `.env` file created
- [ ] Database imported
- [ ] Document root set to `public/`
- [ ] Keys generated
- [ ] Test API endpoint

## Need Help?

See `README.md` for detailed instructions or `DEPLOYMENT_CHECKLIST.md` for step-by-step guide.

