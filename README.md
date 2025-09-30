# 📝 Aplikasi Todo List PHP - Project Keren Buat Mahasiswa! 🚀

Halo teman-teman! 👋 Ini adalah aplikasi Todo List yang dibuat dengan **PHP native** dan **MySQL**. Project ini cocok banget buat kalian yang mau belajar web development dengan teknologi yang keren dan modern!

## 🎯 Fitur-Fitur Kece

- ✅ **CRUD Lengkap** - Create, Read, Update, Delete (bisa tambahin, lihat, edit, hapus todo)
- ✅ **Filter Status** - Bisa filter berdasarkan: Semua, Pending, In Progress, Completed
- ✅ **System Priority** - Ada prioritas Low, Medium, High dengan warna-warna kece
- ✅ **Responsive Design** - Pake Bootstrap 5, jadi mobile-friendly
- ✅ **Validasi Form** - Ada validasi input dan error handling
- ✅ **Docker Ready** - Tinggal `docker-compose up` langsung jalan!
- ✅ **CI/CD Pipeline** - Ada GitHub Actions buat testing otomatis

## 📱 Screenshots

### Halaman Utama - Todo List
![Todo List Main Page](screenshots/main-page.png)
*Tampilan utama dengan daftar todo dan form untuk menambah todo baru*

### Detail Todo & Edit
![Todo Detail Page](screenshots/detail-page.png)
*Halaman detail todo dengan fitur edit inline*

### Responsive Mobile View
![Mobile View](screenshots/mobile-view.png)
*Tampilan mobile yang responsive dan user-friendly*

### Database Management (phpMyAdmin)
![phpMyAdmin](screenshots/phpmyadmin.png)
*Interface phpMyAdmin untuk manage database*

## 🏗️ Struktur Project

```
php-todo/
├── 📄 index.php          # Halaman utama (daftar todo)
├── 📄 detail.php         # Halaman detail todo
├── ⚙️ config.php         # Konfigurasi database
├── 🔧 functions.php      # Helper functions
├── 🗃️ database.sql       # Schema database + sample data
├── 📁 actions/           # Folder untuk proses CRUD
│   ├── create.php        # Proses tambah todo
│   ├── update.php        # Proses update todo
│   └── delete.php        # Proses hapus todo
├── 🎨 assets/
│   └── style.css         # Custom styling CSS
├── 🔄 .github/workflows/
│   └── ci.yml            # GitHub Actions workflow
├── 🐳 Dockerfile         # Docker config untuk PHP-FPM
├── 🌐 Dockerfile.nginx   # Docker config untuk Nginx
├── ⚙️ nginx.conf         # Config Nginx (simplified untuk mahasiswa)
├── 🐳 docker-compose.yml # Docker Compose configuration
├── 📚 NGINX_GUIDE.md     # Panduan Nginx untuk mahasiswa
└── 📖 README.md          # File ini
```

## 🛠️ Tech Stack yang Digunakan

- **🌐 Web Server**: Nginx 1.25 (Alpine) - Web server yang kenceng banget!
- **⚡ Backend**: PHP 8.1 dengan PHP-FPM - PHP versi terbaru dengan performa mantap
- **🗃️ Database**: MySQL 8.0 - Database yang reliable dan populer
- **🎨 Frontend**: HTML5, CSS3, JavaScript (vanilla), Bootstrap 5 - No framework JS yang ribet!
- **🐳 Containerization**: Docker & Docker Compose - Bikin deployment gampang banget
- **🚀 CI/CD**: GitHub Actions - Testing otomatis setiap push code

## 🗃️ Schema Database

Aplikasi ini menggunakan satu tabel `todos` dengan struktur:

| Field | Type | Constraint | Deskripsi |
|-------|------|------------|-----------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | ID unik todo |
| `title` | VARCHAR(255) | NOT NULL | Judul todo |
| `description` | TEXT | NULLABLE | Deskripsi detail todo |
| `status` | ENUM | 'pending', 'in_progress', 'completed' | Status todo |
| `priority` | ENUM | 'low', 'medium', 'high' | Prioritas todo |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | AUTO UPDATE | Waktu terakhir diupdate |

## 🐳 Penjelasan Docker & Docker Compose

### Apa itu Docker?
Docker itu seperti "kotak virtual" yang berisi semua yang dibutuhkan aplikasi kita untuk jalan. Jadi aplikasi kita bisa jalan di komputer siapa aja tanpa ribet install-install dependency!

### Apa itu Docker Compose?
Docker Compose itu tools buat manage banyak container sekaligus. Dalam project ini kita punya 4 container:

1. **🌐 Nginx Container** - Web server yang handle request HTTP
2. **⚡ PHP-FPM Container** - Processor untuk file-file PHP
3. **🗃️ MySQL Container** - Database server
4. **🔧 phpMyAdmin Container** - Interface buat manage database

### File-File Docker yang Penting:

#### 📄 `Dockerfile` (untuk PHP-FPM)
```dockerfile
FROM php:8.1-fpm                    # Base image PHP-FPM
WORKDIR /var/www/html              # Set working directory
RUN docker-php-ext-install pdo_mysql  # Install extension MySQL
# TIDAK COPY file - pakai volume mounting!
CMD ["php-fpm"]                    # Jalanin PHP-FPM
```

#### 📄 `Dockerfile.nginx` (untuk Nginx)
```dockerfile
FROM nginx:1.25-alpine             # Base image Nginx (ukuran kecil)
COPY nginx.conf /etc/nginx/conf.d/ # Copy config Nginx kita
# TIDAK COPY file aplikasi - pakai volume mounting!
CMD ["nginx", "-g", "daemon off;"] # Jalanin Nginx
```

### 🔥 Keunggulan Volume Mounting:
- **Live Reload**: Edit code langsung keliatan tanpa rebuild!
- **Development Mode**: Perfect buat mahasiswa yang lagi belajar
- **Faster Development**: Gak perlu restart container setiap edit file
- **Real-time Changes**: Edit CSS/PHP langsung refresh browser aja

### 🎓 Educational Features:
- **No Auto Restart**: Container yang mati TIDAK auto restart
- **Learning Troubleshooting**: Mahasiswa belajar debug container issues
- **Real World Skills**: Persiapan buat production environment

#### 📄 `docker-compose.yml` (Orchestration)
```yaml
services:
  nginx:                           # Service web server
    build:
      dockerfile: Dockerfile.nginx
    ports:
      - "8080:80"                  # Port mapping

  php:                             # Service PHP processor
    build: .
    depends_on:
      - mysql                      # Tunggu MySQL dulu

  mysql:                           # Service database
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=root_password
```

## 🚀 Quick Start - Gampang Banget!

### Pakai Docker (Recommended - Gampang!)

1. **Clone repository ini:**
   ```bash
   git clone <repository-url>
   cd php-todo
   ```

2. **Jalanin aplikasi (cuma satu command!):**
   ```bash
   docker-compose up -d
   ```
   > `-d` artinya detached mode (jalan di background)

3. **Akses aplikasi:**
   - 📱 **Todo App**: http://localhost:8080
   - 🗃️ **phpMyAdmin**: http://localhost:8081 (username: `root`, password: `root_password`)

4. **🔥 Development Mode - Edit & Langsung Keliatan!**
   ```bash
   # Edit file PHP/CSS apa aja
   vim index.php
   
   # Refresh browser -> langsung update! 🚀
   # TIDAK PERLU rebuild container!
   ```

5. **Stop aplikasi:**
   ```bash
   docker-compose down
   ```

### Install Manual (Agak Ribet, tapi bisa!)

1. **Install requirements:**
   - PHP 8.1+ dengan extension PDO MySQL
   - MySQL 8.0+
   - Web server (Apache/Nginx)

2. **Setup database:**
   ```bash
   mysql -u root -p < database.sql
   ```

3. **Konfigurasi database di `config.php`**

4. **Jalanin lewat web server**

## ⚙️ Environment Variables

Aplikasi ini support environment variables (bisa diubah lewat docker-compose.yml):

- `DB_HOST` - Host database (default: mysql)
- `DB_NAME` - Nama database (default: todo_app)
- `DB_USER` - Username database (default: todo_user)
- `DB_PASS` - Password database (default: todo_password)

## 🧪 Testing & CI/CD

Project ini udah include automated testing via GitHub Actions yang keren:

- ✅ **PHP Syntax Validation** - Ngecek syntax PHP bener atau nggak
- ✅ **Database Connection Testing** - Test koneksi ke database
- ✅ **CRUD Operations Testing** - Test semua fitur CRUD
- ✅ **Security Checks** - Ngecek keamanan aplikasi
- ✅ **Docker Build Testing** - Test build Docker image

### Test Manual di Local:
```bash
# Validasi syntax PHP
find . -name "*.php" -exec php -l {} \;

# Test dengan Docker
docker-compose up -d
# Akses http://localhost:8080 dan test manual
docker-compose down
```

## 📖 Cara Pakai Aplikasi

### ➕ Nambah Todo Baru

1. Isi form di halaman utama
2. **Wajib**: Title (max 255 karakter)
3. **Optional**: Description (max 5000 karakter)
4. Pilih priority dan status
5. Klik tombol "Add Todo"

### 👀 Lihat Daftar Todo

- Halaman utama nampilin semua todo dalam bentuk tabel
- Pake tombol filter buat nampilin status tertentu
- Klik "View" buat lihat detail lengkap
- Todo diurutkan berdasarkan tanggal dibuat (terbaru duluan)

### ✏️ Edit Todo

1. Klik "Edit" dari halaman utama atau tombol "Edit" di detail view
2. Ubah field yang mau diubah
3. Klik "Update Todo" buat save perubahan

### 🗑️ Hapus Todo

1. Klik "Delete" dari daftar todo mana aja
2. Konfirmasi hapus di popup
3. Todo akan dihapus permanen

## 🔒 Fitur Keamanan

- ✅ **Pencegahan SQL Injection** - Pake prepared statements
- ✅ **Proteksi XSS** - HTML escaping di semua output
- ✅ **Validasi Input** - Input divalidasi dan disanitasi
- ✅ **Session-based Messaging** - Pesan error/sukses pake session
- ✅ **Environment Variables** - Data sensitif disimpan di env vars

## 🎨 Architecture & Flow

```
📱 User Request → 🌐 Nginx → ⚡ PHP-FPM → 🗃️ MySQL
                     ↓
              🎨 Static Files (CSS/JS)
```

### Kenapa Nginx + PHP-FPM?
- **Performance** 🚀 - Lebih cepat dari Apache+mod_php
- **Scalability** 📈 - Bisa handle lebih banyak request
- **Modern** 💡 - Industry standard untuk aplikasi PHP
- **Separation of Concerns** 🏗️ - Web server dan PHP processor terpisah

## 🛠️ Development

### Code Style
- PHP PSR-12 coding standards
- Bootstrap 5 components untuk UI
- Responsive design principles
- Clean, semantic HTML

### Mau Contribute?
1. Fork repository ini
2. Bikin feature branch baru
3. Commit changes kalian
4. Bikin pull request
5. Wait for review! 😊

## 📚 Learning Resources

- **NGINX_GUIDE.md** - Panduan lengkap Nginx untuk mahasiswa
- **DEVELOPMENT_GUIDE.md** - Panduan development dengan live reload
- **TROUBLESHOOTING.md** - Panduan fix container yang mati (WAJIB BACA!)
- **SCREENSHOT_GUIDE.md** - Cara ambil screenshot untuk dokumentasi
- **Database Schema** - Lihat di file `database.sql`
- **Docker Docs** - https://docs.docker.com/
- **PHP Official Docs** - https://www.php.net/docs.php

## 📝 License

Project ini menggunakan MIT License - bebas dipake buat belajar!

## 🆘 Butuh Bantuan?

Kalau ada masalah atau pertanyaan:
1. Cek dulu **NGINX_GUIDE.md** dan **README.md** ini
2. Lihat di **Issues** GitHub repository
3. Kalau masih stuck, bikin issue baru dengan detail yang jelas

---

**Happy Coding! 🚀✨**

*Made with ❤️ for CCIT Students*