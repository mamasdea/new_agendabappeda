<div>
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="alert alert-custom alert-success-custom mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ \App\Models\Agenda::count() }}</div>
                        <div class="stats-label">Total Agenda</div>
                    </div>
                    <div class="stats-icon stats-icon-primary">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ \App\Models\Agenda::whereDate('tanggal', today())->count() }}</div>
                        <div class="stats-label">Agenda Hari Ini</div>
                    </div>
                    <div class="stats-icon stats-icon-success">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ \App\Models\Agenda::whereDate('tanggal', '>=', today())->count() }}</div>
                        <div class="stats-label">Agenda Mendatang</div>
                    </div>
                    <div class="stats-icon stats-icon-primary">
                        <i class="bi bi-calendar-plus"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card card-custom">
        <div class="card-header-custom d-flex align-items-center justify-content-between">
            <h5><i class="bi bi-calendar-event me-2"></i>Daftar Agenda</h5>
            <button wire:click="openModal" class="btn btn-light btn-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Agenda
            </button>
        </div>
        <div class="card-body p-4">
            {{-- Search & Actions --}}
            <div class="row mb-4">
                <div class="col-md-6 mb-2 mb-md-0">
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            class="form-control search-input" 
                            placeholder="Cari acara, penyelenggara, atau tempat..."
                        >
                    </div>
                </div>
                <div class="col-md-6 d-flex gap-2 justify-content-md-end">
                    <a href="{{ route('admin.laporan', ['filter' => 'hari_ini']) }}" target="_blank" class="btn btn-outline-primary d-flex align-items-center gap-2">
                        <i class="bi bi-printer"></i>
                        <span>Cetak Hari Ini</span>
                    </a>
                    <a href="{{ route('admin.laporan', ['filter' => 'besok']) }}" target="_blank" class="btn btn-outline-success d-flex align-items-center gap-2">
                        <i class="bi bi-printer"></i>
                        <span>Cetak Besok</span>
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th style="width: 50px">No</th>
                            <th>Acara</th>
                            <th>Penyelenggara</th>
                            <th style="width: 120px">Tanggal</th>
                            <th style="width: 80px">Jam</th>
                            <th>Tempat</th>
                            <th style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($agendas as $index => $agenda)
                            <tr wire:key="agenda-{{ $agenda->id }}">
                                <td class="text-muted">{{ $agendas->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $agenda->acara }}</strong>
                                    @if($agenda->keterangan)
                                        <br><small class="text-muted">{{ Str::limit($agenda->keterangan, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $agenda->penyelenggara ?? '-' }}</td>
                                <td>
                                    @if($agenda->tanggal)
                                        <span class="badge badge-custom bg-primary bg-opacity-10 text-primary">
                                            {{ $agenda->tanggal->format('d M Y') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($agenda->jam)
                                        <span class="badge badge-custom bg-success bg-opacity-10 text-success">
                                            {{ \Carbon\Carbon::parse($agenda->jam)->format('H:i') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $agenda->tempat ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button wire:click="edit({{ $agenda->id }})" class="btn btn-action btn-action-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button 
                                            wire:click="confirmDelete({{ $agenda->id }})" 
                                            wire:confirm="Apakah Anda yakin ingin menghapus agenda ini?"
                                            class="btn btn-action btn-action-delete" 
                                            title="Hapus"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada data agenda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Menampilkan {{ $agendas->firstItem() ?? 0 }} - {{ $agendas->lastItem() ?? 0 }} dari {{ $agendas->total() }} data
                </div>
                {{ $agendas->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-{{ $isEditing ? 'pencil-square' : 'plus-circle' }} me-2"></i>
                        {{ $isEditing ? 'Edit Agenda' : 'Tambah Agenda Baru' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nama Acara <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    wire:model="acara" 
                                    class="form-control form-control-custom @error('acara') is-invalid @enderror"
                                    placeholder="Masukkan nama acara"
                                >
                                @error('acara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Penyelenggara</label>
                                <input 
                                    type="text" 
                                    wire:model="penyelenggara" 
                                    class="form-control form-control-custom @error('penyelenggara') is-invalid @enderror"
                                    placeholder="Masukkan penyelenggara"
                                >
                                @error('penyelenggara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Tempat</label>
                                <input 
                                    type="text" 
                                    wire:model="tempat" 
                                    class="form-control form-control-custom @error('tempat') is-invalid @enderror"
                                    placeholder="Masukkan tempat"
                                >
                                @error('tempat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input 
                                    type="date" 
                                    wire:model="tanggal" 
                                    class="form-control form-control-custom @error('tanggal') is-invalid @enderror"
                                >
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Jam</label>
                                <input 
                                    type="time" 
                                    wire:model="jam" 
                                    class="form-control form-control-custom @error('jam') is-invalid @enderror"
                                >
                                @error('jam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea 
                                    wire:model="keterangan" 
                                    class="form-control form-control-custom @error('keterangan') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Masukkan keterangan tambahan..."
                                ></textarea>
                                @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeModal" class="btn btn-secondary">
                            <i class="bi bi-x-lg me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary-gradient">
                            <span wire:loading.remove wire:target="save">
                                <i class="bi bi-check-lg me-1"></i> {{ $isEditing ? 'Simpan Perubahan' : 'Simpan' }}
                            </span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
