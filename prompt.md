── PERSONA & ATURAN INTERAKSI ──────────────────────────────────

Halo! Saya adalah developer pemula yang ingin membangun aplikasi web latihan soal/kuis untuk Sekolah Dasar (SD) dengan pendekatan Learning Management System (LMS).

Tolong bertindak sebagai Senior Full-Stack Developer dan Mentor pemrograman yang sabar.

Aturan interaksi yang wajib diikuti:
- Jangan berikan semua kode sekaligus.
- Pandu saya langkah demi langkah (step-by-step).
- Setiap langkah: jelaskan konsepnya dulu, baru tulis kodenya.
- Tulis satu file per respons, kecuali saya meminta lebih.
- Tunggu konfirmasi saya di setiap langkah sebelum lanjut.
- Pastikan kamu percaya diri dengan kemampuan dan pemahaman framework serta versi yang digunakan.


── STACK & LINGKUNGAN PENGEMBANGAN ─────────────────────────────

Framework & Library:
- Laravel 11
- Livewire 3
- Tailwind CSS 3
- Alpine.js 3

Lingkungan lokal (Windows / XAMPP):
- PHP 8.4.15 (via XAMPP)
- Node.js v24.10.0
- Composer 2.8.12
- Database: MySQL (via XAMPP)

Target deployment: Shared Hosting atau VPS (opsional, dikerjakan setelah fitur selesai).
Saat ini: Pengembangan lokal.


── PARADIGMA: LMS & WORKFLOW-ORIENTED ──────────────────────────

Aplikasi ini menggunakan pendekatan LMS (Learning Management System), BUKAN CMS CRUD biasa.

Artinya:
- Dashboard guru adalah "briefing aktif", bukan menu navigasi ke tabel database.
  Contoh: "Ada 2 pertemuan minggu ini yang belum punya kuis" — bukan "Pilih: Kelas / Mapel / Soal".
- Pembuatan konten menggunakan wizard satu alur (Meeting → Kuis → Soal),
  bukan form terpisah di halaman berbeda.
- Setiap entitas memiliki status/progress yang terlihat:
  Meeting: [Draft | Siap | Selesai]
  Kuis: [Belum ada soal | Siap | Sedang berlangsung | Ditutup]
- Halaman kuis siswa bersifat kontekstual: menampilkan nama kelas, mapel,
  dan judul pertemuan sebelum siswa mulai mengerjakan.
- Dashboard adalah workflow-oriented, bukan database-oriented.


── PETA JALAN PENGERJAAN (URUTAN LANGKAH) ──────────────────────

Kerjakan secara berurutan, jangan melompat langkah:

  Langkah 1.  Desain ERD dan penjelasan relasi antar tabel
              (termasuk kolom status untuk Meeting dan Kuis)
  Langkah 2.  Semua file migrasi database
  Langkah 3.  Semua Model Eloquent beserta relasi
  Langkah 4.  Seeder dan Factory untuk data contoh
  Langkah 5.  Autentikasi Admin dan Guru (Laravel Breeze)
  Langkah 6.  Workflow dashboard guru
              (briefing aktif: pertemuan pending, kuis belum lengkap,
               ringkasan pengerjaan siswa terbaru)
  Langkah 7.  Wizard pembuatan konten: Meeting → Kuis → Soal
              (satu alur, komponen Livewire multi-step)
  Langkah 8.  Manajemen soal: tambah/edit/hapus soal dalam kuis
              (dengan upload gambar opsional)
  Langkah 9.  Panel Admin: kelola akun Guru
  Langkah 10. Halaman kuis siswa — kontekstual
              (tampil nama kelas, mapel, pertemuan + form nama & no. absen)
  Langkah 11. Komponen Livewire kuis card one-by-one
  Langkah 12. Halaman hasil, skor, dan modal pembahasan
  Langkah 13. Leaderboard dan riwayat nilai detail (panel Guru)
  Langkah 14. Persiapan deploy (opsional)


── SPESIFIKASI BISNIS: STRUKTUR DATA ───────────────────────────

1. STRUKTUR DATA & HIERARKI:
   - Grade (Kelas 1–6) → Subject (Mata Pelajaran) → Topic (Bab Materi) → Meeting (Pertemuan).
   - Setiap Meeting memiliki 2 paket kuis:
     Paket Latihan (dikerjakan bersama di kelas via Desktop)
     Paket PR (dikerjakan di rumah via Mobile).
   - Meeting dan Kuis masing-masing memiliki kolom status (enum) untuk
     mendukung tampilan progress di dashboard guru.


── SPESIFIKASI BISNIS: SOAL & KUIS ─────────────────────────────

2. STRUKTUR SOAL & KUIS:
   - Tipe soal: Pilihan Ganda (PG) dengan 4 opsi (A, B, C, D).
   - Soal menyimpan: teks pertanyaan, 4 opsi jawaban, kunci jawaban,
     teks pembahasan, dan gambar ilustrasi (opsional).
   - Tampilan kuis: soal muncul satu per satu dalam bentuk Card
     (Livewire, one-by-one, bukan scroll).
   - Siswa hanya boleh mengerjakan 1 kali per kuis.
   - Validasi attempt WAJIB disimpan di database (bukan hanya session)
     menggunakan kombinasi unik: [Nama Siswa] + [Nomor Absen] + [ID Kuis].
     Jika kombinasi sudah ada di tabel attempts, siswa diarahkan ke
     halaman hasil mereka sebelumnya.


── SPESIFIKASI BISNIS: HAK AKSES ───────────────────────────────

3. HAK AKSES (ROLES):
   - Admin  : Mengelola akun User (Guru). Tidak bisa membuat konten.
   - Guru   : Akses workflow dashboard, wizard pembuatan konten,
              manajemen soal, lihat Leaderboard & riwayat nilai siswa.
   - Siswa  : Tanpa login. Akses via link kuis yang dibagikan guru.
              Wajib input Nama & Nomor Absen sebelum mulai.


── SPESIFIKASI BISNIS: TAMPILAN & UI ───────────────────────────

4. TAMPILAN & UI (Tailwind CSS):
   - Desain ramah anak (child-friendly): sudut membulat rounded-lg,
     warna cerah dan menyenangkan.
   - Background halaman siswa: gradien diagonal cerah dengan efek
     smooth morphing (CSS animation / keyframes).
   - Dashboard guru: bersih, profesional, workflow-card based.
     Setiap card pertemuan menampilkan badge status dan progress kuis.
   - Halaman Hasil Siswa:
     Skor ditampilkan besar (misal 80/100).
     Warna indikator: Hijau jika skor >= 70, Merah jika skor < 70.
   - Tombol Pembahasan: membuka modal pop-up yang menampilkan
     semua soal. Baris soal yang benar = background hijau,
     yang salah = background merah, lengkap dengan teks pembahasan.
   - Halaman kuis siswa menampilkan konteks lengkap di header:
     nama kelas, mata pelajaran, dan judul pertemuan.


── MULAI ────────────────────────────────────────────────────────

Sekarang mulai dari Langkah 1: Desain ERD.

Jelaskan semua tabel yang diperlukan, kolom penting beserta tipe datanya,
kolom status/enum untuk Meeting dan Kuis, serta relasi antar tabel.
Gunakan pendekatan LMS: pastikan struktur data mendukung workflow guru
(briefing dashboard, wizard pembuatan konten, progress tracking)
dan pengalaman siswa yang kontekstual.

Tampilkan ERD dalam format teks/deskripsi terlebih dahulu.
Kita akan menulis kode migrasi di langkah berikutnya.