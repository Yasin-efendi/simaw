<div class="min-h-screen morph-bg p-4 pb-24">
    <div class="max-w-2xl mx-auto">
        
        <!-- Progress Bar & Info -->
        <div class="mb-6">
            <div class="flex justify-between items-end mb-2">
                <span class="text-sm font-bold text-purple-800">
                    Soal {{ $currentIndex + 1 }} dari {{ $questions->count() }}
                </span>
                <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded-full">
                    {{ round($this->progressPercentage) }}% Selesai
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                <div 
                    class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-500 ease-out" 
                    style="width: {{ $this->progressPercentage }}%"
                ></div>
            </div>
        </div>

        <!-- Kartu Soal (Gunakan wire:key agar animasi Livewire smooth) -->
        <div wire:key="question-{{ $this->currentQuestion->id }}" class="glass-card rounded-3xl shadow-xl p-6 mb-6 animate-fade-in">
            
            <!-- Gambar Soal (Jika Ada) -->
            @if($this->currentQuestion->image_path)
                <div class="mb-4 rounded-2xl overflow-hidden border-2 border-gray-100 shadow-sm">
                    <img 
                        src="{{ asset('storage/' . $this->currentQuestion->image_path) }}" 
                        alt="Gambar Soal" 
                        class="w-full h-auto object-contain max-h-64 bg-gray-50"
                    >
                </div>
            @endif

            <!-- Teks Pertanyaan -->
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 leading-relaxed mb-6">
                {{ $this->currentQuestion->question_text }}
            </h2>

            <!-- Opsi Jawaban -->
            <div class="space-y-3">
                @foreach(['A', 'B', 'C', 'D'] as $option)
                    @php
                        $optionText = 'option_' . strtolower($option);
                        $isSelected = ($answers[$this->currentQuestion->id] ?? null) === $option;
                    @endphp

                    <button 
                        wire:click="selectAnswer({{ $this->currentQuestion->id }}, '{{ $option }}')"
                        class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200 flex items-start gap-4 group
                            {{ $isSelected 
                                ? 'border-blue-500 bg-blue-50 shadow-md' 
                                : 'border-gray-200 bg-white hover:border-blue-300 hover:bg-blue-50/50' 
                            }}"
                    >
                        <!-- Huruf Opsi (A, B, C, D) -->
                        <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full font-bold text-sm
                            {{ $isSelected 
                                ? 'bg-blue-500 text-white' 
                                : 'bg-gray-100 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-600' 
                            }}">
                            {{ $option }}
                        </span>
                        
                        <!-- Teks Opsi -->
                        <span class="text-gray-700 font-medium pt-1 {{ $isSelected ? 'text-blue-800' : '' }}">
                            {{ $this->currentQuestion->$optionText }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Tombol Navigasi (Sticky di bawah) -->
        <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-200 p-4 shadow-lg">
            <div class="max-w-2xl mx-auto flex justify-between gap-4">
                
                <!-- Tombol Sebelumnya -->
                <button 
                    wire:click="prevQuestion" 
                    class="flex-1 py-3 px-4 rounded-xl font-semibold border-2 border-gray-300 text-gray-600 hover:bg-gray-50 transition
                        {{ $currentIndex === 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                    @if($currentIndex === 0) disabled @endif
                >
                    ← Sebelumnya
                </button>

                <!-- Tombol Selanjutnya / Selesai -->
                @if($currentIndex < ($questions->count() - 1))
                    <button 
                        wire:click="nextQuestion" 
                        class="flex-1 py-3 px-4 rounded-xl font-semibold bg-blue-500 text-white hover:bg-blue-600 shadow-md transition transform active:scale-95"
                    >
                        Selanjutnya →
                    </button>
                @else
                    <button 
                        wire:click="finishQuiz" 
                        wire:confirm="Yakin ingin menyelesaikan kuis? Pastikan semua soal sudah dijawab."
                        class="flex-1 py-3 px-4 rounded-xl font-semibold bg-gradient-to-r from-green-500 to-emerald-600 text-white hover:from-green-600 hover:to-emerald-700 shadow-md transition transform active:scale-95 flex items-center justify-center gap-2"
                    >
                        <span wire:loading.remove wire:target="finishQuiz">Selesai & Kumpulkan ✅</span>
                        <span wire:loading wire:target="finishQuiz" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                @endif
            </div>
        </div>

    </div>
    <!-- Tambahkan sedikit CSS untuk animasi fade-in saat ganti soal -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</div>

