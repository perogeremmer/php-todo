# 🔥 Development Guide - Live Reload dengan Volume Mounting

## 🎯 Kenapa Pakai Volume Mounting?

Dalam project ini, kita **TIDAK** pakai `COPY` di Dockerfile buat copy file aplikasi. Instead, kita pakai **volume mounting** yang bikin development jadi super enak!

## 🚀 Keunggulan Volume Mounting

### ✅ **Live Reload - Edit Langsung Keliatan!**
```bash
# Mahasiswa edit file index.php
vim index.php

# Refresh browser -> langsung keliatan perubahannya!
# TIDAK PERLU rebuild container!
```

### ✅ **Faster Development Workflow**
```bash
# Workflow TANPA volume mounting (ribet):
1. Edit file
2. docker-compose down
3. docker-compose up --build  # Rebuild image
4. Tunggu 2-3 menit
5. Test changes

# Workflow DENGAN volume mounting (cepet!):
1. Edit file
2. Refresh browser  # Done! 🎉
```

## 🏗️ Cara Kerja Volume Mounting

### Di `docker-compose.yml`:
```yaml
services:
  nginx:
    volumes:
      - .:/var/www/html  # Mount direktori saat ini ke container
  
  php:
    volumes:
      - .:/var/www/html  # Mount yang sama
```

### Penjelasan:
- **`.`** = Direktori saat ini (project folder)
- **`/var/www/html`** = Direktori di dalam container
- **Mount** = "Sambungkan" folder host ke container

## 🧪 Test Live Reload

### 1. **Pastikan container jalan:**
```bash
docker-compose up -d
```

### 2. **Akses aplikasi:**
```bash
# Buka browser: http://localhost:8080
```

### 3. **Edit file dan test:**
```bash
# Edit file CSS
vim assets/style.css

# Tambahkan style baru:
h1 { color: red; }

# Refresh browser -> langsung keliatan!
```

### 4. **Edit file PHP:**
```bash
# Edit index.php
vim index.php

# Ubah title atau tambah text
# Refresh browser -> langsung update!
```

## 📁 File yang Bisa Diedit Live

| File Type | Location | Impact |
|-----------|----------|---------|
| **PHP** | `*.php`, `actions/*.php` | ✅ Langsung reload |
| **CSS** | `assets/style.css` | ✅ Langsung reload |
| **HTML** | Dalam file PHP | ✅ Langsung reload |
| **Config** | `nginx.conf` | ❌ Perlu restart container |
| **Docker files** | `Dockerfile*` | ❌ Perlu rebuild |

## 🔄 Kapan Perlu Restart/Rebuild

### Restart Container Aja:
```bash
docker-compose restart nginx
```
- Kalau edit `nginx.conf`
- Kalau ada masalah permission

### Rebuild Image:
```bash
docker-compose up --build
```
- Kalau edit `Dockerfile` atau `Dockerfile.nginx`
- Kalau tambah dependency baru

## ⚠️ Kenapa TIDAK Pakai Auto Restart?

### 🎓 **Educational Purpose**
Project ini **SENGAJA** tidak pakai `restart: unless-stopped` karena:

#### ✅ **Mahasiswa Belajar Troubleshooting**
```bash
# Kalau container mati, mahasiswa harus:
1. Cek kenapa mati: docker-compose logs <service>
2. Fix masalahnya
3. Start lagi: docker-compose up <service>
```

#### ✅ **Understanding Container Lifecycle**
- Mahasiswa paham container bisa mati
- Belajar cara debug dan fix masalah
- Tidak bergantung pada "magic" auto restart

#### ✅ **Real World Preparation**
- Di production, harus tahu cara handle container failure
- Debugging skills lebih penting dari auto restart
- Memahami root cause, bukan cuma restart terus

### 🚨 **Kalau Container Mati, Gimana?**

#### 1. **Cek Status Container**
```bash
docker-compose ps
# Lihat mana yang Exit atau Restarting
```

#### 2. **Cek Logs untuk Debug**
```bash
# Cek log specific service
docker-compose logs nginx
docker-compose logs php
docker-compose logs mysql

# Cek log semua service
docker-compose logs
```

#### 3. **Start Ulang Service yang Mati**
```bash
# Start specific service
docker-compose up nginx

# Atau start semua yang mati
docker-compose up -d
```

### 🔧 **Common Issues & Solutions**

#### **PHP Container Mati**
```bash
# Cek log
docker-compose logs php

# Common causes:
- Syntax error di PHP
- Missing extension
- File permission problem

# Solution:
- Fix PHP syntax
- Check Dockerfile for extensions
- Fix file permissions
```

#### **Nginx Container Mati**
```bash
# Cek log
docker-compose logs nginx

# Common causes:
- Invalid nginx.conf
- Port already in use
- Volume mount problem

# Solution:
- Validate nginx config
- Check port 8080 not used
- Fix volume mounting
```

#### **MySQL Container Mati**
```bash
# Cek log
docker-compose logs mysql

# Common causes:
- Database corruption
- Out of disk space
- Invalid SQL in init script

# Solution:
- Check disk space
- Fix database.sql syntax
- Remove volume and restart
```

## 💡 Tips Development

### 1. **Multiple Terminal**
```bash
# Terminal 1: Monitoring logs
docker-compose logs -f

# Terminal 2: Edit code
vim index.php

# Terminal 3: Test curl
curl http://localhost:8080
```

### 2. **Browser Developer Tools**
- Buka F12 -> Network tab
- Disable cache buat development
- Pakai Ctrl+F5 buat hard refresh

### 3. **Common Issues**

#### File Permission Error:
```bash
# Fix permission (run di host):
sudo chown -R $USER:$USER .
chmod -R 755 .
```

#### Changes Tidak Keliatan:
```bash
# Clear browser cache
# Atau pakai incognito mode
```

## 🎓 Learning Exercise

### **Exercise 1: Edit Homepage**
1. Edit `index.php`
2. Ubah title jadi "My Awesome Todo App"
3. Refresh browser
4. Lihat perubahannya langsung!

### **Exercise 2: Custom CSS**
1. Edit `assets/style.css`
2. Tambah style baru:
   ```css
   .container {
       background-color: #f0f8ff;
   }
   ```
3. Refresh browser
4. Lihat background berubah!

### **Exercise 3: Add New Feature**
1. Tambah field baru di form
2. Edit `actions/create.php`
3. Test tanpa rebuild container

## 🔍 Debugging

### Check Volume Mounting:
```bash
# Masuk ke container dan cek file
docker exec -it php-todo-php ls -la /var/www/html

# Atau cek dari nginx container
docker exec -it php-todo-nginx ls -la /var/www/html
```

### Check File Changes:
```bash
# Edit file di host
echo "<!-- test -->" >> index.php

# Cek di container
docker exec -it php-todo-php cat /var/www/html/index.php | tail -1
```

---

**Happy Live Coding! 🚀✨**

*Dengan volume mounting, development jadi jauh lebih enak dan cepat!*