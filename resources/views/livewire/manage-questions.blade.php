<div>
    <div class="min-h-screen morph-bg p-6">
        <div class="max-w-6xl mx-auto">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white drop-shadow-md">
                        📝 Manajemen Soal
                    </h1>
                    <p class="text-white/90 mt-1">
                        Kelola soal pilihan ganda untuk setiap paket kuis.
                    </p>
                </div>

                <button
                    wire:click="openModal"
                    class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-2 px-6 rounded-xl shadow-md transition duration-200 flex items-center gap-2"
                >
                    <span>+</span>
                    <span>Tambah Soal</span>
                </button>
            </div>

            <!-- Flash Message -->
            @if (session()->has('message'))
                <div
                    class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm"
                    role="alert"
                >
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <!-- Tabel Data -->
            <div class="glass-card rounded-2xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-purple-50/80">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Pertanyaan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Paket Kuis</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Kunci</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Gambar</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-purple-700 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white/50 divide-y divide-gray-100">
                        @forelse ($questions as $index => $question)
                            <tr class="hover:bg-blue-50/80 transition duration-150">
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4 max-w-xs">
                                    <span class="text-sm text-gray-800 line-clamp-2">
                                        {{ $question->question_text }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="inline-flex flex-col">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            {{ ucfirst($question->quiz->type ?? '-') }}
                                        </span>
                                        <span class="text-xs text-gray-600 mt-1">
                                            {{ $question->quiz->meeting->title ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-800 font-bold text-sm">
                                        {{ $question->correct_answer }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if($question->image_path)
                                        <span class="text-green-600 font-semibold">✓ Ada</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <button
                                        wire:click="openModal({{ $question->id }})"
                                        class="text-blue-600 hover:text-blue-800 mr-4 font-semibold"
                                    >
                                        ✏️ Edit
                                    </button>

                                    <button
                                        wire:click="delete({{ $question->id }})"
                                        wire:confirm="Yakin ingin menghapus soal ini?"
                                        class="text-red-500 hover:text-red-700 font-semibold"
                                    >
                                        🗑️ Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data soal. Silakan tambah data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Form -->
        <div
            x-data="{ isModalOpen: @entangle('isModalOpen') }"
            x-show="isModalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm overflow-y-auto"
            style="display: none;"
        >
            <div
                class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 m-4 my-8"
                @click.outside="isModalOpen = false"
            >
                <h2 class="text-2xl font-bold text-purple-700 mb-4">
                    {{ $questionId ? 'Edit Soal' : 'Tambah Soal Baru' }}
                </h2>

                <form wire:submit.prevent="save">
                    
                    <!-- DROPDOWN PAKET KUIS (Ganti dari Meeting) -->
                    <div class="mb-4">
                        <label for="quiz_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Pilih Paket Kuis
                        </label>
                        <select 
                            id="quiz_id" 
                            wire:model.live="quiz_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition bg-white"
                        >
                            <option value="">-- Pilih Paket Kuis --</option>
                            @foreach($quizzes as $quiz)
                                <option value="{{ $quiz->id }}">
                                    [{{ strtoupper($quiz->type) }}] {{ $quiz->meeting->title }} - {{ $quiz->meeting->topic->title }} ({{ $quiz->meeting->topic->subject->name }}, {{ $quiz->meeting->topic->subject->grade->name }})
                                </option>
                            @endforeach
                        </select>
                        
                        @error('quiz_id')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- PERTANYAAN -->
                    <div class="mb-4">
                        <label for="question_text" class="block text-sm font-medium text-gray-700 mb-1">
                            Pertanyaan
                        </label>
                        <textarea
                            id="question_text"
                            wire:model.live="question_text"
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                            placeholder="Tulis pertanyaan di sini..."
                        ></textarea>

                        @error('question_text')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- OPSI JAWABAN (Grid 2x2) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="option_a" class="block text-sm font-medium text-gray-700 mb-1">Opsi A</label>
                            <input
                                type="text"
                                id="option_a"
                                wire:model.live="option_a"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                                placeholder="Jawaban A"
                            >
                            @error('option_a')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="option_b" class="block text-sm font-medium text-gray-700 mb-1">Opsi B</label>
                            <input
                                type="text"
                                id="option_b"
                                wire:model.live="option_b"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                                placeholder="Jawaban B"
                            >
                            @error('option_b')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="option_c" class="block text-sm font-medium text-gray-700 mb-1">Opsi C</label>
                            <input
                                type="text"
                                id="option_c"
                                wire:model.live="option_c"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                                placeholder="Jawaban C"
                            >
                            @error('option_c')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="option_d" class="block text-sm font-medium text-gray-700 mb-1">Opsi D</label>
                            <input
                                type="text"
                                id="option_d"
                                wire:model.live="option_d"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                                placeholder="Jawaban D"
                            >
                            @error('option_d')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- KUNCI JAWABAN (Radio Buttons) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kunci Jawaban
                        </label>
                        <div class="flex gap-4">
                            @foreach(['A', 'B', 'C', 'D'] as $option)
                                <label class="inline-flex items-center cursor-pointer">
                                    <input
                                        type="radio"
                                        wire:model.live="correct_answer"
                                        value="{{ $option }}"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                    >
                                    <span class="ml-2 text-gray-700 font-semibold">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('correct_answer')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- PEMBAHASAN -->
                    <div class="mb-4">
                        <label for="explanation" class="block text-sm font-medium text-gray-700 mb-1">
                            Pembahasan (Opsional)
                        </label>
                        <textarea
                            id="explanation"
                            wire:model.live="explanation"
                            rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                            placeholder="Penjelasan jawaban yang benar..."
                        ></textarea>

                        @error('explanation')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- UPLOAD GAMBAR -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                            Gambar Soal (Opsional, Max 2MB)
                        </label>
                        <input
                            type="file"
                            id="image"
                            wire:model="image"
                            accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition bg-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        >

                        @error('image')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror

                        <!-- Preview Gambar -->
                        <div wire:loading wire:target="image" class="mt-2 text-sm text-blue-600">
                            ⏳ Mengupload gambar...
                        </div>

                        @if ($image)
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 mb-1">Preview gambar baru:</p>
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="max-w-xs rounded-xl border-2 border-blue-200 shadow-sm">
                            </div>
                        @elseif ($existingImagePath)
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 mb-1">Gambar saat ini:</p>
                                <img src="{{ asset('storage/' . $existingImagePath) }}" alt="Current" class="max-w-xs rounded-xl border-2 border-gray-200 shadow-sm">
                            </div>
                        @endif
                    </div>

                    <!-- TOMBOL AKSI -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button
                            type="button"
                            @click="isModalOpen = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-600 shadow-md transition"
                        >
                            <span wire:loading.remove wire:target="save">💾 Simpan</span>
                            <span wire:loading wire:target="save">⏳ Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>