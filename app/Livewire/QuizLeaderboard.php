<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\StudentAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.panel')]
class QuizLeaderboard extends Component
{
    public Quiz $quiz;
    public Collection $attempts;

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz->load('meeting.topic.subject.grade');
        
        // Ambil semua attempt untuk kuis ini, urutkan berdasarkan skor (tertinggi dulu), 
        // lalu berdasarkan nomor absen (terkecil dulu) jika skor sama.
        $this->attempts = StudentAttempt::where('quiz_id', $quiz->id)
            ->orderBy('score', 'desc')
            ->orderBy('absence_number', 'asc')
            ->get();
    }

    // Metode untuk mengekspor ke PDF
    public function exportPdf(): void
    {
        $data = [
            'quiz' => $this->quiz,
            'attempts' => $this->attempts,
            'generated_at' => now()->format('d F Y, H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.leaderboard', $data);
        
        // Nama file: Leaderboard_Matematika_Kelas1.pdf
        $fileName = 'Leaderboard_' . str_replace(' ', '_', $this->quiz->meeting->topic->subject->name) . '.pdf';
        
        // Download file
        $this->dispatch('download-pdf', fileName: $fileName, base64: base64_encode($pdf->output()));
    }

    public function render()
    {
        return view('livewire.quiz-leaderboard');
    }
}