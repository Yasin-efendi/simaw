<?php

namespace App\Livewire;

use App\Models\StudentAttempt;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.quiz')]
class QuizResult extends Component
{
    public StudentAttempt $attempt;
    public Collection $answerDetails;
    
    public function mount(StudentAttempt $attempt): void
    {
        // Load relasi yang diperlukan untuk menampilkan hasil
        $this->attempt = $attempt->load([
            'quiz.meeting.topic.subject.grade',
            'attemptAnswers.question'
        ]);
        
        // Ambil detail jawaban untuk ditampilkan di modal pembahasan
        $this->answerDetails = $this->attempt->attemptAnswers->sortBy('question.id')->values();
    }

    public function render()
    {
        return view('livewire.quiz-result');
    }
}