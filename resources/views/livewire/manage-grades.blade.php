<div>
    <div class="min-h-screen morph-bg p-6">

        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-white drop-shadow">
                        🏫 Manajemen Kelas
                    </h1>
                    <p class="text-white/90 mt-1">
                        Kelola daftar kelas (Grade) untuk Sekolah Dasar.
                    </p>
                </div>

                <button
                    wire:click="openModal"
                    class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-2 px-6 rounded-xl shadow-md transition duration-200 flex items-center gap-2"
                >
                    <span>+</span>
                    <span>Tambah Kelas</span>
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

            <!-- Tabel -->
            {{-- <div class="bg-white rounded-2xl shadow-xl overflow-hidden"> --}}
            <div class="glass-card rounded-2xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-purple-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">
                                No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">
                                Nama Kelas
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-purple-700 uppercase">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($grades as $index => $grade)
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-lg font-semibold text-gray-800">
                                        {{ $grade->name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <button
                                        wire:click="openModal({{ $grade->id }})"
                                        class="text-blue-600 hover:text-blue-800 mr-4 font-semibold"
                                    >
                                        ✏️ Edit
                                    </button>

                                    <button
                                        wire:click="delete({{ $grade->id }})"
                                        wire:confirm="Yakin ingin menghapus kelas ini? Semua data di dalamnya akan ikut terhapus!"
                                        class="text-red-500 hover:text-red-700 font-semibold"
                                    >
                                        🗑️ Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data kelas. Silakan tambah data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
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
                    {{ $gradeId ? 'Edit Kelas' : 'Tambah Kelas Baru' }}
                </h2>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Nama Kelas
                        </label>

                        <input
                            type="text"
                            id="name"
                            wire:model.live="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition"
                            placeholder="Contoh: Kelas 1"
                        >

                        @error('name')
                            <span class="text-red-500 text-xs mt-1 block">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

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
                            <span wire:loading.remove wire:target="save">
                                💾 Simpan
                            </span>

                            <span wire:loading wire:target="save">
                                ⏳ Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>