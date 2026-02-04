<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/logo/icon bappeda.png') }}" type="image/x-icon">
    <title>{{ $title ?? 'Agenda BAPPEDA' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); /* Blue gradient background matching reference */
            min-height: 100vh;
            color: #fff;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .clock-widget {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 50px;
            padding: 8px 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            font-family: 'Outfit', monospace;
            font-variant-numeric: tabular-nums;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table-custom tr {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .table-custom tr:hover {
            transform: scale(1.01);
        }

        .table-custom td {
            padding: 16px;
            color: #1e293b;
            vertical-align: middle;
        }

        .table-custom td:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            font-weight: bold;
            text-align: center;
            color: #3b82f6;
        }

        .table-custom td:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .section-header {
            background: linear-gradient(90deg, #1e40af 0%, #1d4ed8 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge-time {
            background: #eff6ff;
            color: #2563eb;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        
        footer {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body class="d-flex flex-column">

    <main class="flex-grow-1">
        {{ $slot }}
    </main>

    <footer class="py-3 text-center text-white-50 small glass-panel mt-4 rounded-0 border-0 border-top">
        <div class="container">
            &copy; {{ date('Y') }} Bappeda Kabupaten Wonosobo. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS (Optional if you need JS components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
