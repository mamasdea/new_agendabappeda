<div class="dashboard-container font-sans bg-gray-50 h-screen w-screen overflow-hidden flex flex-col">
    
    {{-- CSS Custom --}}
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        @keyframes scrollUp {
            0% { transform: translateY(0); }
            100% { transform: translateY(-50%); }
        }
        .animate-scroll-agenda { animation: scrollUp 60s linear infinite; } /* Diperlambat sedikit agar mudah dibaca */
    </style>

    {{-- HEADER --}}
    <header class="bg-white text-blue-900 shadow-md z-10 p-3 flex justify-between items-center h-20 shrink-0 border-b-4 border-blue-800">
        <div class="flex items-center gap-4 pl-2">
            {{-- Logo Image --}}
            <img src="{{ asset('assets/logo/logoheader.png') }}" alt="Logo Wonosobo" class="h-12 w-auto object-contain drop-shadow-sm">
            
            <div class="flex flex-col justify-center">
                <h1 class="text-3xl font-extrabold tracking-tight uppercase leading-none text-blue-900" style="font-family: 'Outfit', sans-serif;">AGENDA BAPPEDA HARI INI</h1>
                <p class="text-blue-800 text-sm mt-0.5 flex items-center gap-2 font-semibold">
                    <!-- <span class="flex items-center gap-1"><i class="bi bi-geo-alt-fill text-red-600"></i> Kab. Wonosobo</span> -->
                    <span class="text-gray-400">|</span> 
                    <span class="text-gray-600">{{ $today->translatedFormat('l, d F Y') }}</span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3 pr-2">
            <div class="text-right hidden xl:block">
                <!-- <div class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Waktu Saat Ini</div>
                <div class="text-lg font-bold text-blue-900 leading-none">Indonesia Barat</div> -->
            </div>
            <div class="bg-blue-900 text-white px-5 py-2 rounded-xl shadow-lg flex flex-col items-center justify-center min-w-[110px] border border-blue-800">
                <div id="digital-clock" class="text-3xl font-mono font-bold leading-none tracking-wider">00:00</div>
                <div class="text-[10px] uppercase font-bold text-blue-200 mt-0.5 w-full text-center">WIB</div>
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-3 grid grid-cols-12 gap-3 overflow-hidden h-full">
        
        {{-- KOLOM KIRI: AGENDA (LIST) --}}
        <div class="col-span-7 flex flex-col h-full bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            {{-- Header --}}
            <div class="bg-blue-600 px-4 py-2 flex justify-between items-center text-white shrink-0 z-10 shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-list-task text-lg text-yellow-300"></i>
                    <div>
                        <h2 class="text-base font-bold uppercase tracking-wide">Agenda Utama</h2>
                        <p class="text-blue-100 text-[10px]">{{ $agendas->count() }} Kegiatan Hari Ini</p>
                    </div>
                </div>
            </div>

            {{-- Table Head --}}
            <div class="bg-blue-50 border-b border-blue-100 px-3 py-2 grid grid-cols-12 gap-2 font-bold text-blue-800 text-[11px] uppercase tracking-wider shrink-0 z-10">
                <div class="col-span-2 text-center">Waktu</div>
                <div class="col-span-6 pl-2">Rincian Kegiatan</div>
                <div class="col-span-2">Lokasi</div>
                <div class="col-span-2 text-center">Bidang</div>
            </div>

            {{-- Scroll Area --}}
            <div class="relative flex-1 overflow-hidden bg-white">
                <div id="scrolling-wrapper" class="absolute w-full">
                    @for ($i = 0; $i < 2; $i++) 
                        @if($i == 1 && $agendas->count() <= 5) @break @endif
                        <div class="scrolling-group">
                            @forelse($agendas as $agenda)
                            <div class="agenda-item border-b border-gray-100 px-3 py-2 grid grid-cols-12 gap-2 items-center hover:bg-blue-50 transition-colors odd:bg-white even:bg-gray-50/50">
                                <div class="col-span-2 flex flex-col items-center justify-center">
                                    <span class="font-bold text-base text-blue-700 bg-blue-100 px-2 py-0.5 rounded">{{ $agenda->jam ? $agenda->jam->format('H:i') : '--:--' }}</span>
                                    <span class="text-[8px] uppercase font-bold text-blue-400 mt-0.5">WIB</span>
                                </div>
                                <div class="col-span-6 pl-2 pr-2 border-l-2 border-blue-100">
                                    <h3 class="font-bold text-gray-800 text-[13px] leading-tight mb-0.5">{{ $agenda->acara }}</h3>
                                    @if($agenda->keterangan)
                                    <p class="text-gray-500 text-[10px] italic line-clamp-1"><i class="bi bi-info-circle mr-1 text-orange-400"></i>{{ $agenda->keterangan }}</p>
                                    @endif
                                </div>
                                <div class="col-span-2 text-gray-600 text-[10px] font-semibold leading-tight">
                                    <i class="bi bi-geo-alt text-red-500 mr-1"></i> {{ $agenda->tempat }}
                                </div>
                                <div class="col-span-2 flex justify-center">
                                    <span class="bg-orange-100 text-orange-700 text-[9px] font-bold px-1.5 py-0.5 rounded-full text-center border border-orange-200 w-full truncate">
                                        {{ $agenda->penyelenggara }}
                                    </span>
                                </div>
                            </div>
                            @empty
                                @if($i == 0)
                                <div class="flex flex-col items-center justify-center p-10 text-gray-400">
                                    <span class="text-sm">Tidak ada agenda kegiatan hari ini.</span>
                                </div>
                                @endif
                            @endforelse
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RUANG RAPAT (DYNAMIC MODE) --}}
        <div class="col-span-5 flex flex-col gap-3 h-full overflow-hidden">
            
            {{-- CARD 1: Ruang Rapat Hari Ini (Dynamic Height, Max 50%) --}}
            <div class="bg-white rounded-xl shadow-md border border-gray-200 flex flex-col shrink-0 max-h-[50%] overflow-hidden transition-all duration-300">
                <div class="bg-cyan-600 px-3 py-2 text-white shrink-0 flex justify-between items-center text-xs shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-door-open-fill text-cyan-200"></i>
                        <span class="font-bold uppercase tracking-wide">PEMAKAKAIAN RUANG RAPAT HARI INI</span>
                    </div>
                    <span class="bg-cyan-700 px-1.5 rounded text-[10px]">{{ $rrToday->count() }} Use</span>
                </div>
                
                {{-- List Compact --}}
                <div class="overflow-auto p-1.5 space-y-1.5 bg-cyan-50/30 no-scrollbar">
                     @forelse($rrToday as $rr)
                    <div class="bg-white p-1.5 rounded border border-cyan-100 flex items-center gap-2 hover:bg-cyan-50">
                        <div class="bg-cyan-100 text-cyan-800 font-mono font-bold text-xs px-1.5 py-1 rounded text-center min-w-[45px]">
                            {{ $rr->jam_rr ? $rr->jam_rr->format('H:i') : '' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-800 text-[11px] truncate leading-none">{{ $rr->tempat_rr }}</h4>
                                <span class="text-[9px] text-gray-400">{{ $rr->bidang_rr }}</span>
                            </div>
                            <p class="text-xs text-gray-600 truncate mt-0.5 leading-tight w-full">{{ $rr->acara_rr }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 flex items-center justify-center text-gray-400 text-[10px]">
                        Kosong / Tersedia
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- CARD 2: Jadwal Mendatang (Slider/Paged Mode) --}}
            <div class="bg-white rounded-xl shadow-md border border-gray-200 flex flex-col flex-1 min-h-0 overflow-hidden relative">
                <div class="bg-orange-500 px-3 py-2 text-white shrink-0 flex justify-between items-center text-xs shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-calendar-week-fill text-orange-200"></i>
                        <span class="font-bold uppercase tracking-wide">JADWAL PEMAKAIAN RUANG RAPAT</span>
                    </div>
                    {{-- Page Indicator --}}
                    <div id="rr-page-indicator" class="flex gap-1">
                        {{-- Dots filled by JS --}}
                    </div>
                </div>
                
                {{-- Content Area --}}
                <div class="flex-1 bg-orange-50/10 relative overflow-hidden">
                    <table class="w-full text-left h-full">
                        <!-- <thead class="bg-orange-50 text-orange-800 uppercase font-bold text-[9px] border-b border-orange-100">
                            <tr>
                                <th class="px-2 py-1.5 w-[15%]">Tgl</th>
                                <th class="px-2 py-1.5 w-[12%]">Jam</th>
                                <th class="px-2 py-1.5">Info Reservasi</th>
                            </tr>
                        </thead> -->
                        <tbody class="relative text-[10px]">
                            @if($rrUpcoming->count() > 0)
                                @php $chunks = $rrUpcoming->chunk(5); @endphp
                                @foreach($chunks as $index => $chunk)
                                <tr class="rr-page-group absolute top-0 left-0 w-full transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-page="{{ $index }}">
                                    <td colspan="3" class="p-0 border-none">
                                        <table class="w-full">
                                            @foreach($chunk as $rr)
                                            <tr class="bg-white hover:bg-orange-50 border-b border-orange-50">
                                                <td class="px-2 py-1.5 font-bold text-orange-600 whitespace-nowrap bg-white/50 align-top w-[15%]">
                                                    {{ $rr->tanggal_rr ? $rr->tanggal_rr->format('d/m') : '' }}
                                                </td>
                                                <td class="px-2 py-1.5 font-mono text-gray-500 font-semibold bg-white/50 align-top w-[12%]">
                                                    {{ $rr->jam_rr ? $rr->jam_rr->format('H:i') : '' }}
                                                </td>
                                                <td class="px-2 py-1 align-top">
                                                    <div class="font-bold text-gray-800 truncate">{{ $rr->tempat_rr }}</div>
                                                    <div class="text-gray-500 truncate mt-px line-clamp-1 leading-tight">{{ $rr->acara_rr }}</div>
                                                    <div class="text-[9px] text-orange-600 font-bold mt-0.5 truncate">
                                                        <span class="uppercase mr-2"><i class="bi bi-people-fill mr-1 opacity-50"></i>{{ $rr->bidang_rr }}</span>
                                                        @if($rr->ket_rr)
                                                        <span class="text-gray-500 font-normal italic border-l border-gray-300 pl-2"><i class="bi bi-info-circle mr-0.5 opacity-70"></i>{{ $rr->ket_rr }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            {{-- Fill empty rows if chunk < 5 to keep layout stable --}}
                                            @for($k = 0; $k < (5 - $chunk->count()); $k++)
                                            <tr class="h-[34px]">
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            @endfor
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center py-10 text-gray-400 italic text-[10px]">Belum ada data reservasi mendatang.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <style>
        /* Hide global footer from layout to prevent double footer */
        body > footer { display: none !important; }
    </style>

    {{-- FOOTER RUNNING TEXT --}}
    <footer class="bg-blue-800 text-white py-0.5 shrink-0 border-t-2 border-orange-500 z-20">
        <marquee scrollamount="5" class="text-[10px] font-medium pt-0.5">
            Selamat Datang di Bappeda Kabupaten Wonosobo • Silakan Hubungi Sub Bagian Umum untuk Reservasi Ruang Rapat • Jagalah Kebersihan dan Ketertiban - &copy; Bappeda Kabupaten Wonosobo by <a href="https://github.com/mamasdea" target="_blank" class="text-decoration-none">Mamas Dea</a> 2023 - {{ date('Y') }}
        </marquee>
    </footer>

    {{-- Hidden Link --}}
    <a href="{{ route('login') }}" class="fixed bottom-0 right-0 w-8 h-8 z-50 cursor-default opacity-0"></a>

    {{-- Tailwind & Scripts --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], mono: ['Outfit', 'monospace'] } } } }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');</style>
    <script>
        function updateClock() { document.getElementById('digital-clock').innerText = new Date().toLocaleTimeString('id-ID', { hour12: false, hour: '2-digit', minute:'2-digit' }).replace('.', ':'); }
        setInterval(updateClock, 1000); updateClock();
        document.addEventListener("DOMContentLoaded", () => { 
            if({{ $agendas->count() }} > 5) document.getElementById('scrolling-wrapper').classList.add('animate-scroll-agenda'); 

            // Auto Slide Ruang Rapat Upcoming
            const pages = document.querySelectorAll('.rr-page-group');
            const totalPages = pages.length;
            
            if(totalPages > 1) {
                // Buat Dots Indicator
                const indicatorContainer = document.getElementById('rr-page-indicator');
                for(let i=0; i<totalPages; i++) {
                    const dot = document.createElement('div');
                    dot.className = `w-1.5 h-1.5 rounded-full ${i===0 ? 'bg-white' : 'bg-white/40'}`;
                    dot.id = `dot-${i}`;
                    indicatorContainer.appendChild(dot);
                }

                let currentPage = 0;
                setInterval(() => {
                    // Hide Current
                    pages[currentPage].classList.remove('opacity-100', 'z-10');
                    pages[currentPage].classList.add('opacity-0', 'z-0');
                    document.getElementById(`dot-${currentPage}`).classList.remove('bg-white');
                    document.getElementById(`dot-${currentPage}`).classList.add('bg-white/40');

                    // Next Page
                    currentPage = (currentPage + 1) % totalPages;

                    // Show Next
                    pages[currentPage].classList.remove('opacity-0', 'z-0');
                    pages[currentPage].classList.add('opacity-100', 'z-10');
                    document.getElementById(`dot-${currentPage}`).classList.remove('bg-white/40');
                    document.getElementById(`dot-${currentPage}`).classList.add('bg-white');

                }, 8000); // Ganti setiap 8 detik
            }
        });
    </script>
</div>
