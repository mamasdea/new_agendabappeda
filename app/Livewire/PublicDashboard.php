<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Agenda;
use App\Models\RuangRapat;
use Carbon\Carbon;

#[Layout('components.layouts.public')]
#[Title('Agenda BAPPEDA Wonosobo')]
class PublicDashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // 1. Agenda Hari Ini
        $agendas = Agenda::whereDate('tanggal', $today)
            ->orderBy('jam')
            ->get();

        // 2. Ruang Rapat Hari Ini
        $rrToday = RuangRapat::whereDate('tanggal_rr', $today)
            ->orderBy('jam_rr')
            ->get();

        // 3. Ruang Rapat Besok/Mendatang (Limit 50 untuk slider)
        $rrUpcoming = RuangRapat::whereDate('tanggal_rr', '>=', $tomorrow)
            ->orderBy('tanggal_rr')
            ->orderBy('jam_rr')
            ->take(50) 
            ->get();

        return view('livewire.public-dashboard', [
            'agendas' => $agendas,
            'rrToday' => $rrToday,
            'rrUpcoming' => $rrUpcoming,
            'today' => $today
        ]);
    }
}
