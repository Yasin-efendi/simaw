<?php

namespace App\Livewire;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

#[Layout('layouts.panel')]
class ManageQuestions extends Component
{
    use WithFileUploads;

    public Collection $questions;
    public Collection $quizzes; // Ganti dari $meetings menjadi $quizzes
    
    public ?int $questionId = null;
    
    // Ganti meeting_id menjadi quiz_id
    #[Rule('required|exists:quizzes,id')]
    public ?int $quiz_id = null;
    
    #[Rule('required|string')]
    public string $question_text = '';
    
    #[Rule('required|string')]
    public string $option_a = '';
    
    #[Rule('required|string')]
    public string $option_b = '';
    
    #[Rule('required|string')]
    public string $option_c = '';
    
    #[Rule('required|string')]
    public string $option_d = '';
    
    #[Rule('required|in:A,B,C,D')]
    public string $correct_answer = 'A';
    
    #[Rule('nullable|string')]
    public ?string $explanation = null;
    
    public ?UploadedFile $image = null;
    public ?string $existingImagePath = null;
    
    public bool $isModalOpen = false;

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        // Load questions dengan relasi quiz dan nested meeting untuk ditampilkan di tabel
        $this->questions = Question::with('quiz.meeting.topic.subject.grade')
            ->orderBy('id', 'desc')
            ->get();
        
        // Load quizzes dengan nested eager loading untuk dropdown yang informatif
        $this->quizzes = Quiz::with(['meeting.topic.subject.grade'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function openModal(?int $id = null): void
    {
        $this->resetValidation();
        $this->reset(['image', 'existingImagePath']);
        
        $this->questionId = $id;
        
        if ($id) {
            $question = Question::findOrFail($id);
            $this->quiz_id = $question->quiz_id;
            $this->question_text = $question->question_text;
            $this->option_a = $question->option_a;
            $this->option_b = $question->option_b;
            $this->option_c = $question->option_c;
            $this->option_d = $question->option_d;
            $this->correct_answer = $question->correct_answer;
            $this->explanation = $question->explanation;
            $this->existingImagePath = $question->image_path;
        } else {
            $this->quiz_id = null;
            $this->question_text = '';
            $this->option_a = '';
            $this->option_b = '';
            $this->option_c = '';
            $this->option_d = '';
            $this->correct_answer = 'A';
            $this->explanation = null;
        }
        
        $this->isModalOpen = true;
    }

    public function save(): void
    {
        $this->validate([
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->existingImagePath;

        if ($this->image) {
            if ($this->existingImagePath && Storage::disk('public')->exists($this->existingImagePath)) {
                Storage::disk('public')->delete($this->existingImagePath);
            }
            
            $imagePath = $this->image->store('questions', 'public');
        }

        Question::updateOrCreate(
            ['id' => $this->questionId],
            [
                'quiz_id' => $this->quiz_id, // Ganti dari meeting_id
                'question_text' => $this->question_text,
                'option_a' => $this->option_a,
                'option_b' => $this->option_b,
                'option_c' => $this->option_c,
                'option_d' => $this->option_d,
                'correct_answer' => $this->correct_answer,
                'explanation' => $this->explanation,
                'image_path' => $imagePath,
            ]
        );

        $this->isModalOpen = false;
        $this->reset(['questionId', 'quiz_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'explanation', 'image', 'existingImagePath']);
        $this->loadData();
        
        session()->flash('message', 'Data Soal berhasil disimpan! 🎉');
    }

    public function delete(int $id): void
    {
        $question = Question::findOrFail($id);
        
        if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
            Storage::disk('public')->delete($question->image_path);
        }
        
        $question->delete();
        $this->loadData();
        session()->flash('message', 'Data Soal berhasil dihapus! 🗑️');
    }

    public function render()
    {
        return view('livewire.manage-questions');
    }
}