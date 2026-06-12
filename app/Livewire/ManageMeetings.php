<?php

namespace App\Livewire;

use App\Models\Meeting;
use App\Models\Topic;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.panel')]
class ManageMeetings extends Component
{
    public Collection $meetings;
    public Collection $topics; // Data untuk dropdown topik
    
    public ?int $meetingId = null;
    
    // Validasi eksplisit untuk memastikan ID topik yang dipilih benar-benar ada
    #[Rule('required|exists:topics,id')]
    public ?int $topic_id = null;
    
    #[Rule('required|string|max:255')]
    public string $title = '';
    
    public bool $isModalOpen = false;

    public function mount(): void
    {
        $this->loadData();
    }

    // Eager Loading bertingkat untuk menghindari query N+1 dan menyiapkan data dropdown
    public function loadData(): void
    {
        // Load meetings beserta topic-nya untuk ditampilkan di tabel
        $this->meetings = Meeting::with('topic')->orderBy('title', 'asc')->get();
        
        // Load topics beserta subject dan grade-nya agar dropdown bisa menampilkan konteks lengkap
        $this->topics = Topic::with(['subject.grade'])->orderBy('title', 'asc')->get();
    }

    public function openModal(?int $id = null): void
    {
        $this->resetValidation();
        $this->meetingId = $id;
        
        if ($id) {
            $meeting = Meeting::findOrFail($id);
            $this->topic_id = $meeting->topic_id;
            $this->title = $meeting->title;
        } else {
            $this->topic_id = null;
            $this->title = '';
        }
        
        $this->isModalOpen = true;
    }

    public function save(): void
    {
        $this->validate();

        Meeting::updateOrCreate(
            ['id' => $this->meetingId],
            [
                'topic_id' => $this->topic_id,
                'title' => $this->title
            ]
        );

        $this->isModalOpen = false;
        $this->reset(['meetingId', 'topic_id', 'title']);
        $this->loadData();
        
        session()->flash('message', 'Data Pertemuan berhasil disimpan! 🎉');
    }

    public function delete(int $id): void
    {
        Meeting::findOrFail($id)->delete();
        $this->loadData();
        session()->flash('message', 'Data Pertemuan berhasil dihapus! 🗑️');
    }

    public function render()
    {
        return view('livewire.manage-meetings');
    }
}