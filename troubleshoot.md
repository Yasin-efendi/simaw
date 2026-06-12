
---

## 1. Perintah Instalasi (Setup Proyek)

Jalankan perintah berikut secara berurutan untuk membuat proyek dan menginstal semua library dengan versi yang ditentukan.

```bash
# 1. Buat proyek Laravel 11 baru (Composer otomatis mendownload versi terbaru dari Laravel 11)
composer create-project laravel/laravel:^11.0 nama-proyek-anda

# 2. Masuk ke dalam direktori proyek
cd nama-proyek-anda

# 3. Install Livewire v3 (secara bawaan Laravel 11 akan menarik Livewire versi 3)
composer require "livewire/livewire:^3.0" -W

# 4. Install Tailwind CSS v3 beserta peer dependencies-nya melalui npm
npm install -D tailwindcss@v3-lts postcss autoprefixer

# 5. Inisialisasi file konfigurasi Tailwind CSS
npx tailwindcss init -p

```

> **Catatan untuk Alpine.js 3:** Anda tidak perlu menginstal Alpine.js secara terpisah via `npm`. **Livewire 3 sudah menyertakan Alpine.js 3 secara otomatis** di dalamnya. Begitu Livewire aktif, Alpine.js langsung siap digunakan.

---

## 2. Langkah Konfigurasi Tambahan

### A. Konfigurasi Tailwind CSS

Buka file `tailwind.config.js` yang baru terbentuk, lalu sesuaikan bagian `content` agar Tailwind dapat memindai file Laravel & Livewire Anda:

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

```

### B. Load Asset di CSS Utama

Buka file `resources/css/app.css` dan tambahkan direktif Tailwind berikut di bagian paling atas:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

```

---

## 3. Cara Verifikasi Lingkungan & Dependensi

Setelah semua perintah di atas dijalankan, Anda harus memastikan bahwa semua versi *stack* yang terpasang sudah sesuai dengan requirements.

### A. Verifikasi Lingkungan Lokal (Sisi Sistem)

Jalankan perintah ini untuk memastikan PHP, Node.js, Composer, dan MySQL Anda sesuai dengan versi yang diminta:

| Komponen | Perintah Verifikasi | Output yang Diharapkan (Sesuai Req) |
| --- | --- | --- |
| **PHP** | `php -v` | `PHP 8.4.15 ...` |
| **Node.js** | `node -v` | `v24.10.0` |
| **Composer** | `composer -v` | `Composer version 2.8.12 ...` |
| **MySQL** | `mysql --version` | Menampilkan versi MySQL bawaan XAMPP Anda |

### B. Verifikasi Framework & Library (Sisi Proyek)

Untuk memastikan Laravel dan Livewire terinstall dengan benar di dalam proyek, jalankan perintah ini di dalam folder proyek:

```bash
# Verifikasi Versi Laravel & Livewire
php artisan about

```

* **Hasil yang dicari:** Di bagian output, cari baris `Laravel Version ............. 11.x.x` dan di bagian komponen pastikan `Livewire` terdeteksi dengan versi `3.x.x`.

```bash
# Verifikasi Versi Tailwind CSS
npm list tailwindcss

```

* **Hasil yang dicari:** Menampilkan `tailwindcss@3.x.x` (Memastikan Tailwind versi 3 yang terpasang, bukan versi 4).

---

## 4. Verifikasi Akhir (Uji Coba Tampilan)

Untuk memastikan semuanya (Laravel, Livewire, Tailwind, dan Alpine) bekerja harmonis, lakukan tes sederhana ini:

1. Jalankan server lokal Laravel: `php artisan serve`
2. Jalankan compiler aset (Vite): `npm run dev`
3. Buat satu file Blade komponen (misalnya `resources/views/welcome.blade.php`), lalu isi dengan struktur dasar HTML yang memuat `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
4. Masukkan kode uji coba berikut di dalam `<body>`:

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uji Coba Stack Proyek</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
</head>
<body class="bg-slate-100 font-sans antialiased">

    <div class="max-w-4xl mx-auto my-12 px-4">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-slate-800 tracking-tight">
                Status Integrasi Stack Proyek
            </h1>
            <p class="text-slate-600 mt-2">Jika semua komponen di bawah berfungsi, lingkungan pengembangan Anda telah siap!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-3 h-3 rounded-full bg-cyan-500 animate-pulse"></div>
                    <h2 class="text-lg font-bold text-slate-700">1. Tailwind CSS 3</h2>
                </div>
                <p class="text-sm text-slate-600 mb-4">
                    Jika Anda melihat kartu ini memiliki sudut melengkung (*rounded-2xl*), bayangan halus (*shadow-sm*), dan tombol di bawah berwarna biru cerah, maka Tailwind CSS berfungsi.
                </p>
                <button class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-2 px-4 rounded-xl transition duration-200">
                    Tailwind Aktif
                </button>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                    <h2 class="text-lg font-bold text-slate-700">2. Alpine.js 3</h2>
                </div>
                <p class="text-sm text-slate-600 mb-4">
                    Klik tombol di bawah ini. Jika sebuah kotak teks tambahan muncul secara interaktif tanpa *reload* halaman, maka Alpine.js berjalan dengan baik.
                </p>
                
                <div x-data="{ terbuka: false }">
                    <button @click="terbuka = !terbuka" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-xl transition duration-200">
                        <span x-text="terbuka ? 'Sembunyikan Tes' : 'Jalankan Tes Alpine'"></span>
                    </button>
                    
                    <div x-show="terbuka" x-transition class="mt-3 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-xl font-medium">
                        🎉 Hebat! Alpine.js 3 berhasil merespon instruksi klik Anda!
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-6 bg-white p-6 rounded-2xl shadow-sm border border-slate-200 text-center">
            <div class="flex justify-center items-center space-x-3 mb-3">
                <div class="w-3 h-3 rounded-full bg-indigo-500 animate-pulse"></div>
                <h2 class="text-lg font-bold text-slate-700">3. Livewire 3 & Laravel 11</h2>
            </div>
            <p class="text-sm text-slate-600 max-w-xl mx-auto mb-4">
                Livewire 3 telah menyatu secara otomatis dalam ekosistem Laravel 11. Script pendukungnya dimuat langsung melalui instruksi pemanggilan di file template ini.
            </p>
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                Sistem Terkoneksi: Laravel v{{ app()->version() }}
            </span>
        </div>

    </div>

    @livewireScripts
</body>
</html>

```

Buka `http://127.0.0.1:8000` di browser. Jika kotaknya berwarna ungu (Tailwind jalan) dan tombolnya bisa diklik untuk memunculkan teks (Alpine jalan), maka seluruh *requirements* proyek Anda telah terpenuhi dan terverifikasi 100%.

✅ Akun Admin berhasil dibuat/diperbarui!
📧 Email: admin@sekolah.sch.id
🔑 Password: password123


Jika kamu ingin mereset database dari nol dan mengisi ulang sekaligus, kamu bisa menggunakan perintah php artisan migrate:fresh --seed. Perintah ini akan menghapus semua tabel, membuat ulang, lalu menjalankan seeder. Sangat berguna saat pengembangan!)


Jelaskan error pada logika PHP Liveware 3 berikut:
app\Livewire\ManageGrades.php

Property $grades has no type information available.
public $grades;

Property $gradeId has no type information available.
public $gradeId;

Parameter $id has no type information available.
public function delete($id)

Solusi:
public array $grades;
public int $gradeId;
public function delete(int $id)



Problem:
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // <-- 2. TAMBAHKAN RUTE INI DI SINI
    Route::get('/grades', ManageGrades::class)->name('grades.manage');
});

Symfony \ Component \ Routing \ Exception \ RouteNotFoundException
Route [profile] not defined.
C:\xampp\htdocs\simaw\resources\views\livewire\layout\navigation.blade.php : 44
<div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

Saya menggunakan pendekatan
<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\ManageGrades;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/grades', ManageGrades::class)->name('grades.manage');


require __DIR__.'/auth.php';

/grades bisa diakses tetapi menu tambah kelas, edit tidak bisa diakses, menu hapus bisa tetapi diklik cancel data tetap terhapus

Solusi, pastikan kode sesuai dengan keonvensi Breeze Liveware:
<?php

use App\Livewire\ManageGrades; // Import komponen Livewire kita
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Grup rute yang HANYA bisa diakses jika sudah login
Route::middleware('auth')->group(function () {
    // Rute Kustom Kita untuk Panel Guru
    Route::get('/grades', ManageGrades::class)->name('grades.manage');
});

require __DIR__.'/auth.php';


Solusi untuk tombol edit, hapus, tambah
🛠️ Solusi Komprehensif
Langkah 1: Buat Layout Custom untuk Panel Guru
Langkah 2: Update Komponen Livewire untuk Menggunakan Layout Baru
// GANTI INI:
// #[Layout('layouts.app')]

// MENJADI INI:
#[Layout('layouts.panel')]

Langkah 3: Perbaikan Blade View dengan $wire.entangle()
Buka resources/views/livewire/manage-grades.blade.php dan ganti seluruh isinya


Solusi untuk background
perbaikan pada: resources/views/livewire/grade-manager.blade.php

Menghapus seluruh tag <style>...</style> dari komponen Livewire.
Mengganti animate-morph-bg menjadi morph-bg.
Menggunakan @entangle('isModalOpen') yang lebih stabil pada kombinasi Livewire + Alpine.
Tidak lagi bergantung pada CSS yang berada di dalam DOM Livewire.

Pindahkan animasi ke resources/css/app.css


tapi saya mendapati warning berikut, tolong koreksi:
app\Livewire\ManageQuestions.php
public $image = null; // Instance UploadedFile
Property $image has no type information available.

Solusi:
use Illuminate\Http\UploadedFile; //import ini
public ?UploadedFile $image = null; // Instance UploadedFile


app\Livewire\ManageQuestions.php
$this->questions = Question::with('meeting')->orderBy('id', 'desc')->get();
error:
Call to undefined relationship [meeting] on model [App\Models\Question].

Analisa:
model Question tidak memiliki hubungan langsung dengan Meeting
Solusi:
Question::with('quiz.meeting'). Halaman /questions bisa diakses tetapi tidak bisa menambah pertanyaan dengan keterangan error:

SQLSTATE[HY000]: General error: 1364 Field 'quiz_id' doesn't have a default value
app\Livewire\ManageQuestions.php : 121


Error di Laravel 11, liveware 3

Undefined variable $progressPercentage
view:
<span class="text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded-full">

                    {{ round($progressPercentage) }}% Selesai

                </span>


class:
    // Helper untuk menghitung progress bar (0 - 100)
    public function getProgressPercentageProperty(): float
    {
        return (($this->currentIndex + 1) / $this->questions->count()) * 100;
    }

Solusi:
file perubahan terakhir di class dan view.

    #[Computed]
    public function progressPercentage(): float
    {
        // Pastikan count() tidak 0 untuk menghindari error division by zero
        if ($this->questions->count() === 0) {
            return 0;
        }

        return (($this->currentIndex + 1) / $this->questions->count()) * 100;
    }

view:
{{ round($this->progressPercentage) }}% Selesai

error Livewire only supports one HTML element per component. Multiple root elements detected for component

2 root dalam 1 html
<div class="min-h-screen morph-bg p-4 pb-24">...</div>
dan
<style>...</style> di bagian paling bawah.

Solusi:
Bungkus tag <style> tersebut agar masuk ke dalam <div> utama (elemen root pertama).