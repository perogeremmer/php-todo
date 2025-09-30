# 📸 Screenshot Guide untuk README

Setelah aplikasi jalan dengan `docker-compose up -d`, ambil screenshot berikut:

## 📱 Screenshots yang Dibutuhkan

### 1. **Main Page (main-page.png)**
- **URL**: http://localhost:8080
- **Yang harus terlihat**:
  - Header "Todo List Application"
  - Form "Add New Todo" 
  - Filter buttons (All, Pending, In Progress, Completed)
  - Tabel dengan sample todos
  - Action buttons (View, Edit, Delete)
  - Bootstrap styling yang rapi

### 2. **Detail Page (detail-page.png)**
- **URL**: http://localhost:8080/detail.php?id=1
- **Yang harus terlihat**:
  - Breadcrumb navigation
  - Todo detail lengkap (title, description, status, priority, dates)
  - Edit button dan Back to List button
  - Info card di sebelah kanan

### 3. **Edit Mode (edit-mode.png)**
- **URL**: http://localhost:8080/detail.php?id=1&edit=1
- **Yang harus terlihat**:
  - Form edit dengan semua field terisi
  - Dropdown untuk status dan priority
  - Update, Cancel, dan Delete buttons

### 4. **Mobile View (mobile-view.png)**
- **URL**: http://localhost:8080
- **Settings**: Buka developer tools, set ke mobile view (iPhone/Android)
- **Yang harus terlihat**:
  - Responsive layout
  - Mobile-friendly buttons
  - Readable text dan proper spacing

### 5. **phpMyAdmin (phpmyadmin.png)**
- **URL**: http://localhost:8081
- **Login**: Username: `root`, Password: `root_password`
- **Yang harus terlihat**:
  - Database `todo_app` di sidebar
  - Tabel `todos` dengan sample data
  - Interface phpMyAdmin yang clean

## 🛠️ Tips Screenshot

### Browser Settings:
- Gunakan browser dalam mode normal (bukan dark mode)
- Zoom 100%
- Window size standar (1920x1080 atau 1366x768)

### Screenshot Tools:
- **Windows**: Snipping Tool atau Windows + Shift + S
- **Mac**: Command + Shift + 4
- **Linux**: Gnome Screenshot atau Shutter

### File Requirements:
- Format: PNG
- Ukuran: Max 1MB per file
- Resolution: Minimal 800px width
- Nama file sesuai dengan yang ada di README.md

## 📁 Folder Structure
```
screenshots/
├── main-page.png
├── detail-page.png
├── edit-mode.png
├── mobile-view.png
└── phpmyadmin.png
```

## 🎯 Quality Checklist

- [ ] Semua text mudah dibaca
- [ ] UI elements tidak terpotong
- [ ] Warna dan styling terlihat bagus
- [ ] Tidak ada informasi sensitif (password, etc)
- [ ] File size reasonable (< 1MB)

## 📝 Cara Ambil Screenshot

1. **Start aplikasi**:
   ```bash
   docker-compose up -d
   ```

2. **Wait sampai semua container healthy**:
   ```bash
   docker-compose ps
   ```

3. **Buka browser dan akses URL**

4. **Ambil screenshot sesuai list di atas**

5. **Save ke folder `screenshots/`**

6. **Verify di README.md** - pastikan link screenshot berfungsi

## 🔄 Update Screenshot

Kalau ada perubahan UI, jangan lupa update screenshot yang relevan!

---

**Good luck with your screenshots! 📸✨**