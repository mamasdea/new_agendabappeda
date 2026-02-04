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
                        <div class="stats-number">{{ \App\Models\RuangRapat::count() }}</div>
                        <div class="stats-label">Total Ruang Rapat</div>
                    </div>
                    <div class="stats-icon stats-icon-primary">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ \App\Models\RuangRapat::whereDate('tanggal_rr', today())->count() }}</div>
                        <div class="stats-label">Rapat Hari Ini</div>
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
                        <div class="stats-number">{{ \App\Models\RuangRapat::whereDate('tanggal_rr', '>=', today())->count() }}</div>
                        <div class="stats-label">Rapat Mendatang</div>
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
            <h5><i class="bi bi-building me-2"></i>Daftar Ruang Rapat</h5>
            <button wire:click="openModal" class="btn btn-light btn-sm px-3">
                <i class="bi bi-plus-lg me-1"></i> Tambah Ruang Rapat
            </button>
        </div>
        <div class="card-body p-4">
            {{-- Search --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            class="form-control search-input" 
                            placeholder="Cari acara, bidang, atau tempat..."
                        >
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th style="width: 50px">No</th>
                            <th>Acara</th>
                            <th>Bidang</th>
                            <th style="width: 120px">Tanggal</th>
                            <th style="width: 80px">Jam</th>
                            <th>Tempat</th>
                            <th style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ruangRapats as $index => $ruangRapat)
                            <tr wire:key="ruangrapat-{{ $ruangRapat->id }}">
                                <td class="text-muted">{{ $ruangRapats->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $ruangRapat->acara_rr }}</strong>
                                    @if($ruangRapat->ket_rr)
                                        <br><small class="text-muted">{{ Str::limit($ruangRapat->ket_rr, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $ruangRapat->bidang_rr ?? '-' }}</td>
                                <td>
                                    @if($ruangRapat->tanggal_rr)
                                        <span class="badge badge-custom bg-primary bg-opacity-10 text-primary">
                                            {{ $ruangRapat->tanggal_rr->format('d M Y') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($ruangRapat->jam_rr)
                                        <span class="badge badge-custom bg-success bg-opacity-10 text-success">
                                            {{ \Carbon\Carbon::parse($ruangRapat->jam_rr)->format('H:i') }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $ruangRapat->tempat_rr ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button wire:click="edit({{ $ruangRapat->id }})" class="btn btn-action btn-action-edit" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button 
                                            wire:click="confirmDelete({{ $ruangRapat->id }})" 
                                            wire:confirm="Apakah Anda yakin ingin menghapus ruang rapat ini?"
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
                                        <i class="bi bi-building-x fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada data ruang rapat</p>
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
                    Menampilkan {{ $ruangRapats->firstItem() ?? 0 }} - {{ $ruangRapats->lastItem() ?? 0 }} dari {{ $ruangRapats->total() }} data
                </div>
                {{ $ruangRapats->links() }}
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
                        {{ $isEditing ? 'Edit Ruang Rapat' : 'Tambah Ruang Rapat Baru' }}
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
                                    wire:model="acara_rr" 
                                    class="form-control form-control-custom @error('acara_rr') is-invalid @enderror"
                                    placeholder="Masukkan nama acara rapat"
                                >
                                @error('acara_rr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Bidang</label>
                                <div class="d-flex gap-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model.live="tipe_bidang" value="Internal" id="tipeInternal">
                                        <label class="form-check-label" for="tipeInternal">Internal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model.live="tipe_bidang" value="Eksternal" id="tipeEksternal">
                                        <label class="form-check-label" for="tipeEksternal">Eksternal</label>
                                    </div>
                                </div>
                                
                                @if($tipe_bidang === 'Internal')
                                    <select 
                                        wire:model="bidang_rr" 
                                        class="form-select form-control-custom @error('bidang_rr') is-invalid @enderror"
                                    >
                                        <option value="">Pilih Bidang...</option>
                                        @foreach($opsi_bidang as $opsi)
                                            <option value="{{ $opsi }}">{{ $opsi }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input 
                                        type="text" 
                                        wire:model="bidang_rr" 
                                        class="form-control form-control-custom @error('bidang_rr') is-invalid @enderror"
                                        placeholder="Masukkan nama instansi/bidang eksternal"
                                    >
                                @endif
                                @error('bidang_rr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Tempat</label>
                                <select 
                                    wire:model="tempat_rr" 
                                    class="form-select form-control-custom @error('tempat_rr') is-invalid @enderror"
                                >
                                    <option value="">Pilih Ruang Rapat...</option>
                                    @foreach($opsi_tempat as $tempat)
                                        <option value="{{ $tempat }}">{{ $tempat }}</option>
                                    @endforeach
                                </select>
                                @error('tempat_rr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input 
                                    type="date" 
                                    wire:model="tanggal_rr" 
                                    class="form-control form-control-custom @error('tanggal_rr') is-invalid @enderror"
                                >
                                @error('tanggal_rr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Jam</label>
                                <input 
                                    type="time" 
                                    wire:model="jam_rr" 
                                    class="form-control form-control-custom @error('jam_rr') is-invalid @enderror"
                                >
                                @error('jam_rr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 d-none">
                                <label class="form-label">Hari/Tanggal</label>
                                <input 
                                    type="text" 
                                    wire:model="hari_tgl_rr" 
                                    class="form-control form-control-custom @error('hari_tgl_rr') is-invalid @enderror"
                                    placeholder="contoh: Senin, 4 Feb 2026"
                                >
                                @error('hari_tgl_rr') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Keterangan</label>
                                <textarea 
                                    wire:model="ket_rr" 
                                    class="form-control form-control-custom @error('ket_rr') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Masukkan keterangan tambahan..."
                                ></textarea>
                                @error('ket_rr') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
