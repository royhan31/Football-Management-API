
# ⚽ Football Management API – Laravel

Sistem manajemen sepak bola berbasis REST API menggunakan Laravel. Mendukung fitur seperti autentikasi pengguna, manajemen tim, pemain, pertandingan, hasil pertandingan, hingga laporan performa.

---

## 🚀 Fitur Utama

- Autentikasi (Register & Login) menggunakan Laravel Sanctum
- CRUD Tim Sepak Bola (dengan upload logo)
- CRUD Pemain per Tim
- CRUD Jadwal Pertandingan
- Input dan update hasil pertandingan
- Statistik gol pemain
- Laporan hasil pertandingan

---

## 🔧 Instalasi

1. **Clone repository:**
   ```bash
   git clone https://github.com/nama-user/football-api.git
   cd football-api
   ```

2. **Install dependency:**
   ```bash
   composer install
   ```

3. **Copy file `.env`:**
   ```bash
   cp .env.example .env
   ```

4. **Generate key & migrate database:**
   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   ```

5. **Jalankan server:**
   ```bash
   php artisan serve
   ```

---

## 📡 Dokumentasi API

### 🧑‍💻 Autentikasi
| Method | Endpoint        | Deskripsi        |
|--------|------------------|------------------|
| POST   | `/api/register` | Registrasi user baru |
| POST   | `/api/login`    | Login & dapatkan token |

> Semua endpoint berikut membutuhkan Header:
```
Authorization: Bearer {token}
Accept: application/json
```

### 🏟️ Tim
| Method | Endpoint           | Deskripsi           |
|--------|--------------------|---------------------|
| GET    | `/api/teams`       | Ambil semua tim     |
| GET    | `/api/teams/{id}`  | Detail tim tertentu |
| POST   | `/api/teams`       | Tambah tim          |
| POST   | `/api/teams/{id}`  | Update tim          |
| DELETE | `/api/teams/{id}`  | Hapus tim           |

> Body `POST` & `UPDATE`: gunakan `form-data` dengan `logo` sebagai file

### 🧍 Pemain
| Method | Endpoint              | Deskripsi             |
|--------|------------------------|------------------------|
| GET    | `/api/players`         | Semua pemain           |
| GET    | `/api/players/{id}`    | Detail pemain          |
| POST   | `/api/players`         | Tambah pemain          |
| PUT    | `/api/players/{id}`    | Update pemain          |
| DELETE | `/api/players/{id}`    | Hapus pemain           |

### 🗓️ Pertandingan
| Method | Endpoint               | Deskripsi             |
|--------|------------------------|------------------------|
| GET    | `/api/matches`         | Semua jadwal pertandingan |
| GET    | `/api/matches/{id}`    | Detail pertandingan     |
| POST   | `/api/matches`         | Tambah pertandingan     |
| PUT    | `/api/matches/{id}`    | Update pertandingan     |
| DELETE | `/api/matches/{id}`    | Hapus pertandingan      |

### 🥅 Hasil Pertandingan
| Method | Endpoint                         | Deskripsi                 |
|--------|----------------------------------|---------------------------|
| GET    | `/api/result/matches`           | Semua hasil pertandingan  |
| GET    | `/api/result/matches/{id}`      | Detail hasil pertandingan |
| POST   | `/api/result/matches`           | Input hasil pertandingan  |
| PUT    | `/api/result/matches/{id}`      | Update hasil pertandingan |
| DELETE | `/api/result/matches/{id}`      | Hapus hasil pertandingan  |

### ⚽ Gol
| Method | Endpoint              | Deskripsi           |
|--------|------------------------|----------------------|
| GET    | `/api/goals`          | Semua data gol       |
| GET    | `/api/goals/{id}`     | Detail gol           |
| POST   | `/api/goals`          | Tambah data gol      |
| PUT    | `/api/goals/{id}`     | Update data gol      |
| DELETE | `/api/goals/{id}`     | Hapus data gol       |

### 📊 Laporan
| Method | Endpoint         | Deskripsi                    |
|--------|------------------|------------------------------|
| GET    | `/api/reports`   | Statistik pertandingan       |

---

## 📁 Struktur Direktori Penting

```
app/
├── Http/Controllers/
├── Models/
├── Http/Requests/
routes/
└── api.php
storage/app/public/       // lokasi file upload logo
```

---

## 🛡️ Autentikasi

Menggunakan Laravel Sanctum. Token akan diberikan saat login dan digunakan pada setiap request yang dilindungi.

```http
Authorization: Bearer <token>
```

---

## 🧪 Testing

Gunakan [Postman Collection](./Football%20Collection.postman_collection.json) untuk mencoba endpoint API.

---

## 👨‍💻 Kontributor
- Izzatur Royhan

---

## 📄 Lisensi

Proyek ini berada di bawah lisensi MIT.
