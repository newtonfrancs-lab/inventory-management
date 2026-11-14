<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale IMS | Hybrid Edition</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        /* THEME VARIABLES */
        :root {
            --primary: #c10f05;
            --accent: #c10f05;
            --bg-body: #ffffff;
            --bg-card: #f9fafb;
            --text-main: #111827;
            --text-muted: #4b5563;
            --border-color: #e5e7eb;
            --nav-bg: rgba(255, 255, 255, 0.8);
        }

        [data-bs-theme="dark"] {
            --bg-body: #0a0a0a;
            --bg-card: #171717;
            --text-main: #ffffff;
            --text-muted: #9ca3af;
            --border-color: #262626;
            --nav-bg: rgba(10, 10, 10, 0.8);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-body);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* HERO SECTION */
        .hero {
            padding: 150px 0 80px;
            text-align: center;
            background-image: 
                radial-gradient(at 0% 0%, rgba(193, 15, 5, 0.1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(34, 211, 238, 0.05) 0, transparent 50%);
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 24px;
        }

        /* CUSTOM UIVERSE BUTTON STYLES */
        .uiverse-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
        
        .type--A {
            --line_color: #555555;
            --back_color: #ffecf6;
        }

        .type--B {
            --line_color: #1b1919;
            --back_color: #e9ecff;
        }

        .type--C {
            --line_color: var(--primary);
            --back_color: #0a0a0a;
        }

        .uiverse-btn {
            position: relative;
            z-index: 0;
            width: 240px;
            height: 56px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            color: var(--line_color);
            letter-spacing: 2px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .button__text {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .uiverse-btn::before, .uiverse-btn::after, .button__text::before, .button__text::after {
            content: "";
            position: absolute;
            height: 3px;
            border-radius: 2px;
            background: var(--line_color);
            transition: all 0.5s ease;
        }

        .uiverse-btn::before { top: 0; left: 54px; width: calc(100% - 56px * 2 - 16px); }
        .uiverse-btn::after { top: 0; right: 54px; width: 8px; }
        .button__text::before { bottom: 0; right: 54px; width: calc(100% - 56px * 2 - 16px); }
        .button__text::after { bottom: 0; left: 54px; width: 8px; }

        .button__line {
            position: absolute;
            top: 0;
            width: 56px;
            height: 100%;
            overflow: hidden;
        }

        .button__line::before {
            content: "";
            position: absolute;
            top: 0;
            width: 150%;
            height: 100%;
            box-sizing: border-box;
            border-radius: 300px;
            border: solid 3px var(--line_color);
        }

        .button__line:nth-child(1), .button__line:nth-child(1)::before { left: 0; }
        .button__line:nth-child(2), .button__line:nth-child(2)::before { right: 0; }

        .uiverse-btn:hover { letter-spacing: 6px; color: var(--line_color); }
        .uiverse-btn:hover::before, .uiverse-btn:hover .button__text::before { width: 8px; }
        .uiverse-btn:hover::after, .uiverse-btn:hover .button__text::after { width: calc(100% - 56px * 2 - 16px); }

        .button__drow1, .button__drow2 {
            position: absolute;
            z-index: -1;
            border-radius: 16px;
            transform-origin: 16px 16px;
            background: var(--back_color);
        }

        .button__drow1 { top: -16px; left: 40px; width: 32px; height: 0; transform: rotate(30deg); }
        .button__drow2 { top: 44px; left: 77px; width: 32px; height: 0; transform: rotate(-127deg); }

        .button__drow1::before, .button__drow1::after, .button__drow2::before, .button__drow2::after {
            content: "";
            position: absolute;
            background: var(--back_color);
        }

        .button__drow1::before { bottom: 0; left: 0; width: 0; height: 32px; border-radius: 16px; transform-origin: 16px 16px; transform: rotate(-60deg); }
        .button__drow1::after { top: -10px; left: 45px; width: 0; height: 32px; border-radius: 16px; transform-origin: 16px 16px; transform: rotate(69deg); }
        .button__drow2::before { bottom: 0; left: 0; width: 0; height: 32px; border-radius: 16px; transform-origin: 16px 16px; transform: rotate(-146deg); }
        .button__drow2::after { bottom: 26px; left: -40px; width: 0; height: 32px; border-radius: 16px; transform-origin: 16px 16px; transform: rotate(-262deg); }

        .uiverse-btn:hover .button__drow1 { animation: drow1 ease-in 0.06s forwards; }
        .uiverse-btn:hover .button__drow1::before { animation: drow2 linear 0.08s 0.06s forwards; }
        .uiverse-btn:hover .button__drow1::after { animation: drow3 linear 0.03s 0.14s forwards; }
        .uiverse-btn:hover .button__drow2 { animation: drow4 linear 0.06s 0.2s forwards; }
        .uiverse-btn:hover .button__drow2::before { animation: drow3 linear 0.03s 0.26s forwards; }
        .uiverse-btn:hover .button__drow2::after { animation: drow5 linear 0.06s 0.32s forwards; }

        @keyframes drow1 { 0% { height: 0; } 100% { height: 100px; } }
        @keyframes drow2 { 0% { width: 0; opacity: 0; } 10% { opacity: 0; } 11% { opacity: 1; } 100% { width: 120px; } }
        @keyframes drow3 { 0% { width: 0; } 100% { width: 80px; } }
        @keyframes drow4 { 0% { height: 0; } 100% { height: 120px; } }
        @keyframes drow5 { 0% { width: 0; } 100% { width: 124px; } }

        /* General UI components */
        #theme-toggle { cursor: pointer; padding: 8px; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--text-main); transition: all 0.3s ease; }
        #theme-toggle:hover { transform: rotate(15deg) scale(1.1); background: var(--primary); color: white; }
        .feature-card { background: var(--bg-card); border: 1px solid var(--border-color); padding: 40px; border-radius: 24px; height: 100%; transition: transform 0.3s ease; }
        .feature-card:hover { transform: translateY(-10px); border-color: var(--primary); }
        .navbar { background: var(--nav-bg) !important; backdrop-filter: blur(15px); border-bottom: 1px solid var(--border-color); }
    </style>
</head>
<body data-bs-theme="dark">
    
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center" href="#" style="color: var(--text-main)">
                <i class="bi bi-box-seam-fill text-primary me-2"></i>IntelliStock
            </a>
            
            <div class="ms-auto d-flex align-items-center gap-3">
                <button id="theme-toggle" onclick="toggleTheme()" title="Switch Mode">
                    <i class="bi bi-moon-stars-fill" id="theme-icon"></i>
                </button>
                <a href="{{ route('contact') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Contact Us</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1 class="hero-title">Master Your <br>Inventory Flow.</h1>
            <p class="fs-5 mb-4 opacity-75 mx-auto" style="max-width: 600px;">
                The high-performance workspace for wholesale distribution and sales analytics.
            </p>

            <div class="uiverse-wrapper">
                <a href="{{ route('dashboard') }}" class="uiverse-btn type--C">
                    <div class="button__line"></div>
                    <div class="button__line"></div>
                    <span class="button__text">GET STARTED</span>
                    <div class="button__drow1"></div>
                    <div class="button__drow2"></div>
                </a>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="bi bi-lightning-charge text-primary fs-1"></i>
                    <h4 class="mt-3 fw-bold">Ultra Fast</h4>
                    <p class="opacity-75">Optimized SQL procedures for instant data processing.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="bi bi-shield-check text-primary fs-1"></i>
                    <h4 class="mt-3 fw-bold">Secure</h4>
                    <p class="opacity-75">Role-based access to keep your business data private.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="bi bi-graph-up text-primary fs-1"></i>
                    <h4 class="mt-3 fw-bold">Live Stats</h4>
                    <p class="opacity-75">Real-time profit tracking on every single transaction.</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleTheme() {
            const body = document.body;
            const icon = document.getElementById('theme-icon');
            const isDark = body.getAttribute('data-bs-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            
            body.setAttribute('data-bs-theme', newTheme);
            icon.classList.replace(isDark ? 'bi-moon-stars-fill' : 'bi-sun-fill', isDark ? 'bi-sun-fill' : 'bi-moon-stars-fill');
            localStorage.setItem('theme', newTheme);
        }

        window.onload = () => {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.body.setAttribute('data-bs-theme', savedTheme);
            if(savedTheme === 'light') {
                document.getElementById('theme-icon').classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
            }
        };
    </script>
</body>
</html>