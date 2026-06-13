<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Leaderboard - {{ $quiz->title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; color: #4a148c; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #f3e5f5; color: #4a148c; font-weight: bold; padding: 8px; border: 1px solid #ddd; text-align: left; }
        td { padding: 8px; border: 1px solid #ddd; }
        .rank-1 { background-color: #fff9c4; font-weight: bold; }
        .rank-2 { background-color: #f5f5f5; font-weight: bold; }
        .rank-3 { background-color: #ffe0b2; font-weight: bold; }
        .score-high { color: #2e7d32; font-weight: bold; }
        .score-mid { color: #f57f17; font-weight: bold; }
        .score-low { color: #c62828; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN HASIL KUIS</h1>
        <p><strong>{{ $quiz->meeting->topic->subject->grade->name }}</strong> | {{ $quiz->meeting->topic->subject->name }} | {{ $quiz->title }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">Peringkat</th>
                <th width="40%">Nama Siswa</th>
                <th width="15%">No. Absen</th>
                <th width="15%">Nilai</th>
                <th width="20%">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attempts as $index => $attempt)
                @php
                    $rankClass = $index === 0 ? 'rank-1' : ($index === 1 ? 'rank-2' : ($index === 2 ? 'rank-3' : ''));
                    $scoreClass = $attempt->score >= 80 ? 'score-high' : ($attempt->score >= 60 ? 'score-mid' : 'score-low');
                    $medal = $index === 0 ? '🥇 1' : ($index === 1 ? '🥈 2' : ($index === 2 ? '🥉 3' : ($index + 1)));
                @endphp
                <tr class="{{ $rankClass }}">
                    <td align="center">{{ $medal }}</td>
                    <td>{{ $attempt->student_name }}</td>
                    <td align="center">{{ $attempt->absence_number }}</td>
                    <td align="center" class="{{ $scoreClass }}">{{ $attempt->score }}</td>
                    <td align="center">{{ $attempt->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" align="center">Belum ada data siswa yang mengerjakan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak otomatis oleh sistem pada: {{ $generated_at }}</p>
    </div>

</body>
</html>