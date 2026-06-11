<?php

namespace App\Livewire;

use App\Models\Grade;
use Illuminate\Support\Collection; // <-- Import Collection
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.panel')]
class ManageGrades extends Component
{
    // Tipe data Collection lebih tepat untuk hasil query Eloquent
    public Collection $grades;
    
    // Harus nullable (?int) karena bisa bernilai null saat mode "Tambah"
    public ?int $gradeId = null;
    
    #[Rule('required|string|max:255')]
    public string $name = ''; // <-- Bonus: Tambahkan strict type string
    
    public bool $isModalOpen = false; // <-- Bonus: Tambahkan strict type bool

    public function mount(): void
    {
        $this->loadGrades();
    }

    public function loadGrades(): void
    {
        $this->grades = Grade::orderBy('name', 'asc')->get();
    }

    // Parameter $id juga harus nullable agar sesuai dengan properti $gradeId
    public function openModal(?int $id = null): void
    {
        $this->resetValidation();
        $this->gradeId = $id;
        
        if ($id) {
            $grade = Grade::findOrFail($id);
            $this->name = $grade->name;
        } else {
            $this->name = '';
        }
        
        $this->isModalOpen = true;
    }

    public function save(): void
    {
        $this->validate();

        Grade::updateOrCreate(
            ['id' => $this->gradeId],
            ['name' => $this->name]
        );

        $this->isModalOpen = false;
        $this->reset(['gradeId', 'name']);
        $this->loadGrades();
        
        session()->flash('message', 'Data Kelas berhasil disimpan! 🎉');
    }

    public function delete(int $id): void
    {
        Grade::findOrFail($id)->delete();
        $this->loadGrades();
        session()->flash('message', 'Data Kelas berhasil dihapus! 🗑️');
    }

    public function render()
    {
        return view('livewire.manage-grades');
    }
}