<div>
    <div class="min-h-screen morph-bg p-6">
        <div class="max-w-5xl mx-auto">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white drop-shadow-md">
                        🏆 Leaderboard Kuis
                    </h1>
                    <p class="text-white/90 mt-1">
                        {{ $quiz->meeting->topic->subject->grade->name }} • {{ $quiz->meeting->topic->subject->name }} • {{ $quiz->title }}
                    </p>
                </div>

                <button
                    wire:click="exportPdf"
                    class="bg-white text-red-600 hover:bg-red-50 font-semibold py-2 px-6 rounded-xl shadow-md transition duration-200 flex items-center gap-2"
                >
                    <span>📄</span>
                    <span>Export PDF</span>
                </button>
            </div>

            <!-- Statistik Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="glass-card rounded-2xl p-4 text-center">
                    <p class="text-sm text-gray-600 font-semibold">Total Peserta</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $attempts->count() }}</p>
                </div>
                <div class="glass-card rounded-2xl p-4 text-center">
                    <p class="text-sm text-gray-600 font-semibold">Rata-rata Kelas</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $attempts->avg('score') ? round($attempts->avg('score'), 1) : 0 }}</p>
                </div>
                <div class="glass-card rounded-2xl p-4 text-center">
                    <p class="text-sm text-gray-600 font-semibold">Nilai Tertinggi</p>
                    <p class="text-3xl font-bold text-green-600">{{ $attempts->max('score') ?? 0 }}</p>
                </div>
            </div>

            <!-- Tabel Leaderboard -->
            <div class="glass-card rounded-2xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-purple-50/80">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Peringkat</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">No. Absen</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Nilai</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-purple-700 uppercase">Waktu Mengerjakan</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white/50 divide-y divide-gray-100">
                        @forelse ($attempts as $index => $attempt)
                            <tr class="hover:bg-blue-50/80 transition duration-150">
                                <td class="px-6 py-4">
                                    @if($index === 0)
                                        <span class="text-2xl">🥇</span>
                                    @elseif($index === 1)
                                        <span class="text-2xl">🥈</span>
                                    @elseif($index === 2)
                                        <span class="text-2xl">🥉</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-500">#{{ $index + 1 }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-base font-semibold text-gray-800">
                                        {{ $attempt->student_name }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $attempt->absence_number }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $scoreColor = $attempt->score >= 80 ? 'bg-green-100 text-green-800' : ($attempt->score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $scoreColor }}">
                                        {{ $attempt->score }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $attempt->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada siswa yang mengerjakan kuis ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk menangani download PDF dari Livewire Dispatch -->
@script
<script>
    $wire.on('download-pdf', (event) => {
        const link = document.createElement('a');
        link.href = 'data:application/pdf;base64,' + event.base64;
        link.download = event.fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
</script>
@endscript