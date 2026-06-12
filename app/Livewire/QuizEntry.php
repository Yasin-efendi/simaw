<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\StudentAttempt;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.quiz')]
class QuizEntry extends Component
{
    public Quiz $quiz;
    
    #[Rule('required|string|max:255')]
    public string $student_name = '';
    
    #[Rule('required|integer|min:1')]
    public ?int $absence_number = null;
    
    public ?string $errorMessage = null;

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz->load('meeting.topic.subject.grade');
    }

    public function startQuiz(): void
    {
        $this->validate();
        
        // Cek apakah siswa sudah pernah mengerjakan kuis ini
        $alreadyTaken = StudentAttempt::where('quiz_id', $this->quiz->id)
            ->where('student_name', $this->student_name)
            ->where('absence_number', $this->absence_number)
            ->exists();
        
        if ($alreadyTaken) {
            $this->errorMessage = 'Kamu sudah mengerjakan kuis ini sebelumnya. Setiap siswa hanya boleh mengerjakan 1 kali.';
            return;
        }
        
        // Simpan info siswa di session (aman, tidak terekspos di URL)
        session([
            "quiz_{$this->quiz->id}_student_name" => $this->student_name,
            "quiz_{$this->quiz->id}_absence_number" => $this->absence_number,
        ]);
        
        // Redirect ke halaman pengerjaan kuis (akan kita buat di Langkah 9)
        $this->redirect(route('quiz.take', $this->quiz->id));
    }

    public function render()
    {
        return view('livewire.quiz-entry');
    }
}