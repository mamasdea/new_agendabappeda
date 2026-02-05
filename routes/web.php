<?php

use App\Livewire\Admin\AgendaCrud;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\LaporanAgenda;
use App\Livewire\Admin\RuangRapatCrud;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Livewire\PublicDashboard;

Route::get('/', PublicDashboard::class)->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
})->name('logout');

// Admin Routes (Protected)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/agenda', AgendaCrud::class)->name('admin.agenda');
    Route::get('/ruang-rapat', RuangRapatCrud::class)->name('admin.ruang-rapat');
    Route::get('/user-management', \App\Livewire\Admin\UserManagement::class)->name('admin.users');
    Route::get('/laporan', LaporanAgenda::class)->name('admin.laporan');
});
