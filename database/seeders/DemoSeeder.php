<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use App\Models\RuangRapat;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data hari ini dan besok
        Agenda::whereDate('tanggal', '>=', Carbon::today())->delete();
        RuangRapat::whereDate('tanggal_rr', '>=', Carbon::today())->delete();

        $faker = \Faker\Factory::create('id_ID');
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        
        $ruangList = [
            'R. Rapat Tan Malaka',
            'R. Rapat Sedyatmo',
            'R. Rapat Widjojo Nitisastro',
            'R. Rapat Emil Salim',
            'R. Rapat Meutia Hatta',
        ];

        $bidangList = ['Sekretariat', 'Randalevalitbang', 'Ekonomi', 'Pemsosbud', 'IPW'];
        
        $acaraList = [
            'Rapat Koordinasi Perencanaan Pembangunan',
            'FGD Penyusunan Dokumen RKPD',
            'Sosialisasi Sistem Informasi Daerah',
            'Rapat Evaluasi Kinerja Triwulan',
            'Pembahasan Draft Ranperda Tata Ruang',
            'Kunjungan Kerja DPRD Provinsi',
            'Rapat Staf Rutin Mingguan',
            'Verifikasi Proposal Bantuan Sosial',
            'Monitoring dan Evaluasi Program Stunting',
            'Pelatihan Teknis Input Data SIPD',
            'Audiensi dengan Organisasi Masyarakat',
            'Rapat Koordinasi Lintas Sektoral',
            'Workshop Peningkatan Kapasitas SDM',
        ];

        // 1. BUAT 10 AGENDA HARI INI
        echo "Membuat 10 Agenda Hari Ini...\n";
        for ($i = 0; $i < 10; $i++) {
            $jam = Carbon::createFromTime(rand(8, 15), rand(0, 1) * 30, 0); 
            
            Agenda::create([
                'tanggal' => $today,
                'jam' => $jam,
                'acara' => $faker->randomElement($acaraList) . ' (' . $faker->words(2, true) . ')',
                'tempat' => $faker->randomElement($ruangList) . ' / Aula Bappeda',
                'penyelenggara' => $faker->randomElement($bidangList),
                'keterangan' => $i % 3 == 0 ? 'Harap membawa laptop' : null,
            ]);
        }

        // 2. BUAT JADWAL RUANG RAPAT HARI INI
        echo "Membuat Jadwal Ruang Rapat Hari Ini...\n";
        foreach ($ruangList as $index => $ruang) {
            $jamMulai = 8 + $index; 
            $jam = Carbon::createFromTime($jamMulai, 0, 0);

            RuangRapat::create([
                'acara_rr' => 'Pemakaian ' . $ruang . ' untuk ' . $faker->words(3, true),
                'bidang_rr' => $faker->randomElement($bidangList),
                'jam_rr' => $jam,
                'tanggal_rr' => $today,
                'tempat_rr' => $ruang,
                'ket_rr' => 'Dihadiri ' . rand(10, 50) . ' orang',
                'hari_tgl_rr' => $today->translatedFormat('l, d F Y')
            ]);
        }

        // 3. BUAT JADWAL RUANG RAPAT BESOK
        echo "Membuat Jadwal Ruang Rapat Besok...\n";
        foreach ($ruangList as $index => $ruang) {
            $jamMulai = 9 + ($index % 3); 
            $jam = Carbon::createFromTime($jamMulai, 30, 0);
            $isEksternal = rand(0, 1) == 1;
            
            RuangRapat::create([
                'acara_rr' => 'Rapat Lanjutan: ' . $faker->sentence(3),
                'bidang_rr' => $isEksternal ? 'Dinas ' . $faker->firstName : $faker->randomElement($bidangList),
                'jam_rr' => $jam,
                'tanggal_rr' => $tomorrow,
                'tempat_rr' => $ruang,
                'ket_rr' => null,
                'hari_tgl_rr' => $tomorrow->translatedFormat('l, d F Y')
            ]);
        }
        
        echo "Selesai! Data dummy berhasil dibuat.\n";
    }
}
