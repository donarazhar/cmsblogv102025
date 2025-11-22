# 🕌 CMS Masjid Agung Al Azhar

Sistem Manajemen Konten (CMS) dan Landing Page Dinamis untuk Masjid Agung Al Azhar. Dibangun dengan Laravel 11, sistem ini menyediakan pengelolaan konten yang mudah dan tampilan website yang modern.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan](#-penggunaan)
- [Struktur Database](#-struktur-database)
- [Screenshot](#-screenshot)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

## ✨ Fitur Utama

### 🎯 Admin Dashboard
- **Dashboard Analytics** - Statistik real-time dengan grafik interaktif
- **Activity Logs** - Tracking aktivitas pengguna dengan detail lengkap
- **Responsive Design** - Tampilan optimal di semua perangkat

### 📝 Content Management
- **Posts Management**
  - CRUD lengkap untuk artikel/berita
  - Multi-kategori & tags
  - Featured image & video
  - SEO optimization (meta title, description, keywords)
  - Status: Draft, Published, Scheduled, Archived
  - Auto reading time calculation
  - View counter

- **Categories Management**
  - Hierarchical categories (parent-child)
  - Custom icons & colors
  - Image upload
  - Custom ordering
  - SEO settings

- **Tags Management** (Coming soon)
- **Comments Management** (Coming soon)

### 🌐 Landing Page
- **Dynamic Sliders** - Hero slider yang dapat dikustomisasi
- **Programs Section** - Showcase program masjid
- **Latest Posts** - Artikel terbaru dengan filtering
- **Gallery** - Photo & video gallery
- **Schedules** - Jadwal sholat & kegiatan
- **Announcements** - Pengumuman penting
- **Statistics** - Real-time visitor & activity stats
- **Testimonials** - Testimoni jamaah

### 🔐 User Management
- Authentication (Login/Logout)
- Role-based access control
- User profile management

### 📊 Activity Monitoring
- **Real-time Tracking**
  - Page views
  - User actions (Create, Update, Delete)
  - IP address & location tracking
  - Device & browser detection
  
- **Analytics Dashboard**
  - Hourly & daily activity charts
  - Popular pages statistics
  - Peak hours analysis
  - Device & browser statistics
  - Active users tracking

## 🛠 Teknologi

### Backend
- **Framework:** Laravel 11.x
- **PHP:** 8.2+
- **Database:** MySQL 8.0+ / MariaDB 10.3+

### Frontend
- **Template Engine:** Blade
- **CSS Framework:** Custom CSS with CSS Variables
- **JavaScript:** Vanilla JS, Chart.js
- **Icons:** Font Awesome 6.5
- **Animations:** AOS (Animate On Scroll)

### Libraries & Tools
- **Image Storage:** Laravel Storage (Public Disk)
- **Validation:** Laravel Validation
- **Authentication:** Laravel Breeze/Sanctum
- **Pagination:** Laravel Pagination
- **Date/Time:** Carbon (Asia/Jakarta timezone)

## 📦 Instalasi

### Prasyarat
```bash
PHP >= 8.2
Composer
MySQL/MariaDB
Node.js & NPM (optional, untuk asset compilation)
```

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/your-username/cms-masjid-al-azhar.git
cd cms-masjid-al-azhar
```

2. **Install Dependencies**
```bash
composer install
```

3. **Copy Environment File**
```bash
cp .env.example .env
```

4. **Generate Application Key**
```bash
php artisan key:generate
```

5. **Konfigurasi Database**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=masjid_alazhar
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. **Run Migrasi**
```bash
php artisan migrate
```

7. **Seed Database (Optional)**
```bash
php artisan db:seed
```

8. **Create Storage Link**
```bash
php artisan storage:link
```

9. **Run Development Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## ⚙️ Konfigurasi

### Timezone
Aplikasi menggunakan timezone **Asia/Jakarta (WIB)**. Konfigurasi di `config/app.php`:
```php
'timezone' => 'Asia/Jakarta',
'locale' => 'id',
```

### Storage
Upload file disimpan di `storage/app/public`. Pastikan symbolic link sudah dibuat:
```bash
php artisan storage:link
```

### Default Admin Account
Setelah seeding:
```
Email: admin@alazhar.com
Password: password
```

⚠️ **Penting:** Ubah password default setelah login pertama!

## 📖 Penggunaan

### Akses Admin Panel
1. Buka `http://localhost:8000/admin`
2. Login dengan credentials admin
3. Dashboard akan menampilkan statistik dan quick actions

### Mengelola Posts

#### Membuat Post Baru
1. Sidebar → Content → Posts
2. Klik "Tambah Post Baru"
3. Isi form:
   - **Title** (Required)
   - **Slug** (Auto-generated)
   - **Content** (Required)
   - **Excerpt** (Optional)
   - **Featured Image** (Optional, max 2MB)
   - **Category** (Required)
   - **Tags** (Optional)
   - **Status**: Draft/Published/Scheduled/Archived
   - **SEO Settings** (Optional)
4. Klik "Simpan"

#### Filter & Search Posts
- Filter by: Status, Post Type, Category, Featured
- Search: Title, Content, Excerpt
- Pagination: 15 posts per page

### Mengelola Categories

#### Membuat Category
1. Sidebar → Content → Categories
2. Klik "Tambah Category Baru"
3. Isi form:
   - **Name** (Required)
   - **Slug** (Auto-generated)
   - **Description** (Optional)
   - **Parent Category** (Optional, untuk sub-category)
   - **Icon** (Font Awesome class)
   - **Color** (Color picker)
   - **Order** (Sorting)
   - **Image** (Optional)
4. Klik "Simpan"

#### Hierarchical Categories
- Support parent-child structure
- Sub-categories ditampilkan dengan indentasi
- Parent category tidak bisa memilih dirinya sendiri

### Activity Logs

#### Melihat Analytics
1. Sidebar → Activity Logs → Analytics
2. Pilih periode:
   - Hari Ini
   - Minggu Ini
   - Bulan Ini
   - Tahun Ini
3. Lihat statistik:
   - Total aktivitas
   - Active users
   - Popular pages
   - Hourly/Daily charts
   - Device & Browser stats

#### Activity Log Details
- Setiap aktivitas mencatat:
  - User (jika login)
  - Action type (view, create, update, delete)
  - Route/page
  - IP Address
  - Device type
  - Browser
  - Timestamp (WIB)

### Kustomisasi Landing Page

#### Update Sliders
```php
// Coming soon
```

#### Update Programs
```php
// Coming soon
```

## 🗄 Struktur Database

### Tabel Utama

#### posts
```sql
- id (bigint, PK)
- title (string, 255)
- slug (string, 255, unique)
- excerpt (text, nullable)
- content (longtext)
- featured_image (string, nullable)
- featured_video (string, nullable)
- category_id (foreignId)
- author_id (foreignId)
- status (enum: draft|published|scheduled|archived)
- post_type (enum: article|news|announcement|event)
- is_featured (boolean)
- allow_comments (boolean)
- views_count (integer)
- reading_time (integer)
- published_at (timestamp, nullable)
- scheduled_at (timestamp, nullable)
- meta_title (string, nullable)
- meta_description (text, nullable)
- meta_keywords (string, nullable)
- timestamps
- soft_deletes
```

#### categories
```sql
- id (bigint, PK)
- name (string, 255)
- slug (string, 255, unique)
- description (text, nullable)
- image (string, nullable)
- icon (string, nullable)
- color (string, 7)
- order (integer)
- is_active (boolean)
- parent_id (foreignId, nullable)
- meta_title (string, nullable)
- meta_description (text, nullable)
- meta_keywords (string, nullable)
- timestamps
- soft_deletes
```

#### activity_logs
```sql
- id (bigint, PK)
- user_id (foreignId, nullable)
- action (string)
- route (string)
- method (string)
- ip_address (string)
- user_agent (text)
- device_type (string)
- browser (string)
- platform (string)
- referer (string, nullable)
- description (text, nullable)
- timestamps
```

#### tags
```sql
- id (bigint, PK)
- name (string, 255)
- slug (string, 255, unique)
- timestamps
```

#### post_tag (Pivot)
```sql
- post_id (foreignId)
- tag_id (foreignId)
```

### Relasi Database
```
users (1) ──→ (many) posts [author_id]
categories (1) ──→ (many) posts [category_id]
categories (1) ──→ (many) categories [parent_id] (self-referencing)
posts (many) ←→ (many) tags [post_tag pivot]
users (1) ──→ (many) activity_logs [user_id]
```

## 📸 Screenshot

### Admin Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Posts Management
![Posts](docs/screenshots/posts.png)

### Categories Management
![Categories](docs/screenshots/categories.png)

### Activity Analytics
![Analytics](docs/screenshots/analytics.png)

### Landing Page
![Landing](docs/screenshots/landing.png)

## 🔐 Security

### Best Practices
- ✅ CSRF Protection (Laravel default)
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ XSS Protection (Blade escaping)
- ✅ Password Hashing (bcrypt)
- ✅ File Upload Validation
- ✅ Role-based Access Control

### Recommended Production Settings

**.env Production:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Use strong random key
APP_KEY=

# Use HTTPS
SESSION_SECURE_COOKIE=true

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=strong-password
```

## 🚀 Deployment

### Menggunakan Shared Hosting

1. **Export Database**
```bash
php artisan db:export
```

2. **Build Assets (jika ada)**
```bash
npm run build
```

3. **Upload Files**
   - Upload semua file kecuali `.env`, `node_modules`, `vendor`
   - Upload via FTP/SFTP

4. **Install Dependencies di Server**
```bash
composer install --optimize-autoloader --no-dev
```

5. **Set Permissions**
```bash
chmod -R 755 storage bootstrap/cache
```

6. **Import Database**
   - Via phpMyAdmin atau MySQL client

7. **Update .env**
   - Sesuaikan dengan environment production

### Menggunakan VPS/Cloud

#### Dengan Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/cms-masjid/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Optimasi Production
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

## 🐛 Troubleshooting

### Error: Storage Link Not Found
```bash
php artisan storage:link
```

### Error: Permission Denied
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Error: 500 Internal Server Error
1. Check `.env` configuration
2. Check file permissions
3. Enable debug mode temporarily:
```env
   APP_DEBUG=true
```
4. Check Laravel logs: `storage/logs/laravel.log`

### Database Connection Error
1. Verify MySQL service is running
2. Check database credentials in `.env`
3. Test connection:
```bash
   php artisan tinker
   DB::connection()->getPdo();
```

## 📝 Changelog

### Version 1.0.0 (2024)
- ✅ Initial release
- ✅ Posts CRUD with categories & tags
- ✅ Categories hierarchical structure
- ✅ Activity logging system
- ✅ Analytics dashboard
- ✅ Landing page dengan dynamic content
- ✅ Responsive admin panel

### Upcoming Features (v1.1.0)
- [ ] Tags CRUD
- [ ] Comments management
- [ ] User roles & permissions
- [ ] Email notifications
- [ ] Advanced search
- [ ] Export/Import data
- [ ] Multi-language support
- [ ] API endpoints

## 🤝 Kontribusi

Kontribusi sangat diterima! Berikut cara berkontribusi:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Coding Standards
- Follow PSR-12 coding standard
- Write meaningful commit messages
- Add comments untuk logic yang kompleks
- Update documentation jika perlu

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).
```
MIT License

Copyright (c) 2024 Masjid Agung Al Azhar

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction...
```

## 👨‍💻 Author

**Masjid Agung Al Azhar Development Team**

- Website: [https://masjidagungalazhar.com]
- Email: masjidagungalazhar@gmail.com

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Font Awesome](https://fontawesome.com) - Icon library
- [Chart.js](https://www.chartjs.org) - Charts library
- [AOS](https://michalsnik.github.io/aos/) - Animate On Scroll library

## 📞 Support

Jika Anda memiliki pertanyaan atau menemukan bug:

1. **GitHub Issues:** [Create an issue](https://github.com/donarazhar)
2. **Email:** donarazhar@gmail.com
3. **Documentation:** Check `/docs` folder

## ⭐ Star History

Jika project ini bermanfaat, jangan lupa untuk memberikan ⭐ di GitHub!

---

**Dibuat dengan ❤️ untuk Masjid Agung Al Azhar**

*Last Updated: November 2024*