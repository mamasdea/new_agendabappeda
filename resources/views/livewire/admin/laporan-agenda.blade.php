<div>
    {{-- Header Content --}}
    <div class="d-flex align-items-center justify-content-between mb-4 layout-header border-bottom pb-3">
        {{-- Kiri: Logo & Judul --}}
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('assets/logo/logoheader.png') }}" alt="Logo" width="120" class="d-block d-print-inline-block">
            <div>
                @if($customDate)
                    <h2 class="fw-bold text-dark mb-0 header-title text-uppercase">AGENDA BAPPEDA</h2>
                    <p class="text-muted mb-0 header-subtitle">{{ $customDate->translatedFormat('l, d F Y') }}</p>
                @elseif($filter === 'hari_ini')
                    <h2 class="fw-bold text-dark mb-0 header-title text-uppercase">AGENDA BAPPEDA</h2>
                    <p class="text-muted mb-0 header-subtitle">{{ $today->translatedFormat('l, d F Y') }}</p>
                @elseif($filter === 'besok')
                    <h2 class="fw-bold text-dark mb-0 header-title text-uppercase">AGENDA BAPPEDA</h2>
                    <p class="text-muted mb-0 header-subtitle">{{ $tomorrow->translatedFormat('l, d F Y') }}</p>
                @else
                    <h2 class="fw-bold text-dark mb-0 header-title text-uppercase">AGENDA BAPPEDA</h2>
                    <p class="text-muted mb-0 header-subtitle">Kabupaten Wonosobo</p>
                @endif
            </div>
        </div>

        {{-- Kanan: Tombol Aksi --}}
        <div class="d-flex gap-2 action-buttons d-print-none">
            <button onclick="copyToClipboard()" class="btn btn-copy shadow-sm">
                <i class="bi bi-whatsapp me-2"></i>Copy WA
            </button>
            <button onclick="window.print()" class="btn btn-print shadow-sm">
                <i class="bi bi-printer-fill me-2"></i>Cetak
            </button>
            <button onclick="downloadJPG()" class="btn btn-primary shadow-sm">
                <i class="bi bi-file-image me-2"></i>JPG
            </button>
            <a href="{{ url('/admin/agenda') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="report-container">
        {{-- Data Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped border-dark table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 10%">Jam</th>
                        <th style="width: 30%">Acara / Kegiatan</th>
                        <th style="width: 20%">Tempat</th>
                        <th style="width: 15%">Penyelenggara</th>
                        <th style="width: 20%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    
                    {{-- Agenda Hari Ini / Custom Date --}}
                    @if($customDate || empty($filter) || $filter == 'hari_ini')
                        @if(empty($filter) && !$customDate)
                        <tr class="table-info border-dark">
                            <td colspan="6" class="fw-bold text-center text-uppercase py-2">
                                Agenda Hari Ini - {{ $today->translatedFormat('l, d F Y') }}
                            </td>
                        </tr>
                        @endif
                        
                        @forelse($agendaHariIni as $agenda)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center fw-bold">{{ $agenda->jam ? $agenda->jam->format('H:i') : '-' }} WIB</td>
                            <td class="fw-bold">{{ $agenda->acara }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt-fill text-danger"></i> {{ $agenda->tempat }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-person-fill text-primary"></i> {{ $agenda->penyelenggara }}
                                </div>
                            </td>
                            <td class="text-muted fst-italic small text-wrap">
                                @if($agenda->keterangan)
                                    <i class="bi bi-info-circle-fill text-info me-1"></i>{{ $agenda->keterangan }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted fst-italic py-3">Tidak ada kegiatan terjadwal {{ $customDate ? 'pada tanggal ini' : 'hari ini' }}.</td>
                        </tr>
                        @endforelse
                    @endif

                    {{-- Agenda Besok (Disembunyikan jika Custom Date) --}}
                    @if(!$customDate && (empty($filter) || $filter == 'besok'))
                        @if(empty($filter))
                        <tr class="table-warning border-dark">
                            <td colspan="6" class="fw-bold text-center text-uppercase py-2">
                                Agenda Besok - {{ $tomorrow->translatedFormat('l, d F Y') }}
                            </td>
                        </tr>
                        {{-- Optional: Reset No or Continue --}}
                        @endif
                        
                        @forelse($agendaBesok as $agenda)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center fw-bold">{{ $agenda->jam ? $agenda->jam->format('H:i') : '-' }} WIB</td>
                            <td class="fw-bold">{{ $agenda->acara }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt-fill text-danger"></i> {{ $agenda->tempat }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-person-fill text-primary"></i> {{ $agenda->penyelenggara }}
                                </div>
                            </td>
                            <td class="text-muted fst-italic small text-wrap">
                                @if($agenda->keterangan)
                                    <i class="bi bi-info-circle-fill text-info me-1"></i>{{ $agenda->keterangan }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted fst-italic py-3">Tidak ada kegiatan terjadwal besok.</td>
                        </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Print Footer --}}
        <div class="print-footer mt-5 pt-4 border-top">
            <div class="d-flex justify-content-between align-items-end">
                <div class="text-muted small">
                    <p class="mb-1">Dicetak pada: {{ now()->translatedFormat('l, d F Y H:i') }} WIB</p>
                    <p class="mb-0">Oleh: {{ Auth::user()->name ?? 'Administrator' }}</p>
                </div>
                <!-- <div class="text-end">
                    <p class="mb-5 pb-4">Mengetahui,</p>
                    <p class="fw-bold mb-0 text-decoration-underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                </div> -->
            </div>
            <div class="text-center mt-4 copyright-text">
                <small class="text-muted">&copy; Bappeda Kabupaten Wonosobo by Dea Aldy Alfian 2023 - {{ date('Y') }}</small>
            </div>
        </div>
    </div>

    {{-- Auto Print if Filtered --}}
    @if(!empty($filter))
    <script>
        document.addEventListener('livewire:initialized', () => {
             setTimeout(() => {
                window.print();
             }, 800);
        });
    </script>
    @endif

    {{-- Hidden Text for Copy --}}
    <textarea id="wa-text" class="d-none">{!! $waText !!}</textarea>

    {{-- Script Copy --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("wa-text");
            navigator.clipboard.writeText(copyText.value).then(function() {
                // Toast notification sederhana
                const btn = document.querySelector('.btn-copy');
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Tersalin!';
                btn.classList.add('btn-success');
                btn.classList.remove('btn-copy');
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.add('btn-copy');
                    btn.classList.remove('btn-success');
                }, 2000);
            }, function(err) {
                console.error('Gagal menyalin: ', err);
            });
        }

        function downloadJPG() {
            // Elemen yang akan di-capture
            const header = document.querySelector('.layout-header');
            const content = document.querySelector('.report-container');
            
            // Buat container sementara untuk capture agar layout rapi
            const captureArea = document.createElement('div');
            captureArea.style.position = 'absolute';
            captureArea.style.top = '-9999px';
            captureArea.style.left = '0';
            captureArea.style.width = '1200px'; // Set lebar tetap agar hasil konsisten
            captureArea.style.padding = '40px';
            captureArea.style.backgroundColor = '#ffffff';
            captureArea.style.zIndex = '-1';
            
            // Clone elemen
            const headerClone = header.cloneNode(true);
            const contentClone = content.cloneNode(true);
            
            // Hapus tombol aksi di clone header
            const actionButtons = headerClone.querySelector('.action-buttons');
            if(actionButtons) actionButtons.remove();

            // Tampilkan Footer di Clone (karena defaultnya hidden/hanya print)
            const footer = contentClone.querySelector('.print-footer');
            if(footer) {
                footer.style.display = 'block'; // Paksa tampil untuk capture
            }
            
            // Masukkan ke capture area
            captureArea.appendChild(headerClone);
            captureArea.appendChild(contentClone);
            document.body.appendChild(captureArea);
            
            // Proses generate gambar
            html2canvas(captureArea, {
                scale: 2, // Kualitas tinggi
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Agenda-Bappeda-' + new Date().toISOString().slice(0,10) + '.jpg';
                link.href = canvas.toDataURL('image/jpeg', 0.9);
                link.click();
                
                // Bersihkan
                document.body.removeChild(captureArea);
            });
        }
    </script>
    
    <style>
        /* Modern Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        /* Styles */
        .btn-copy {
            background: #25D366;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-copy:hover {
            background: #128C7E;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        }
        
        .btn-print {
            background: #1a1d29;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-print:hover {
            background: #334155;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 29, 41, 0.3);
        }

        /* Section Header */
        .section-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px dashed #e2e8f0;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.3);
        }

        .tomorrow-header .header-icon {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 10px 20px -5px rgba(217, 119, 6, 0.3);
        }

        .badge-day {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            font-weight: 700;
            color: #4f46e5;
            background: #e0e7ff;
            padding: 4px 12px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 0.25rem;
        }

        .badge-day.upcoming {
            color: #d97706;
            background: #fef3c7;
        }

        .date-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            margin: 0;
            color: #1e293b;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 1rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
            border-radius: 2px;
        }

        .timeline-item {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1rem;
            top: 1.5rem;
            width: 1rem;
            height: 2px;
            background: #e2e8f0;
            transform: translateX(2px);
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: -1.25rem;
            top: 1.25rem;
            width: 12px;
            height: 12px;
            background: white;
            border: 3px solid #6366f1;
            border-radius: 50%;
            transform: translateX(1.5px);
            z-index: 2;
        }

        .timeline-time {
            min-width: 80px;
            padding-top: 0.75rem;
            text-align: center;
        }

        .time-badge {
            display: block;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            color: #4f46e5;
            line-height: 1;
        }
        
        .time-badge.upcoming {
            color: #d97706;
        }

        .time-suffix {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
        }

        .timeline-content {
            flex: 1;
            background: white;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .timeline-content::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, #6366f1, #a5b4fc);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
            border-color: #e2e8f0;
        }

        .agenda-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
            line-height: 1.4;
        }

        .agenda-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #475569;
            background: #f8fafc;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        .detail-item.full-width {
            grid-column: 1 / -1;
            background: #f0f9ff;
            color: #0369a1;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #f8fafc;
            border-radius: 16px;
            border: 2px dashed #e2e8f0;
        }

        .empty-state p {
            margin-top: 1rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Print Settings */
        @media print {
            /* Reset Layout */
            .sidebar, .topbar, .action-buttons, footer {
                display: none !important;
            }
            
            .main-content {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            body {
                background: white !important;
                font-size: 12pt;
                color: black !important;
            }

            .report-container {
                padding: 0;
            }

            .layout-header {
                margin-bottom: 2rem !important;
                border-bottom: 2px solid #000;
                padding-bottom: 1rem;
            }
            
            /* Timeline Adaptation For Print */
            .timeline::before, 
            .timeline-item::before, 
            .timeline-item::after,
            .timeline-content::before {
                display: none !important; /* Hilangkan dekorasi timeline saat print untuk kebersihan */
            }

            .timeline-item {
                gap: 1.5rem;
                margin-bottom: 1.5rem;
                page-break-inside: avoid; /* Jangan potong item di tengah halaman */
                border-bottom: 1px solid #eee;
                padding-bottom: 1.5rem;
            }

            .timeline-time {
                min-width: 70px;
                text-align: left;
            }

            .time-badge {
                color: #000 !important;
                font-size: 1.1rem;
            }

            .timeline-content {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                background: none !important;
            }

            .agenda-title {
                font-size: 1.2rem;
                color: #000 !important;
                margin-bottom: 0.5rem;
            }

            .detail-item {
                background: none !important;
                padding: 0;
                margin-bottom: 0.25rem;
                font-size: 10pt;
                color: #333 !important;
            }

            .header-icon {
                display: none;
            }

            .section-header {
                border-bottom: 1px solid #000;
                margin-bottom: 1.5rem;
                padding-bottom: 0.5rem;
            }

            .date-title {
                font-size: 1.4rem;
                color: #000 !important;
            }

            .badge-day {
                border: 1px solid #000;
                background: none !important;
                color: #000 !important;
            }

            /* Print Footer */
            /* Footer Statis di akhir dokumen */
            .print-footer {
                display: block !important;
                position: relative !important;
                margin-top: 30px !important;
                width: 100% !important;
                background: white !important;
                page-break-inside: avoid !important;
            }
            
            /* Sembunyikan footer di mode layar biasa */
            .print-footer {
                display: none;
            }
            
            /* Pastikan background warna/image tercetak jika user mengaktifkan opsi tersebut */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .print-footer {
            display: none; /* Hide default on screen */
        }
    </style>
</div>
