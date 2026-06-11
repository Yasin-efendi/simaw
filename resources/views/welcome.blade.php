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