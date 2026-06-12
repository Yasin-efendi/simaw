<?php

namespace App\Livewire;

use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.panel')]
class ManageTopics extends Component
{
    public Collection $topics;
    public Collection $subjects; // Data untuk dropdown mapel
    
    public ?int $topicId = null;
    
    // Validasi eksplisit untuk memastikan ID mapel yang dipilih benar-benar ada
    #[Rule('required|exists:subjects,id')]
    public ?int $subject_id = null;
    
    #[Rule('required|string|max:255')]
    public string $title = '';
    
    public bool $isModalOpen = false;

    public function mount(): void
    {
        $this->loadData();
    }

    // Eager Loading penting untuk menghindari query N+1
    public function loadData(): void
    {
        // Load topics beserta subject-nya untuk ditampilkan di tabel
        $this->topics = Topic::with('subject')->orderBy('title', 'asc')->get();
        
        // Load subjects beserta grade-nya agar dropdown bisa menampilkan "Mapel (Kelas X)"
        $this->subjects = Subject::with('grade')->orderBy('name', 'asc')->get();
    }

    public function openModal(?int $id = null): void
    {
        $this->resetValidation();
        $this->topicId = $id;
        
        if ($id) {
            $topic = Topic::findOrFail($id);
            $this->subject_id = $topic->subject_id;
            $this->title = $topic->title;
        } else {
            $this->subject_id = null;
            $this->title = '';
        }
        
        $this->isModalOpen = true;
    }

    public function save(): void
    {
        $this->validate();

        Topic::updateOrCreate(
            ['id' => $this->topicId],
            [
                'subject_id' => $this->subject_id,
                'title' => $this->title
            ]
        );

        $this->isModalOpen = false;
        $this->reset(['topicId', 'subject_id', 'title']);
        $this->loadData();
        
        session()->flash('message', 'Data Bab Materi berhasil disimpan! 🎉');
    }

    public function delete(int $id): void
    {
        Topic::findOrFail($id)->delete();
        $this->loadData();
        session()->flash('message', 'Data Bab Materi berhasil dihapus! 🗑️');
    }

    public function render()
    {
        return view('livewire.manage-topics');
    }
}