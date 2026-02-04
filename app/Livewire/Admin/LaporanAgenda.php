<?php

namespace App\Livewire\Admin;

use App\Models\Agenda;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Laporan Agenda')]
class LaporanAgenda extends Component
{
    #[Url]
    public $filter = ''; // 'hari_ini' atau 'besok' atau kosong (semua)

    public $waText = '';

    #[Url]
    public $tanggal = ''; // Format Y-m-d

    public function render()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $agendaHariIni = collect();
        $agendaBesok = collect();
        $customDate = null;

        // Logika Filter Kustom Tanggal
        if (!empty($this->tanggal)) {
            $customDate = Carbon::parse($this->tanggal);
            $agendaHariIni = Agenda::whereDate('tanggal', $customDate)
                ->orderBy('jam')
                ->get();
            
            // WA Text untuk Custom Date
            $this->waText = "*AGENDA KEGIATAN BAPPEDA KAB. WONOSOBO*\n";
            $this->waText .= "*HARI " . strtoupper($customDate->translatedFormat('l, d F Y')) . "*\n\n";
            
            if ($agendaHariIni->count() > 0) {
                foreach ($agendaHariIni as $agenda) {
                    $jam = $agenda->jam ? $agenda->jam->format('H:i') : '-';
                    $ket = $agenda->keterangan ? "\nℹ️ " . $agenda->keterangan : "";
                    
                    $this->waText .= "🕒 {$jam} WIB\n";
                    $this->waText .= "📝 {$agenda->acara}\n";
                    $this->waText .= "📍 {$agenda->tempat}\n";
                    $this->waText .= "👤 {$agenda->penyelenggara}{$ket}\n\n";
                }
            } else {
                $this->waText .= "_Tidak ada agenda pada tanggal ini._\n\n";
            }

        } else {
            // Logika Filter Lama (Hari Ini / Besok / Semua)
            if ($this->filter === 'hari_ini' || empty($this->filter)) {
                $agendaHariIni = Agenda::whereDate('tanggal', $today)
                    ->orderBy('jam')
                    ->get();
            }
    
            if ($this->filter === 'besok' || empty($this->filter)) {
                $agendaBesok = Agenda::whereDate('tanggal', $tomorrow)
                    ->orderBy('jam')
                    ->get();
            }

            // Susun Teks WA Bersih (Logic Lama)
            $this->waText = "*AGENDA KEGIATAN BAPPEDA KAB. WONOSOBO*\n";
    
            // Bagian Hari Ini
            if (empty($this->filter) || $this->filter === 'hari_ini') {
                $this->waText .= "*HARI " . strtoupper($today->translatedFormat('l, d F Y')) . "*\n\n";
    
                if ($agendaHariIni->count() > 0) {
                    foreach ($agendaHariIni as $agenda) {
                        $jam = $agenda->jam ? $agenda->jam->format('H:i') : '-';
                        $ket = $agenda->keterangan ? "\nℹ️ " . $agenda->keterangan : "";
                        
                        $this->waText .= "🕒 {$jam} WIB\n";
                        $this->waText .= "📝 {$agenda->acara}\n";
                        $this->waText .= "📍 {$agenda->tempat}\n";
                        $this->waText .= "👤 {$agenda->penyelenggara}{$ket}\n\n";
                    }
                } else {
                    $this->waText .= "_Tidak ada agenda hari ini._\n\n";
                }
            }
    
            // Bagian Besok
            if (empty($this->filter) || $this->filter === 'besok') {
                $this->waText .= "*AGENDA BESOK HARI " . strtoupper($tomorrow->translatedFormat('l, d F Y')) . "*\n\n";
    
                if ($agendaBesok->count() > 0) {
                    foreach ($agendaBesok as $agenda) {
                        $jam = $agenda->jam ? $agenda->jam->format('H:i') : '-';
                        $ket = $agenda->keterangan ? "\nℹ️ " . $agenda->keterangan : "";
                        
                        $this->waText .= "🕒 {$jam} WIB\n";
                        $this->waText .= "📝 {$agenda->acara}\n";
                        $this->waText .= "📍 {$agenda->tempat}\n";
                        $this->waText .= "👤 {$agenda->penyelenggara}{$ket}\n\n";
                    }
                } else {
                    $this->waText .= "_Tidak ada agenda besok._\n";
                }
            }
        }

        return view('livewire.admin.laporan-agenda', [
            'agendaHariIni' => $agendaHariIni,
            'agendaBesok' => $agendaBesok,
            'today' => $today,
            'tomorrow' => $tomorrow,
            'isFiltered' => !empty($this->filter),
            'customDate' => $customDate,
        ]);
    }
}
