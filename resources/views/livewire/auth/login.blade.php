<div>
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-calendar-event"></i>
            </div>
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Silakan masuk ke akun Anda</p>
        </div>

        @if (session()->has('error'))
            <div class="alert alert-custom alert-danger-custom">
                <i class="bi bi-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-custom alert-success-custom">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit="login">
            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrapper">
                    <input 
                        type="text" 
                        id="username"
                        wire:model="username" 
                        class="form-control-custom @error('username') is-invalid @enderror"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        autofocus
                    >
                    <i class="bi bi-person input-icon"></i>
                </div>
                @error('username')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <input 
                        type="password" 
                        id="password"
                        wire:model="password" 
                        class="form-control-custom @error('password') is-invalid @enderror"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                    >
                    <i class="bi bi-lock input-icon"></i>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input 
                        type="checkbox" 
                        id="remember"
                        wire:model="remember" 
                        class="form-check-input"
                    >
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-login" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </span>
                <span wire:loading wire:target="login">
                    <span class="spinner-border spinner-border-sm"></span> Memproses...
                </span>
            </button>
        </form>
    </div>
</div>
