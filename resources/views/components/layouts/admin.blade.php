<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo/icon bappeda.png') }}" type="image/x-icon">
    <title>{{ $title ?? 'Admin Panel' }} - Agenda BAPPEDA</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: #1a1d29;
            --sidebar-hover: rgba(255, 255, 255, 0.1);
            --sidebar-active: rgba(102, 126, 234, 0.3);
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            transition: var(--transition-smooth);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            background: var(--primary-gradient);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .sidebar-brand-text {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -0.5px;
        }

        .sidebar-brand-subtitle {
            font-size: 0.75rem;
            opacity: 0.8;
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            padding: 0.5rem 1.5rem;
            margin-top: 0.5rem;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition-smooth);
            border-left: 3px solid transparent;
            margin: 2px 0;
        }

        .sidebar-nav .nav-link:hover {
            color: white;
            background: var(--sidebar-hover);
            border-left-color: rgba(102, 126, 234, 0.5);
        }

        .sidebar-nav .nav-link.active {
            color: white;
            background: var(--sidebar-active);
            border-left-color: #667eea;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.1rem;
            width: 24px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: var(--transition-smooth);
        }

        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar-title {
            font-weight: 600;
            font-size: 1.25rem;
            color: #1a1d29;
            margin: 0;
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Cards */
        .card-custom {
            background: white;
            border-radius: 16px;
            border: none;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: var(--transition-smooth);
        }

        .card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        }

        .card-header-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 1.25rem 1.5rem;
            border: none;
        }

        .card-header-custom h5 {
            margin: 0;
            font-weight: 600;
        }

        /* Buttons */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            transition: var(--transition-smooth);
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
            border: none;
        }

        .btn-action-edit {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .btn-action-edit:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
        }

        .btn-action-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .btn-action-delete:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
        }

        /* Table */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
        }

        .table-custom tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr {
            transition: var(--transition-smooth);
        }

        .table-custom tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
        }

        /* Search Input */
        .search-input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            transition: var(--transition-smooth);
            background: #f8fafc;
        }

        .search-input:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.25rem 1.5rem;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border: none;
            padding: 1rem 1.5rem 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .form-control-custom {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: var(--transition-smooth);
        }

        .form-control-custom:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        /* Badge */
        .badge-custom {
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Alert */
        .alert-custom {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(21, 128, 61, 0.1) 100%);
            color: #166534;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        }

        .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stats-icon-primary {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            color: #667eea;
        }

        .stats-icon-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(21, 128, 61, 0.15) 100%);
            color: #22c55e;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1d29;
            line-height: 1;
        }

        .stats-label {
            color: #64748b;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Pagination */
        .pagination {
            gap: 4px;
        }

        .page-link {
            border: none;
            border-radius: 10px;
            padding: 0.5rem 0.875rem;
            color: #475569;
            transition: var(--transition-smooth);
        }

        .page-link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .page-item.active .page-link {
            background: var(--primary-gradient);
            color: white;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Loading State */
        [wire\:loading] {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>

    @livewireStyles
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/admin') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div>
                    <div class="sidebar-brand-text">AGENDA</div>
                    <div class="sidebar-brand-subtitle">BAPPEDA</div>
                </div>
            </a>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Menu Utama</div>
            </div>
            
            <a href="{{ url('/admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ url('/admin/agenda') }}" class="nav-link {{ request()->is('admin/agenda*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Agenda</span>
            </a>
            
            <a href="{{ url('/admin/ruang-rapat') }}" class="nav-link {{ request()->is('admin/ruang-rapat*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Ruang Rapat</span>
            </a>
            
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/user-management*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Manajemen User</span>
            </a>

            <!-- <a href="{{ url('/admin/laporan') }}" class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <i class="bi bi-printer"></i>
                <span>Laporan Agenda</span>
            </a> -->

            <div class="nav-section">
                <div class="nav-section-title">Lainnya</div>
            </div>
            
            <a href="{{ url('/') }}" class="nav-link">
                <i class="bi bi-box-arrow-left"></i>
                <span>Kembali ke Website</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="px-3 mt-3">
                @csrf
                <button type="submit" class="btn w-100 text-start nav-link border-0 p-0" style="background: none;">
                    <i class="bi bi-power text-danger"></i>
                    <span class="text-danger">Logout</span>
                </button>
            </form>

            {{-- User Info --}}
            @auth
            <div class="px-3 py-3 mt-3 border-top border-secondary">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-person text-white"></i>
                    </div>
                    <div>
                        <div class="text-white small fw-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-white-50" style="font-size: 0.7rem;">{{ Auth::user()->username }}</div>
                    </div>
                </div>
            </div>
            @endauth
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn d-lg-none" type="button" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h1 class="topbar-title">{{ $title ?? 'Dashboard' }}</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    <i class="bi bi-clock me-1"></i>
                    {{ now()->format('d M Y, H:i') }}
                </span>
            </div>
        </div>

        <div class="content-wrapper">
            {{ $slot }}
        </div>

        <footer class="text-center py-4 text-muted small">
            &copy; Bappeda Kabupaten Wonosobo by <a href="https://github.com/mamasdea" target="_blank" class="text-decoration-none">Mamas Dea</a> 2023 - {{ date('Y') }}
        </footer>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('[onclick="toggleSidebar()"]');
            
            if (window.innerWidth < 992 && 
                !sidebar.contains(e.target) && 
                !toggleBtn.contains(e.target) && 
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    @livewireScripts
</body>
</html>
