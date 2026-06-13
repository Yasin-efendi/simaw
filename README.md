# 🎓 Sistem Kuis Sekolah Dasar (Simaw)

Aplikasi manajemen kuis pembelajaran interaktif yang dirancang khusus untuk Sekolah Dasar. Menyediakan pengalaman mengerjakan soal yang ramah anak, mobile-friendly, serta panel manajemen yang komprehensif untuk Guru/Admin dengan fitur analitik dan export laporan.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3-4B32C3?style=flat&logo=livewire)
![Tailwind](https://img.shields.io/badge/Tailwind-CSS-38BDF8?style=flat&logo=tailwindcss)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat)

---

## ✨ Fitur Utama

### 🎓 Untuk Siswa
- ✅ **Validasi Entry Unik**: Sistem mencegah siswa mengerjakan kuis lebih dari 1 kali berdasarkan kombinasi Nama & Nomor Absen.
- ✅ **Flow Kuis One-by-One**: Tampilan soal satu per satu dengan progress bar visual dan navigasi yang mulus (sangat optimal untuk layar HP).
- ✅ **Dukungan Multimedia**: Soal dapat dilengkapi dengan gambar (upload opsional).
- ✅ **Hasil & Pembahasan Instan**: Halaman hasil dengan skor besar, statistik benar/salah, dan **Modal Pembahasan Interaktif** yang menandai jawaban benar (hijau) dan salah (merah).

### 🛠️ Untuk Guru / Admin
- ✅ **Manajemen Hierarki Lengkap**: CRUD bertingkat untuk Kelas (Grade) → Mata Pelajaran (Subject) → Bab Materi (Topic) → Pertemuan (Meeting).
- ✅ **Bank Soal Canggih**: CRUD soal pilihan ganda dengan upload gambar, validasi ketat, dan preview real-time.
- ✅ **Leaderboard Real-time**: Peringkat siswa berdasarkan nilai tertinggi, dilengkapi statistik rata-rata kelas.
- ✅ **Export Laporan PDF**: Unduh laporan hasil kuis dalam format PDF yang rapi dan siap cetak/arsip.

### ⚙️ Teknis & Arsitektur
- ✅ **Strict Typing PHP 8.4**: Kode backend ditulis dengan tipe data yang ketat (`?int`, `Collection`, `UploadedFile`) untuk mencegah bug dan meningkatkan *maintainability*.
- ✅ **Database Transactions**: Penyimpanan hasil kuis (`StudentAttempt` + `AttemptAnswer`) dibungkus dalam transaksi atomik untuk mencegah data korup.
- ✅ **Eager Loading Optimized**: Mencegah masalah *N+1 Query* pada hierarki data yang dalam (misal: `Quiz -> Meeting -> Topic -> Subject -> Grade`).
- ✅ **Modern UI/UX**: Menggunakan efek *Glassmorphism* dan *Smooth Morphing Background* (CSS Keyframes) yang ringan dan ramah performa.
- ✅ **Livewire v3 Best Practices**: Pemanfaatan `#[Computed]`, `@entangle`, dan `wire:confirm` untuk interaktivitas tanpa reload halaman.

---

## 🚀 Tech Stack

| Kategori | Teknologi |
| :--- | :--- |
| **Framework** | Laravel 11.x |
| **Frontend Interaktif** | Livewire 3 + Alpine.js |
| **Styling** | Tailwind CSS v3.x + Vite |
| **Database** | MySQL 8.0 |
| **Authentication** | Laravel Breeze (Livewire Stack) |
| **PDF Generation** | barryvdh/laravel-dompdf |
| **File Storage** | Laravel Local Storage (Symbolic Link) |

---

## 📦 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+ & NPM
- MySQL / MariaDB

### Langkah Instalasi
```bash
# 1. Clone repository
git clone https://github.com/Yasin-efendi/quiz-sd.git
cd quiz-sd

# 2. Install dependencies PHP & Node.js
composer install
npm install

# 3. Copy environment file & generate key
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di file .env
# DB_DATABASE=nama_database
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi & seeder (mengisi data dummy hierarki + 1 akun admin)
php artisan migrate --seed

# 6. Buat symbolic link untuk folder storage (agar gambar soal bisa diakses)
php artisan storage:link

# 7. Compile aset frontend (untuk production) atau jalankan dev server
npm run build
# atau untuk development: npm run dev

# 8. Jalankan server
php artisan serve
```
Buka aplikasi di browser: [http://localhost:8000](http://localhost:8000)

---

## 🔐 Akun Default

Setelah menjalankan `php artisan migrate --seed`, akun berikut tersedia untuk mengakses panel admin:

| Role | Email | Password |
| :--- | :--- |--- |
| **Admin** | `admin@sekolah.sch.id` | `password123` |

⚠️ *Sangat disarankan untuk mengubah kredensial ini atau menghapus seeder admin sebelum deploy ke production.*

---

## 🗺️ Struktur Rute (Routing)

### Halaman Publik (Tanpa Login)
| Halaman | URL | Keterangan |
| :--- | :--- | :--- |
| Entry Kuis | `/quiz/{quiz}` | Input Nama & No. Absen (dengan validasi unik) |
| Pengerjaan | `/quiz/take/{quiz}` | Tampilan soal *one-by-one* |
| Hasil Kuis | `/quiz/result/{attempt}` | Skor, statistik, dan tombol modal pembahasan |

### Halaman Admin (Login Required)
| Halaman | URL | Keterangan |
| :--- | :--- | :--- |
| Dashboard | `/dashboard` | Redirect ke menu manajemen |
| Kelola Kelas | `/grades` | CRUD Nama Kelas (Grade) |
| Kelola Mapel | `/subjects` | CRUD Mata Pelajaran per Kelas |
| Kelola Bab | `/topics` | CRUD Topik/Bab per Mata Pelajaran |
| Kelola Pertemuan| `/meetings` | CRUD Pertemuan per Bab |
| Bank Soal | `/questions` | CRUD Soal Pilihan Ganda + Upload Gambar |
| Leaderboard | `/quiz/{quiz}/leaderboard`| Peringkat siswa & Export PDF |

---

## 📁 Struktur Proyek (Highlights)

```text
quiz-sd/
├── app/
│   ├── Livewire/                  # Komponen Livewire 3 (Panel Guru & Kuis Siswa)
│   │   ├── ManageGrades.php
│   │   ├── ManageQuestions.php
│   │   ├── QuizEntry.php
│   │   ├── QuizTake.php
│   │   ├── QuizResult.php
│   │   └── QuizLeaderboard.php
│   └── Models/                    # Eloquent Models dengan Strict Typing & Relasi
├── database/
│   ├── factories/                 # Factory untuk data dummy yang realistis & koheren
│   ├── migrations/                # Skema database dengan Foreign Key & Unique Constraint
│   └── seeders/                   # DatabaseSeeder & AdminSeeder
├── resources/
│   ├── css/app.css                # Custom CSS (Morphing Background, Glassmorphism)
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php      # Layout default Breeze
│       │   └── quiz.blade.php     # Layout khusus siswa (tanpa sidebar)
│       ├── livewire/              # View komponen Livewire
│       └── pdf/
│           └── leaderboard.blade.php # Template khusus DomPDF (HTML Tabel Klasik)
└── routes/
    └── web.php                    # Definisi rute publik dan terproteksi
```

---

## 🧠 Konsep Penting yang Diterapkan

1. **Livewire v3 Computed Properties**
   Menggantikan sintaks v2 `get...Property` dengan atribut `#[Computed]` yang lebih bersih dan di-cache otomatis.
   ```php
   #[Computed]
   public function progressPercentage(): float {
       return (($this->currentIndex + 1) / $this->questions->count()) * 100;
   }
   // Dipanggil di Blade sebagai: {{ $this->progressPercentage }}
   ```

2. **Database Transactions untuk Atomic Saves**
   Memastikan data `StudentAttempt` dan `AttemptAnswer` tersimpan bersamaan. Jika satu gagal, semua di-*rollback*.
   ```php
   DB::transaction(function () {
       $attempt = StudentAttempt::create([...]);
       foreach ($questions as $q) {
           AttemptAnswer::create([...]);
       }
   });
   ```

3. **Nested Eager Loading**
   Menghindari *N+1 Query* saat menampilkan hierarki dalam di dropdown atau tabel.
   ```php
   Meeting::with(['topic.subject.grade'])->get();
   ```

---

## 🛠️ Troubleshooting

| Masalah | Solusi |
| :--- | :--- |
| **Gambar soal tidak muncul (404)** | Pastikan sudah menjalankan `php artisan storage:link` |
| **Error `Undefined variable $progressPercentage`** | Pastikan menggunakan sintaks Livewire v3: `{{ $this->progressPercentage }}` |
| **Error `Unknown column 'student_attempt_id'`** | Pastikan relasi `hasMany` di Model `StudentAttempt` menyebutkan `'attempt_id'` secara eksplisit. |
| **PDF export berantakan/tidak ada style** | DomPDF memiliki dukungan CSS terbatas. Pastikan view PDF menggunakan tabel HTML klasik dengan inline style, bukan Flexbox/Grid modern. |
| **Background morphing tidak muncul** | Pastikan `npm run build` atau `npm run dev` sudah dijalankan agar file `app.css` ter-compile oleh Vite. |

---

## 🤝 Kontribusi

Proyek ini dibangun dengan pendekatan *learning by doing*. Saran, *bug report*, dan *Pull Request* sangat diterima untuk meningkatkan kualitas aplikasi.

1. Fork repository ini
2. Buat branch fitur baru: `git checkout -b fitur/nama-fitur`
3. Commit perubahan: `git commit -m 'feat: deskripsi fitur yang ditambahkan'`
4. Push ke branch: `git push origin fitur/nama-fitur`
5. Buat Pull Request

---

## 📄 License

Dibagikan di bawah lisensi [MIT](LICENSE). Bebas digunakan, dimodifikasi, dan didistribusikan untuk tujuan edukasi dan pembelajaran.

**🎯 Dibuat dengan ❤️ untuk mendukung transformasi digital pembelajaran di Sekolah Dasar Indonesia.**
```