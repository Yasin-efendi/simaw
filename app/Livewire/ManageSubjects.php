<?php

namespace App\Livewire;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.panel')] // Menggunakan layout custom yang sudah kita buat
class ManageSubjects extends Component
{
    public Collection $subjects;
    public Collection $grades; // Data untuk dropdown
    
    public ?int $subjectId = null;
    #[Rule('required|exists:grades,id')]
    public ?int $grade_id = null; // Foreign key yang akan dipilih di dropdown
    
    #[Rule('required|string|max:255')]
    public string $name = '';
    
    public bool $isModalOpen = false;

    public function mount(): void
    {
        $this->loadData();
    }

    // Memuat subjects DAN grades sekaligus
    public function loadData(): void
    {
        $this->subjects = Subject::with('grade')->orderBy('name', 'asc')->get();
        $this->grades = Grade::orderBy('name', 'asc')->get();
    }

    public function openModal(?int $id = null): void
    {
        $this->resetValidation();
        $this->subjectId = $id;
        
        if ($id) {
            // Mode Edit
            $subject = Subject::findOrFail($id);
            $this->grade_id = $subject->grade_id;
            $this->name = $subject->name;
        } else {
            // Mode Tambah
            $this->grade_id = null;
            $this->name = '';
        }
        
        $this->isModalOpen = true;
    }

    public function save(): void
    {
        $this->validate();

        Subject::updateOrCreate(
            ['id' => $this->subjectId],
            [
                'grade_id' => $this->grade_id,
                'name' => $this->name
            ]
        );

        $this->isModalOpen = false;
        $this->reset(['subjectId', 'grade_id', 'name']);
        $this->loadData();
        
        session()->flash('message', 'Data Mata Pelajaran berhasil disimpan! 🎉');
    }

    public function delete(int $id): void
    {
        Subject::findOrFail($id)->delete();
        $this->loadData();
        session()->flash('message', 'Data Mata Pelajaran berhasil dihapus! 🗑️');
    }

    public function render()
    {
        return view('livewire.manage-subjects');
    }
}