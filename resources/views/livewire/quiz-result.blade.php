<div class="min-h-screen morph-bg p-4 pb-24">
    
    <!-- CSS untuk animasi dan efek khusus -->
    <style>
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-scale {
            animation: fadeInScale 0.5s ease-out forwards;
        }
        .animate-slide-up {
            animation: slideUp 0.4s ease-out forwards;
        }
        .option-correct {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #059669;
        }
        .option-incorrect {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-color: #dc2626;
        }
        .option-neutral {
            background: white;
            border-color: #e5e7eb;
            color: #374151;
        }
    </style>

    <div class="max-w-2xl mx-auto">
        
        <!-- Kartu Hasil (Animasi muncul dari tengah) -->
        <div class="glass-card rounded-3xl shadow-2xl p-8 mb-6 animate-fade-in-scale">
            
            <!-- Header Info Siswa -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 text-4xl mb-4 shadow-lg">
                    🎓
                </div>
                <h1 class="text-2xl font-bold text-purple-800 mb-2">
                    {{ $attempt->quiz->title }}
                </h1>
                <div class="flex flex-wrap justify-center gap-2 mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                        🏫 {{ $attempt->quiz->meeting->topic->subject->grade->name }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                        📚 {{ $attempt->quiz->meeting->topic->subject->name }}
                    </span>
                </div>
                <p class="text-gray-600 mt-3">
                    <span class="font-semibold">{{ $attempt->student_name }}</span>
                    <span class="mx-2">•</span>
                    Absen {{ $attempt->absence_number }}
                </p>
            </div>

            <!-- Skor Besar -->
            <div class="text-center my-8">
                <div class="text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-2">
                    {{ $attempt->score }}
                </div>
                <p class="text-gray-600 font-semibold">Nilai Akhir</p>
            </div>

            <!-- Statistik Jawaban -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-green-50 rounded-2xl p-4 text-center border-2 border-green-200">
                    <div class="text-3xl font-bold text-green-600">
                        {{ $answerDetails->where('is_correct', true)->count() }}
                    </div>
                    <p class="text-sm text-green-700 font-semibold mt-1">Benar ✓</p>
                </div>
                <div class="bg-red-50 rounded-2xl p-4 text-center border-2 border-red-200">
                    <div class="text-3xl font-bold text-red-600">
                        {{ $answerDetails->where('is_correct', false)->count() }}
                    </div>
                    <p class="text-sm text-red-700 font-semibold mt-1">Salah ✗</p>
                </div>
            </div>

            <!-- Pesan Motivasi -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-4 text-center border-2 border-blue-200 mb-6">
                <p class="text-gray-700">
                    @if($attempt->score >= 80)
                        🌟 Luar biasa! Pertahankan prestasimu!
                    @elseif($attempt->score >= 60)
                        👍 Bagus! Terus berlatih agar lebih baik lagi.
                    @else
                        💪 Jangan menyerah! Yuk pelajari pembahasannya.
                    @endif
                </p>
            </div>

            <!-- Tombol Lihat Pembahasan -->
            <button 
                @click="$dispatch('open-modal')"
                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-4 rounded-xl shadow-lg transform transition hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2 text-lg"
            >
                📖 Lihat Pembahasan
            </button>

        </div>

        <!-- Tombol Kembali -->
        <div class="text-center animate-slide-up" style="animation-delay: 0.2s; opacity: 0;">
            <a 
                href="{{ route('dashboard') }}" 
                class="inline-block bg-white text-purple-700 font-semibold py-3 px-6 rounded-xl shadow-md hover:bg-gray-50 transition"
            >
                ← Kembali ke Beranda
            </a>
        </div>

    </div>

    <!-- Modal Pembahasan -->
    <div 
        x-data="{ isOpen: false, currentAnswer: 0 }"
        @open-modal.window="isOpen = true; currentAnswer = 0"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm overflow-y-auto"
        style="display: none;"
    >
        <div 
            class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl p-6 m-4 my-8"
            @click.outside="isOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
        >
            
            <!-- Header Modal -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-purple-700">
                    📖 Pembahasan Soal
                </h2>
                <button 
                    @click="isOpen = false"
                    class="text-gray-400 hover:text-gray-600 text-2xl font-bold"
                >
                    ✕
                </button>
            </div>

            <!-- Navigasi Soal -->
            <div class="flex justify-between items-center mb-4">
                <button 
                    @click="currentAnswer = Math.max(0, currentAnswer - 1)"
                    :disabled="currentAnswer === 0"
                    class="px-4 py-2 rounded-xl font-semibold border-2 border-gray-300 text-gray-600 hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    ← Sebelumnya
                </button>
                <span class="text-sm font-bold text-purple-700">
                    Soal <span x-text="currentAnswer + 1"></span> dari {{ $answerDetails->count() }}
                </span>
                <button 
                    @click="currentAnswer = Math.min({{ $answerDetails->count() - 1 }}, currentAnswer + 1)"
                    :disabled="currentAnswer === {{ $answerDetails->count() - 1 }}"
                    class="px-4 py-2 rounded-xl font-semibold border-2 border-gray-300 text-gray-600 hover:bg-gray-50 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Selanjutnya →
                </button>
            </div>

            <!-- Konten Soal (Loop dengan template x-for) -->
            <template x-for="(answer, index) in {{ json_encode($answerDetails) }}" :key="answer.id">
                <div x-show="currentAnswer === index" class="animate-fade-in-scale">
                    
                    <!-- Gambar Soal -->
                    <template x-if="answer.question.image_path">
                        <div class="mb-4 rounded-2xl overflow-hidden border-2 border-gray-100 shadow-sm">
                            <img 
                                :src="`/storage/${answer.question.image_path}`" 
                                alt="Gambar Soal" 
                                class="w-full h-auto object-contain max-h-64 bg-gray-50"
                            >
                        </div>
                    </template>

                    <!-- Teks Pertanyaan -->
                    <h3 class="text-xl font-bold text-gray-800 mb-4" x-text="answer.question.question_text"></h3>

                    <!-- Opsi Jawaban -->
                    <div class="space-y-3 mb-6">
                        <template x-for="option in ['A', 'B', 'C', 'D']" :key="option">
                            <div 
                                class="p-4 rounded-xl border-2 flex items-start gap-4"
                                :class="{
                                    'option-correct': option === answer.question.correct_answer,
                                    'option-incorrect': option === answer.selected_answer && option !== answer.question.correct_answer,
                                    'option-neutral': option !== answer.selected_answer && option !== answer.question.correct_answer
                                }"
                            >
                                <!-- Huruf Opsi -->
                                <span 
                                    class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full font-bold text-sm"
                                    :class="{
                                        'bg-white text-green-600': option === answer.question.correct_answer,
                                        'bg-white text-red-600': option === answer.selected_answer && option !== answer.question.correct_answer,
                                        'bg-gray-100 text-gray-600': option !== answer.selected_answer && option !== answer.question.correct_answer
                                    }"
                                    x-text="option"
                                ></span>
                                
                                <!-- Teks Opsi -->
                                <span 
                                    class="font-medium pt-1"
                                    :class="{
                                        'text-white': option === answer.question.correct_answer || (option === answer.selected_answer && option !== answer.question.correct_answer),
                                        'text-gray-700': option !== answer.selected_answer && option !== answer.question.correct_answer
                                    }"
                                    x-text="answer.question['option_' + option.toLowerCase()]"
                                ></span>

                                <!-- Icon Status -->
                                <template x-if="option === answer.question.correct_answer">
                                    <span class="ml-auto text-2xl">✓</span>
                                </template>
                                <template x-if="option === answer.selected_answer && option !== answer.question.correct_answer">
                                    <span class="ml-auto text-2xl">✗</span>
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Pembahasan -->
                    <template x-if="answer.question.explanation">
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-4">
                            <p class="font-bold text-blue-800 mb-2">💡 Pembahasan:</p>
                            <p class="text-gray-700" x-text="answer.question.explanation"></p>
                        </div>
                    </template>

                    <template x-if="!answer.question.explanation">
                        <div class="bg-gray-50 border-l-4 border-gray-400 rounded-r-xl p-4">
                            <p class="text-gray-600 italic">
                                Tidak ada pembahasan untuk soal ini.
                            </p>
                        </div>
                    </template>

                </div>
            </template>

        </div>
    </div>

</div>