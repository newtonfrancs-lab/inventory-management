@extends('layouts.app')

@section('content')
<style>
    :root {
        /* Premium Crimson to Dark Slate Gradient */
        --primary-gradient: linear-gradient(135deg, #390bd1 0%, #1a1a1a 100%);
        --accent-red: #ff3e33;
    }

    body {
        /* Dark background with subtle red glow to match your hero section */
        background: radial-gradient(circle at top right, rgba(193, 15, 5, 0.15), #0a0a0a 50%);
        background-color: #050505;
        min-height: 100vh;
        color: #ffffff;
    }

    .login-card {
        /* Solid Black with Glass Border */
        background: #111111; 
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .login-title {
        color: #f9f6f6 !important;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .input-group-text {
        background: #1a1a1a;
        border: 1px solid #333;
        border-right: none;
        border-radius: 12px 0 0 12px;
        color: var(--accent-red);
    }

    .login-input {
        background: #1a1a1a;
        border: 1px solid #333;
        border-left: none;
        border-radius: 0 12px 12px 0;
        padding: 0.8rem 1rem;
        color: #ffffff !important;
    }

    .login-input::placeholder {
        color: #666;
    }

    .login-input:focus {
        background: #222;
        border-color: var(--accent-red);
        box-shadow: none;
        color: #ffffff;
    }

    .btn-login {
        background: #ffffff; /* Contrast White Button */
        border: none;
        color: #000000;
        padding: 1rem;
        border-radius: 14px;
        font-weight: 800;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        background: var(--accent-red);
        color: white;
        box-shadow: 0 10px 20px rgba(193, 15, 5, 0.4);
    }

    .brand-logo {
        width: 64px;
        height: 64px;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        margin: 0 auto 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-label {
        color: rgba(204, 201, 201, 0.8);
    }
    
    .text-muted {
        color: #9ca3af !important;
    }
</style>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card login-card p-4 p-md-5">
            <div class="text-center">
                <div class="brand-logo">
                    <i class="bi bi-box-seam-fill text-white fs-2"></i>
                </div>
                <h2 class="login-title mb-1">IntelliStock</h2>
                <p class="text-muted small mb-4">Enter credentials to access the terminal</p>
            </div>

@if ($errors->any())
    <div class="alert alert-danger border-0 bg-danger text-white small mb-4" style="border-radius: 12px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                {{-- Email/Phone --}}
                <div class="mb-3">
                    <label class="form-label small fw-bold">IDENTIFIER</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="login_identity" class="form-control login-input" 
                               placeholder="Email or Phone" required autofocus>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="form-label small fw-bold">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control login-input" 
                               placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input bg-dark border-secondary" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label small text-muted" for="remember">Keep me active</label>
                    </div>
                    <a href="#" class="small text-white fw-bold text-decoration-none opacity-75">Recovery?</a>
                </div>

                <button type="submit" class="btn btn-login w-100 mb-3">
                    Authorize Access <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection