<?php

namespace App\Livewire\Admin;

use App\Models\Agenda;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Agenda')]
class AgendaCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $editingId = null;
    public string $search = '';

    #[Rule('required|max:255')]
    public string $acara = '';

    #[Rule('nullable|max:255')]
    public string $penyelenggara = '';

    #[Rule('nullable')]
    public ?string $jam = null;

    #[Rule('nullable|date')]
    public ?string $tanggal = null;

    #[Rule('nullable|max:255')]
    public string $tempat = '';

    #[Rule('nullable')]
    public string $keterangan = '';

    public function render()
    {
        $agendas = Agenda::query()
            ->when($this->search, function ($query) {
                $query->where('acara', 'like', "%{$this->search}%")
                    ->orWhere('penyelenggara', 'like', "%{$this->search}%")
                    ->orWhere('tempat', 'like', "%{$this->search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);

        return view('livewire.admin.agenda-crud', [
            'agendas' => $agendas,
        ]);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['acara', 'penyelenggara', 'jam', 'tanggal', 'tempat', 'keterangan', 'isEditing', 'editingId']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);

        $this->editingId = $agenda->id;
        $this->isEditing = true;
        $this->acara = $agenda->acara ?? '';
        $this->penyelenggara = $agenda->penyelenggara ?? '';
        $this->jam = $agenda->jam ? $agenda->jam->format('H:i') : null;
        $this->tanggal = $agenda->tanggal ? $agenda->tanggal->format('Y-m-d') : null;
        $this->tempat = $agenda->tempat ?? '';
        $this->keterangan = $agenda->keterangan ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'acara' => $this->acara,
            'penyelenggara' => $this->penyelenggara ?: null,
            'jam' => $this->jam ?: null,
            'tanggal' => $this->tanggal ?: null,
            'tempat' => $this->tempat ?: null,
            'keterangan' => $this->keterangan ?: null,
        ];

        if ($this->isEditing) {
            $agenda = Agenda::findOrFail($this->editingId);
            $agenda->update($data);
            session()->flash('message', 'Agenda berhasil diperbarui!');
        } else {
            Agenda::create($data);
            session()->flash('message', 'Agenda berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        session()->flash('message', 'Agenda berhasil dihapus!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
