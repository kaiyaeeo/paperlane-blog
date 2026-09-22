# Paperlane

Blog sederhana yang dibangun dengan Laravel untuk belajar dan portofolio.
Paperlane adalah ruang menulis digital — tempat menulis, menerbitkan, dan
membaca tulisan dengan antarmuka yang bersih.

> Status: 🚧 Dalam pengembangan 

---

## ✨ Fitur yang Direncanakan

### Fase 1 — Fondasi
- [x] Setup Laravel & struktur project
- [x] Autentikasi (register, login, logout) dengan Laravel Breeze
- [x] Layout Blade + Tailwind CSS
- [ ] Halaman home, about, kontak

### Fase 2 — CRUD Post
- [ ] CRUD post (judul, slug, konten, status)
- [ ] Draft & published workflow
- [ ] Validasi dengan Form Request
- [ ] Pagination
- [ ] Seeder & factory untuk data dummy

### Fase 3 — Relasi
- [ ] Kategori (one-to-many)
- [ ] Tag (many-to-many)
- [ ] Upload thumbnail
- [ ] Soft delete

### Fase 4 — Publik
- [ ] Halaman publik tanpa login
- [ ] Halaman kategori & tag
- [ ] Pencarian
- [ ] Tampilan responsif

### Fase 5 — Authorization
- [ ] Role: admin, author, reader
- [ ] Policy untuk post
- [ ] Dashboard admin
- [ ] Manajemen user

### Fase 6 — Interaksi
- [ ] Komentar
- [ ] Moderasi komentar
- [ ] Notifikasi email
- [ ] Event & listener

### Fase 7 — Testing & Optimasi
- [ ] Test dengan Pest
- [ ] Refactor service/action class
- [ ] Query optimization (N+1)
- [ ] Cache

### Fase 8 — Deploy
- [ ] Deploy ke VPS
- [ ] Domain & SSL
- [ ] Backup database
- [ ] Queue worker

---

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **PHP:** 8.2+
- **Database:** MySQL 8 (bisa PostgreSQL)
- **Frontend:** Blade + Tailwind CSS + Vite
- **Auth:** Laravel Breeze
- **Testing:** Pest (rencana)

---

## 📋 Kebutuhan Sistem

Pastikan sudah terinstall:

- PHP >= 8.2 dengan ekstensi: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `json`, `mbstring`, `openssl`, `pcre`, `pdo`, `pdo_mysql`, `tokenizer`, `xml`
- Composer >= 2.0
- Node.js >= 18 & npm
- MySQL >= 8.0 atau PostgreSQL >= 13
- Git

Cek versi:

```bash
php -v
composer -V
node -v
npm -v
mysql --version