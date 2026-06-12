<div class="min-h-screen morph-bg p-4 flex items-center justify-center">
    
    <div class="glass-card rounded-3xl shadow-2xl w-full max-w-lg p-8">
        
        <!-- Header Info Kuis -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-3xl mb-4 shadow-sm">
                📝
            </div>
            <h1 class="text-2xl font-bold text-purple-800 mb-2">
                {{ $quiz->title }}
            </h1>
            
            <!-- Badge Info Hierarki -->
            <div class="flex flex-wrap justify-center gap-2 mt-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                    🏫 {{ $quiz->meeting->topic->subject->grade->name ?? 'Kelas' }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                    📚 {{ $quiz->meeting->topic->subject->name ?? 'Mapel' }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                    📅 {{ $quiz->meeting->title ?? 'Pertemuan' }}
                </span>
            </div>
        </div>

        <!-- Pesan Error (Jika sudah mengerjakan) -->
        @if ($errorMessage)
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm" role="alert">
                <div class="flex items-start">
                    <span class="text-xl mr-3">⚠️</span>
                    <div>
                        <p class="font-bold">Oops!</p>
                        <p class="text-sm">{{ $errorMessage }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Input Data Siswa -->
        <form wire:submit.prevent="startQuiz" class="space-y-5">
            
            <!-- Input Nama -->
            <div>
                <label for="student_name" class="block text-sm font-bold text-gray-700 mb-2">
                    Nama Lengkap
                </label>
                <input 
                    type="text" 
                    id="student_name" 
                    wire:model.live="student_name" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition text-lg"
                    placeholder="Contoh: Budi Santoso"
                    autocomplete="off"
                >
                @error('student_name')
                    <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Input Nomor Absen -->
            <div>
                <label for="absence_number" class="block text-sm font-bold text-gray-700 mb-2">
                    Nomor Absen
                </label>
                <input 
                    type="number" 
                    id="absence_number" 
                    wire:model.live="absence_number" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition text-lg"
                    placeholder="Contoh: 15"
                    min="1"
                >
                @error('absence_number')
                    <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Tombol Mulai -->
            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 rounded-xl shadow-lg transform transition hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 text-lg mt-6"
            >
                <span wire:loading.remove wire:target="startQuiz">
                    Mulai Mengerjakan 🚀
                </span>
                <span wire:loading wire:target="startQuiz" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memeriksa data...
                </span>
            </button>

        </form>

        <!-- Footer Note -->
        <p class="text-center text-xs text-gray-500 mt-6">
            Pastikan nama dan nomor absen sudah benar. <br>
            Data tidak dapat diubah setelah kuis dimulai.
        </p>

    </div>
</div>