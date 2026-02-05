<div>
    <div class="row">
        <div class="col-12">
            {{-- Alert --}}
            @if (session()->has('success'))
                <div class="alert alert-custom alert-success-custom mb-4 shadow-sm animate__animated animate__fadeIn">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-custom alert-danger-custom mb-4 shadow-sm animate__animated animate__fadeIn">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- Card --}}
            <div class="card-custom">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 text-white">Daftar Pengguna</h5>
                        <p class="mb-0 text-white-50 small">Kelola akun administrator sistem</p>
                    </div>
                    <button wire:click="resetInput" class="btn btn-light rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#userModal">
                        <i class="bi bi-plus-lg me-2"></i>Tambah User
                    </button>
                </div>
                
                <div class="card-body p-4">
                    {{-- Filters --}}
                    <div class="row mb-4 hstack gap-3">
                        <div class="col-md-4">
                            <div class="search-wrapper">
                                <i class="bi bi-search"></i>
                                <input wire:model.live.debounce.300ms="search" type="text" class="form-control search-input" placeholder="Cari Nama, Username, atau Email...">
                            </div>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table-custom w-100">
                            <thead>
                                <tr>
                                    <th style="width: 80px" class="text-center">No</th>
                                    <th>Informasi User</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th style="width: 150px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr wire:key="user-{{ $user->id }}">
                                        <td class="text-center text-muted fw-bold">
                                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="stats-icon stats-icon-primary" style="width: 40px; height: 40px; font-size: 1rem;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                    <div class="text-muted small">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-custom" style="background: rgba(102, 126, 234, 0.1); color: #667eea;">
                                                <i class="bi bi-person-fill me-1"></i>{{ $user->username }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $user->email ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button wire:click="edit({{ $user->id }})" class="btn-action btn-action-edit" title="Edit User">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                @if($user->id !== auth()->id())
                                                <button wire:confirm="Apakah Anda yakin ingin menghapus user ini?" wire:click="delete({{ $user->id }})" class="btn-action btn-action-delete" title="Hapus User">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                                Data tidak ditemukan
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-white" id="userModalLabel">
                        {{ $isEdit ? 'Edit User' : 'Tambah User Baru' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalBtn"></button>
                </div>
                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                    <div class="modal-body pt-4">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input wire:model="name" type="text" class="form-control-custom w-100 @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap...">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input wire:model="username" type="text" class="form-control-custom w-100 @error('username') is-invalid @enderror" placeholder="Masukkan username unik...">
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <small class="text-muted">(Opsional)</small></label>
                            <input wire:model="email" type="email" class="form-control-custom w-100 @error('email') is-invalid @enderror" placeholder="user@example.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ $isEdit ? 'Ganti Password' : 'Password' }}</label>
                            <input wire:model="password" type="password" class="form-control-custom w-100 @error('password') is-invalid @enderror" placeholder="{{ $isEdit ? 'Kosongkan jika tidak ingin ganti' : 'Minimal 6 karakter' }}">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer pt-0 border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-gradient px-4 rounded-pill">
                            <span wire:loading.remove>{{ $isEdit ? 'Simpan Perubahan' : 'Tambah User' }}</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('close-modal', () => {
            const modal = document.getElementById('userModal');
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) bsModal.hide();
        });

        $wire.on('open-modal', () => {
            const modal = document.getElementById('userModal');
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    </script>
    @endscript
</div>
