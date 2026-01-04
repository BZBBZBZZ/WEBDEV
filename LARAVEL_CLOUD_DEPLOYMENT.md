# 🚀 Laravel Cloud Deployment Guide

## ✅ Perubahan yang Sudah Dilakukan

### 1. **AppServiceProvider.php**
- ✅ Removed ngrok logic
- ✅ Simplified HTTPS forcing untuk production only

### 2. **File Storage**
- ✅ Update `filesystems.php` - default disk sekarang `public` (bisa override ke `s3`)
- ✅ Update `AdminLocationController` - support cloud storage
- ✅ Update `AdminEmployeeController` - support cloud storage
- ✅ Menggunakan `Storage::url()` untuk flexible URL generation

### 3. **Environment Configuration**
- ✅ Created `.env.example` dengan config production-ready

---

## 📋 Checklist Pre-Deployment

### Step 1: Persiapan Database
- [ ] Siapkan MySQL/PostgreSQL database di Laravel Cloud
- [ ] Copy connection credentials (host, database, username, password)

### Step 2: Setup S3 untuk File Storage (Recommended)
```bash
# Buat S3 bucket di AWS atau gunakan alternative seperti:
# - DigitalOcean Spaces
# - Cloudflare R2
# - Wasabi
```

**Credentials yang dibutuhkan:**
- AWS_ACCESS_KEY_ID
- AWS_SECRET_ACCESS_KEY
- AWS_DEFAULT_REGION
- AWS_BUCKET

### Step 3: Setup Redis (Recommended)
Laravel Cloud biasanya sudah menyediakan Redis. Copy credentials:
- REDIS_HOST
- REDIS_PASSWORD
- REDIS_PORT

### Step 4: Environment Variables
Set semua variable ini di Laravel Cloud Dashboard:

```env
# Basic
APP_ENV=production
APP_DEBUG=false
APP_KEY=your-app-key-from-artisan-key-generate
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

# File Storage - Pilih salah satu:
# Option 1: Gunakan public disk (local storage)
FILESYSTEM_DISK=public

# Option 2: Gunakan S3 (Recommended untuk production)
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name

# Cache & Session - Use Redis
SESSION_DRIVER=redis
CACHE_STORE=redis
QUEUE_CONNECTION=redis

REDIS_HOST=your-redis-host
REDIS_PASSWORD=your-redis-password
REDIS_PORT=6379

# RajaOngkir API
RAJAONGKIR_API_KEY=your-rajaongkir-api-key

# Midtrans Payment Gateway
MIDTRANS_SERVER_KEY=your-production-server-key
MIDTRANS_CLIENT_KEY=your-production-client-key
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_IS_3DS=true
MIDTRANS_IS_SANITIZED=true
```

---

## 🔧 Commands Setelah Deploy

Jalankan commands ini di Laravel Cloud console atau via SSH:

```bash
# 1. Generate application key (jika belum)
php artisan key:generate

# 2. Link storage (jika pakai local storage)
php artisan storage:link

# 3. Run migrations
php artisan migrate --force

# 4. Seed data (optional)
php artisan db:seed --force

# 5. Clear & cache config untuk performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Restart queue workers
php artisan queue:restart
```

---

## 🧪 Testing Checklist

Setelah deploy, test fitur-fitur berikut:

### File Upload
- [ ] Upload location image
- [ ] Upload employee image
- [ ] Verify images tampil dengan benar
- [ ] Delete location/employee dan verify image terhapus

### Payment Gateway
- [ ] Test Midtrans payment flow
- [ ] Verify payment callback
- [ ] Check transaction records

### Shipping
- [ ] Test RajaOngkir API
- [ ] Verify ongkir calculation
- [ ] Test checkout flow dengan shipping

### General
- [ ] Login/Register
- [ ] Admin dashboard access
- [ ] Product CRUD operations
- [ ] Cart functionality
- [ ] Testimonial system
- [ ] Custom orders

---

## ⚠️ Troubleshooting

### Issue: Images tidak tampil
**Solution:**
- Pastikan `FILESYSTEM_DISK` sudah di-set
- Jika pakai S3: verify AWS credentials
- Jika pakai public: run `php artisan storage:link`

### Issue: 500 Error
**Solution:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Issue: Queue jobs tidak running
**Solution:**
- Verify `QUEUE_CONNECTION=redis`
- Check queue workers status di Laravel Cloud
- Restart queue: `php artisan queue:restart`

### Issue: Midtrans payment gagal
**Solution:**
- Verify `MIDTRANS_IS_PRODUCTION=true`
- Check server key dan client key
- Verify callback URL di Midtrans dashboard: `https://yourdomain.com/midtrans/callback`

---

## 🔐 Security Checklist

- [x] `APP_DEBUG=false` in production
- [x] HTTPS forcing enabled via `AppServiceProvider`
- [ ] Regenerate `APP_KEY` untuk production
- [ ] Set strong database password
- [ ] Restrict database access by IP (jika memungkinkan)
- [ ] Enable 2FA di Laravel Cloud dashboard
- [ ] Setup regular database backups

---

## 📊 Performance Optimization

```bash
# Run these in production for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# If using Laravel Octane (optional)
php artisan octane:start --server=swoole
```

---

## 🆘 Support

Jika ada masalah:
1. Check logs: `storage/logs/laravel.log`
2. Check Laravel Cloud dashboard untuk metrics
3. Contact Laravel Cloud support

---

## 📌 Notes

- **Local Development**: Tetap bisa pakai `FILESYSTEM_DISK=public` di `.env` local
- **Staging**: Buat separate environment untuk testing
- **Rollback**: Laravel Cloud support git-based deployment, mudah untuk rollback

Good luck! 🎉
