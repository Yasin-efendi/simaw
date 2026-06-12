<?php

namespace App\Livewire;

use App\Models\AttemptAnswer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\StudentAttempt;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('layouts.quiz')]
class QuizTake extends Component
{
    public Quiz $quiz;
    public Collection $questions;
    
    public int $currentIndex = 0;
    public array $answers = []; // Format: [question_id => 'A']
    
    public string $studentName = '';
    public int $absenceNumber = 0;

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz->load('questions');
        $this->questions = $this->quiz->questions;
        
        // Ambil data siswa dari session
        $sessionName = session("quiz_{$this->quiz->id}_student_name");
        $sessionAbsence = session("quiz_{$this->quiz->id}_absence_number");
        
        // Jika tidak ada di session, lempar kembali ke halaman entry
        if (!$sessionName || !$sessionAbsence) {
            $this->redirect(route('quiz.entry', $this->quiz->id));
            return;
        }
        
        $this->studentName = $sessionName;
        $this->absenceNumber = $sessionAbsence;
    }

    // Metode untuk memilih jawaban
    public function selectAnswer(int $questionId, string $option): void
    {
        $this->answers[$questionId] = $option;
    }

    // Pindah ke soal berikutnya
    public function nextQuestion(): void
    {
        if ($this->currentIndex < ($this->questions->count() - 1)) {
            $this->currentIndex++;
        }
    }

    // Kembali ke soal sebelumnya
    public function prevQuestion(): void
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }
    }

    // Selesaikan kuis dan simpan ke database
    public function finishQuiz(): void
    {
        // Validasi: Pastikan semua soal sudah dijawab (Opsional, tapi disarankan)
        $totalQuestions = $this->questions->count();
        $answeredCount = count($this->answers);
        
        if ($answeredCount < $totalQuestions) {
            $this->dispatch('alert', message: "Kamu belum menjawab semua soal! Yakin ingin menyelesaikan?");
            // Catatan: Di implementasi nyata, kita bisa pakai SweetAlert2 di sini. 
            // Untuk sekarang, kita biarkan saja lanjut, atau tambahkan konfirmasi browser.
        }

        $correctCount = 0;
        $attemptId = null; // Deklarasikan di luar agar bisa diakses setelah transaksi

        // Gunakan DB Transaction untuk keamanan data (Atomik)
        DB::transaction(function () use (&$correctCount, &$attemptId) {
            
            // 1. Hitung skor terlebih dahulu
            foreach ($this->questions as $question) {
                $selected = $this->answers[$question->id] ?? null;
                if ($selected === $question->correct_answer) {
                    $correctCount++;
                }
            }
            
            $score = round(($correctCount / $this->questions->count()) * 100);

            // 2. Simpan riwayat pengerjaan (StudentAttempt)
            $attempt = StudentAttempt::create([
                'quiz_id' => $this->quiz->id,
                'student_name' => $this->studentName,
                'absence_number' => $this->absenceNumber,
                'score' => $score,
            ]);
            
            // Simpan ID-nya ke variabel referensi agar bisa dipakai di luar
            $attemptId = $attempt->id;

            // 3. Simpan detail jawaban per soal (AttemptAnswer)
            foreach ($this->questions as $question) {
                $selected = $this->answers[$question->id] ?? null;
                $isCorrect = ($selected === $question->correct_answer);
                
                AttemptAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'selected_answer' => $selected,
                    'is_correct' => $isCorrect,
                ]);
            }
        });

        // 4. Hapus session agar siswa tidak bisa refresh dan mengerjakan ulang
        session()->forget("quiz_{$this->quiz->id}_student_name");
        session()->forget("quiz_{$this->quiz->id}_absence_number");

        // 5. Redirect ke halaman hasil (Langkah 10)
        $this->redirect(route('quiz.result', ['attempt' => $attemptId]));
    }

    // Helper untuk mendapatkan objek soal saat ini
    #[Computed]
    public function currentQuestion(): Question
    {
        return $this->questions[$this->currentIndex];
    }

    // Helper untuk menghitung progress bar (0 - 100)
    #[Computed]
    public function progressPercentage(): float
    {
        // Pastikan count() tidak 0 untuk menghindari error division by zero
        if ($this->questions->count() === 0) {
            return 0;
        }

        return (($this->currentIndex + 1) / $this->questions->count()) * 100;
    }

    public function render()
    {
        return view('livewire.quiz-take');
    }
}