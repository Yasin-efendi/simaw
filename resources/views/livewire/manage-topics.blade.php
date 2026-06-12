<div>
    <div class="min-h-screen morph-bg p-6">
        <div class="max-w-5xl mx-auto">
            
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white drop-shadow-md">
                        📖 Manajemen Bab Materi
                    </h1>
                    <p class="text-white/90 mt-1">
                        Kelola bab atau topik materi untuk setiap mata pelajaran.
                    </p>
                </div>

                <button
                    wire:click="openModal"
                    class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-2 px-6 rounded-xl shadow-md transition duration-200 flex items-center gap-2"
                >
                    <span>+</span>
                    <span>Tambah Bab</span>
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
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Judul Bab / Topik</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-purple-700 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white/50 divide-y divide-gray-100">
                        @forelse ($topics as $index => $topic)
                            <tr class="hover:bg-blue-50/80 transition duration-150">
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-lg font-semibold text-gray-800">
                                        {{ $topic->title }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ $topic->subject->name ?? '-' }} ({{ $topic->subject->grade->name ?? '-' }})
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <button
                                        wire:click="openModal({{ $topic->id }})"
                                        class="text-blue-600 hover:text-blue-800 mr-4 font-semibold"
                                    >
                                        ✏️ Edit
                                    </button>

                                    <button
                                        wire:click="delete({{ $topic->id }})"
                                        wire:confirm="Yakin ingin menghapus bab ini? Semua pertemuan dan soal di dalamnya akan ikut terhapus!"
                                        class="text-red-500 hover:text-red-700 font-semibold"
                                    >
                                        🗑️ Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data bab materi. Silakan tambah data baru.
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
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
            style="display: none;"
        >
            <div
                class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 m-4"
                @click.outside="isModalOpen = false"
            >
                <h2 class="text-2xl font-bold text-purple-700 mb-4">
                    {{ $topicId ? 'Edit Bab Materi' : 'Tambah Bab Materi Baru' }}
                </h2>

                <form wire:submit.prevent="save">
                    
                    <!-- DROPDOWN MATA PELAJARAN (Dengan Info Kelas) -->
                    <div class="mb-4">
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Pilih Mata Pelajaran
                        </label>
                        <select 
                            id="subject_id" 
                            wire:model.live="subject_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition bg-white"
                        >
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->name }} ({{ $subject->grade->name }})
                                </option>
                            @endforeach
                        </select>
                        
                        @error('subject_id')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- INPUT JUDUL BAB -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Bab / Topik
                        </label>
                        <input
                            type="text"
                            id="title"
                            wire:model.live="title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                            placeholder="Contoh: Penjumlahan dan Pengurangan"
                        >

                        @error('title')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
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