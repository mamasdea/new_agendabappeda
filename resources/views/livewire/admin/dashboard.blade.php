<div>
    {{-- Welcome Section --}}
    <div class="mb-4">
        <h2 class="mb-1" style="font-weight: 600; color: #1a1d29;">Selamat Datang! 👋</h2>
        <p class="text-muted mb-0">Kelola agenda dan ruang rapat BAPPEDA dengan mudah</p>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-4">
        {{-- Total Agenda --}}
        <div class="col-md-6 col-lg-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_agenda'] }}</div>
                        <div class="stats-label">Total Agenda</div>
                    </div>
                    <div class="stats-icon stats-icon-primary">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Agenda Hari Ini --}}
        <div class="col-md-6 col-lg-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['agenda_today'] }}</div>
                        <div class="stats-label">Agenda Hari Ini</div>
                    </div>
                    <div class="stats-icon stats-icon-success">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Agenda Mendatang --}}
        <div class="col-md-6 col-lg-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['agenda_upcoming'] }}</div>
                        <div class="stats-label">Agenda Mendatang</div>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(234, 88, 12, 0.15) 100%); color: #f97316;">
                        <i class="bi bi-calendar-plus"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Ruang Rapat --}}
        <div class="col-md-6 col-lg-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['total_ruang_rapat'] }}</div>
                        <div class="stats-label">Total Ruang Rapat</div>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%); color: #8b5cf6;">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ruang Rapat Hari Ini --}}
        <div class="col-md-6 col-lg-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['ruang_rapat_today'] }}</div>
                        <div class="stats-label">Rapat Hari Ini</div>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, rgba(20, 184, 166, 0.15) 0%, rgba(13, 148, 136, 0.15) 100%); color: #14b8a6;">
                        <i class="bi bi-door-open"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ruang Rapat Mendatang --}}
        <div class="col-md-6 col-lg-4">
            <div class="stats-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stats-number">{{ $stats['ruang_rapat_upcoming'] }}</div>
                        <div class="stats-label">Rapat Mendatang</div>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.15) 0%, rgba(219, 39, 119, 0.15) 100%); color: #ec4899;">
                        <i class="bi bi-calendar-week"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Cards --}}
    <div class="row g-4">
        {{-- Agenda Hari Ini --}}
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-header-custom d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="bi bi-calendar-day me-2"></i>Agenda Hari Ini</h5>
                    <a href="{{ url('/admin/agenda') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @forelse ($agendaToday as $agenda)
                        <div class="p-3 border-bottom d-flex align-items-start gap-3 hover-bg">
                            <div class="flex-shrink-0">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
                                    <i class="bi bi-clock text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1" style="font-weight: 600;">{{ $agenda->acara }}</h6>
                                <div class="d-flex flex-wrap gap-2 text-muted small">
                                    @if($agenda->jam)
                                        <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($agenda->jam)->format('H:i') }}</span>
                                    @endif
                                    @if($agenda->tempat)
                                        <span><i class="bi bi-geo-alt me-1"></i>{{ $agenda->tempat }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center">
                            <i class="bi bi-calendar-x fs-1 text-muted opacity-50 d-block mb-3"></i>
                            <p class="text-muted mb-0">Tidak ada agenda hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Ruang Rapat Hari Ini --}}
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-header-custom d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Rapat Hari Ini</h5>
                    <a href="{{ url('/admin/ruang-rapat') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @forelse ($ruangRapatToday as $ruangRapat)
                        <div class="p-3 border-bottom d-flex align-items-start gap-3 hover-bg">
                            <div class="flex-shrink-0">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(109, 40, 217, 0.1) 100%);">
                                    <i class="bi bi-door-open" style="color: #8b5cf6;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1" style="font-weight: 600;">{{ $ruangRapat->acara_rr }}</h6>
                                <div class="d-flex flex-wrap gap-2 text-muted small">
                                    @if($ruangRapat->jam_rr)
                                        <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($ruangRapat->jam_rr)->format('H:i') }}</span>
                                    @endif
                                    @if($ruangRapat->tempat_rr)
                                        <span><i class="bi bi-geo-alt me-1"></i>{{ $ruangRapat->tempat_rr }}</span>
                                    @endif
                                    @if($ruangRapat->bidang_rr)
                                        <span><i class="bi bi-people me-1"></i>{{ $ruangRapat->bidang_rr }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center">
                            <i class="bi bi-building-x fs-1 text-muted opacity-50 d-block mb-3"></i>
                            <p class="text-muted mb-0">Tidak ada rapat hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Agenda Mendatang --}}
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header-custom d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                    <h5 class="mb-0"><i class="bi bi-calendar-range me-2"></i>Agenda Mendatang</h5>
                    <a href="{{ url('/admin/agenda') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if($upcomingAgenda->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>Acara</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Tempat</th>
                                        <th>Penyelenggara</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingAgenda as $agenda)
                                        <tr>
                                            <td><strong>{{ $agenda->acara }}</strong></td>
                                            <td>
                                                <span class="badge badge-custom bg-warning bg-opacity-10 text-warning">
                                                    {{ $agenda->tanggal ? $agenda->tanggal->format('d M Y') : '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($agenda->jam)
                                                    <span class="badge badge-custom bg-success bg-opacity-10 text-success">
                                                        {{ \Carbon\Carbon::parse($agenda->jam)->format('H:i') }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $agenda->tempat ?? '-' }}</td>
                                            <td>{{ $agenda->penyelenggara ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x fs-1 text-muted opacity-50 d-block mb-3"></i>
                            <p class="text-muted mb-0">Tidak ada agenda mendatang</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-bg {
            transition: background-color 0.2s ease;
        }
        .hover-bg:hover {
            background-color: rgba(102, 126, 234, 0.03);
        }
    </style>
</div>
