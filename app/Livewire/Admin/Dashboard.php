<?php

namespace App\Livewire\Admin;

use App\Models\Agenda;
use App\Models\RuangRapat;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_agenda' => Agenda::count(),
            'agenda_today' => Agenda::whereDate('tanggal', today())->count(),
            'agenda_upcoming' => Agenda::whereDate('tanggal', '>', today())->count(),
            'total_ruang_rapat' => RuangRapat::count(),
            'ruang_rapat_today' => RuangRapat::whereDate('tanggal_rr', today())->count(),
            'ruang_rapat_upcoming' => RuangRapat::whereDate('tanggal_rr', '>', today())->count(),
        ];

        $agendaToday = Agenda::whereDate('tanggal', today())
            ->orderBy('jam')
            ->take(5)
            ->get();

        $ruangRapatToday = RuangRapat::whereDate('tanggal_rr', today())
            ->orderBy('jam_rr')
            ->take(5)
            ->get();

        $upcomingAgenda = Agenda::whereDate('tanggal', '>', today())
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'agendaToday' => $agendaToday,
            'ruangRapatToday' => $ruangRapatToday,
            'upcomingAgenda' => $upcomingAgenda,
        ]);
    }
}
