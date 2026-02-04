<?php

namespace App\Livewire\Admin;

use App\Models\RuangRapat;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Kelola Ruang Rapat')]
class RuangRapatCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $editingId = null;
    public string $search = '';

    #[Rule('required|max:255')]
    public string $acara_rr = '';

    #[Rule('nullable|max:255')]
    public string $bidang_rr = '';

    #[Rule('nullable')]
    public ?string $jam_rr = null;

    #[Rule('nullable|date')]
    public ?string $tanggal_rr = null;

    #[Rule('nullable|max:255')]
    public string $tempat_rr = '';

    #[Rule('nullable')]
    public string $ket_rr = '';

    #[Rule('nullable|max:100')]
    public string $hari_tgl_rr = '';

    public string $tipe_bidang = 'Internal';
    public array $opsi_bidang = ['Sekretariat', 'Randalevalitbang', 'Ekonomi', 'Pemsosbud', 'IPW'];
    
    public array $opsi_tempat = [
        'R. Rapat Tan Malaka',
        'R. Rapat Sedyatmo',
        'R. Rapat Widjojo Nitisastro',
        'R. Rapat Emil Salim',
        'R. Rapat Meutia Hatta',
    ];

    public function render()
    {
        $ruangRapats = RuangRapat::query()
            ->when($this->search, function ($query) {
                $query->where('acara_rr', 'like', "%{$this->search}%")
                    ->orWhere('bidang_rr', 'like', "%{$this->search}%")
                    ->orWhere('tempat_rr', 'like', "%{$this->search}%");
            })
            ->orderBy('tanggal_rr', 'desc')
            ->orderBy('jam_rr', 'desc')
            ->paginate(10);

        return view('livewire.admin.ruang-rapat-crud', [
            'ruangRapats' => $ruangRapats,
        ]);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['acara_rr', 'bidang_rr', 'jam_rr', 'tanggal_rr', 'tempat_rr', 'ket_rr', 'hari_tgl_rr', 'isEditing', 'editingId']);
        $this->tipe_bidang = 'Internal'; // Default
        $this->bidang_rr = $this->opsi_bidang[0]; // Default select option
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
    }

    public function updatedTipeBidang($value)
    {
        // Reset nilai bidang saat tipe berubah
        if ($value === 'Internal') {
            $this->bidang_rr = $this->opsi_bidang[0];
        } else {
            $this->bidang_rr = '';
        }
    }

    public function edit($id)
    {
        $ruangRapat = RuangRapat::findOrFail($id);

        $this->editingId = $ruangRapat->id;
        $this->isEditing = true;
        $this->acara_rr = $ruangRapat->acara_rr ?? '';
        $this->bidang_rr = $ruangRapat->bidang_rr ?? '';
        
        // Pengecekan tipe bidang
        if (in_array($this->bidang_rr, $this->opsi_bidang)) {
            $this->tipe_bidang = 'Internal';
        } else {
            $this->tipe_bidang = 'Eksternal';
        }

        $this->jam_rr = $ruangRapat->jam_rr ? $ruangRapat->jam_rr->format('H:i') : null;
        $this->tanggal_rr = $ruangRapat->tanggal_rr ? $ruangRapat->tanggal_rr->format('Y-m-d') : null;
        $this->tempat_rr = $ruangRapat->tempat_rr ?? '';
        $this->ket_rr = $ruangRapat->ket_rr ?? '';
        $this->hari_tgl_rr = $ruangRapat->hari_tgl_rr ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'acara_rr' => $this->acara_rr,
            'bidang_rr' => $this->bidang_rr ?: null,
            'jam_rr' => $this->jam_rr ?: null,
            'tanggal_rr' => $this->tanggal_rr ?: null,
            'tempat_rr' => $this->tempat_rr ?: null,
            'ket_rr' => $this->ket_rr ?: null,
            'hari_tgl_rr' => $this->hari_tgl_rr ?: null,
        ];

        if ($this->isEditing) {
            $ruangRapat = RuangRapat::findOrFail($this->editingId);
            $ruangRapat->update($data);
            session()->flash('message', 'Ruang Rapat berhasil diperbarui!');
        } else {
            RuangRapat::create($data);
            session()->flash('message', 'Ruang Rapat berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $ruangRapat = RuangRapat::findOrFail($id);
        $ruangRapat->delete();
        session()->flash('message', 'Ruang Rapat berhasil dihapus!');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
