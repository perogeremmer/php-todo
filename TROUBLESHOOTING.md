# 🛠️ Troubleshooting Guide - Container Mati? Jangan Panik! 

## 🚨 Container Mati? Ini yang Harus Dilakukan!

### 📋 **Quick Checklist**
```bash
# 1. Cek status semua container
docker-compose ps

# 2. Cek log container yang bermasalah  
docker-compose logs <nama-service>

# 3. Start ulang container yang mati
docker-compose up -d <nama-service>

# 4. Kalau masih error, rebuild
docker-compose up --build <nama-service>
```

## 🔍 **Step-by-Step Troubleshooting**

### 1️⃣ **Identifikasi Masalah**
```bash
# Cek container mana yang mati
docker-compose ps

# Output contoh:
# php-todo-nginx    Exit 1    # <- Yang ini mati!
# php-todo-php     Up         # <- Yang ini hidup
# php-todo-mysql   Up         # <- Yang ini hidup
```

### 2️⃣ **Cek Log Error**
```bash
# Cek log container yang mati (ganti 'nginx' sesuai yang mati)
docker-compose logs nginx

# Cek log dengan follow (real-time)
docker-compose logs -f nginx

# Cek log semua container
docker-compose logs
```

### 3️⃣ **Fix Masalahnya**
Berdasarkan error di log, fix masalahnya (lihat section Common Errors di bawah)

### 4️⃣ **Start Ulang Container**
```bash
# Start container specific
docker-compose up -d nginx

# Atau start semua
docker-compose up -d
```

## ⚠️ **Common Errors & Solutions**

### 🌐 **Nginx Container Error**

#### **Error: "nginx: [emerg] invalid value"**
```bash
# Penyebab: Ada kesalahan di nginx.conf
# Solution:
1. Cek syntax nginx.conf
2. Fix error di config file
3. Restart: docker-compose up -d nginx
```

#### **Error: "bind: address already in use"**
```bash
# Penyebab: Port 8080 udah dipake aplikasi lain
# Solution:
1. Stop aplikasi yang pake port 8080
2. Atau ganti port di docker-compose.yml:
   ports:
     - "8081:80"  # Ganti dari 8080 ke 8081
```

### ⚡ **PHP Container Error**

#### **Error: "Fatal error: syntax error"**
```bash
# Penyebab: Ada syntax error di file PHP
# Solution:
1. Cek file PHP yang error (lihat di log)
2. Fix syntax error
3. Container otomatis reload (karena volume mounting)
```

#### **Error: "could not find driver"**
```bash
# Penyebab: Extension MySQL belum terinstall
# Solution:
1. Cek Dockerfile ada RUN docker-php-ext-install pdo_mysql
2. Rebuild: docker-compose up --build php
```

### 🗃️ **MySQL Container Error**

#### **Error: "mysqld: Can't create directory"**
```bash
# Penyebab: Permission problem atau disk full
# Solution:
1. Cek disk space: df -h
2. Fix permission: sudo chown -R $USER:$USER .
3. Remove volume: docker-compose down -v
4. Start ulang: docker-compose up -d
```

#### **Error: "Access denied for user"**
```bash
# Penyebab: Wrong password atau user
# Solution:
1. Cek environment variables di docker-compose.yml
2. Reset database:
   docker-compose down -v
   docker-compose up -d
```

## 🔧 **Advanced Troubleshooting**

### **Masuk ke Container untuk Debug**
```bash
# Masuk ke PHP container
docker exec -it php-todo-php bash

# Masuk ke Nginx container  
docker exec -it php-todo-nginx sh

# Masuk ke MySQL container
docker exec -it php-todo-mysql mysql -u root -p
```

### **Cek File dan Permission**
```bash
# Cek file di dalam container
docker exec -it php-todo-php ls -la /var/www/html

# Cek nginx config
docker exec -it php-todo-nginx cat /etc/nginx/conf.d/default.conf

# Test nginx config
docker exec -it php-todo-nginx nginx -t
```

### **Reset Everything (Nuclear Option)**
```bash
# Stop semua dan hapus volume
docker-compose down -v

# Hapus semua image
docker-compose down --rmi all

# Build ulang dari nol
docker-compose up --build -d

# HATI-HATI: Ini akan hapus semua data MySQL!
```

## 🎯 **Tips Mencegah Error**

### ✅ **Development Best Practices**
```bash
# Selalu cek syntax sebelum save
php -l index.php

# Cek nginx config sebelum restart
nginx -t

# Monitor log real-time saat development
docker-compose logs -f
```

### ✅ **File Permission**
```bash
# Set permission yang benar
chmod -R 755 .
chown -R $USER:$USER .

# Jangan edit file sebagai root
```

### ✅ **Resource Management**
```bash
# Cek disk space secara berkala
df -h

# Clean up Docker yang tidak terpakai
docker system prune

# Stop container yang tidak diperlukan
```

## 📞 **Kalau Masih Stuck?**

### 1. **Cek Documentation**
- Baca `DEVELOPMENT_GUIDE.md`
- Baca `NGINX_GUIDE.md`
- Cek `README.md`

### 2. **Search Error Message**
- Copy exact error message
- Google dengan keyword: "docker nginx [error message]"
- Cek Stack Overflow

### 3. **Ask for Help**
- Paste full error log (dari `docker-compose logs`)
- Explain apa yang lagi dicoba
- Share steps yang udah dilakukan

## 🎓 **Learning Goals**

Dengan troubleshooting sendiri, mahasiswa akan belajar:
- **Problem Solving Skills** - Debug systematic
- **Docker Knowledge** - Understand container lifecycle  
- **System Administration** - Handle service failures
- **Log Analysis** - Read dan understand error messages
- **Real World Skills** - Persiapan buat production environment