<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale IMS | Premium</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --sidebar-width: 280px;
            --primary-gradient: linear-gradient(135deg, #df412d 0%, #4338ca 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            overflow-x: hidden;
        }

        /* Modern Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: #111827; /* Deep Midnight */
            color: #ffffff;
            transition: all 0.3s;
            z-index: 1000;
            padding: 1.5rem;
        }

        .sidebar-header {
            padding-bottom: 2rem;
            border-bottom: 1px solid #374151;
            margin-bottom: 2rem;
        }

        .nav-link {
            color: #9ca3af;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .nav-link.active {
            background: var(--primary-gradient);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        /* Main Content Area */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        /* Top Navbar Shadow */
        .top-nav {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Modern Cards */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <h4 class="fw-bold mb-0 text-white"><i class="bi bi-box-seam-fill me-2"></i>WS.IMS</h4>
        </div>
        
        <nav class="nav flex-column">
            <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Analytics
            </a>
            <a href="/products" class="nav-link {{ Request::is('products*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> Inventory
            </a>
            <a href="/sales" class="nav-link {{ Request::is('sales*') ? 'active' : '' }}">
                <i class="bi bi-cart-check-fill"></i> Sales
            </a>
            <a href="/suppliers" class="nav-link {{ Request::is('suppliers*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Partners
            </a>
            

<div class="mt-auto pt-5">
    <hr class="text-secondary">
    @auth
        {{-- If logged in, show Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    @else
        {{-- If not logged in, show Login --}}
        <a href="{{ route('login') }}" class="nav-link text-primary">
            <i class="bi bi-shield-lock"></i> Login
        </a>
    @endauth
</div>
        </nav>
    </aside>

    <main class="main-wrapper">
        <header class="top-nav">
            <div class="search-box">
                <span class="text-muted fw-semibold">Overview / {{ ucfirst(Request::segment(1)) }}</span>
            </div>
            <div class="profile-info d-flex align-items-center gap-3">
                <div class="text-end">
                    <p class="mb-0 fw-bold">Admin User</p>
                    <small class="text-muted">General Manager</small>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" class="rounded-circle" width="45">
            </div>
        </header>

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>