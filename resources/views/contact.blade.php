@extends('layouts.app')

@section('content')
<style>
    .contact-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        overflow: hidden;
    }
    
    .info-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
        border-radius: 12px;
        font-size: 1.5rem;
    }

    .form-control {
        background-color: transparent !important;
        border: 2px solid var(--border-color);
        color: var(--text-main) !important;
        padding: 12px 16px;
        border-radius: 12px;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .map-container {
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        height: 100%;
        min-height: 250px;
    }

    .social-link {
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .social-link:hover {
        transform: translateY(-3px);
        color: #d62976 !important; /* Instagram Pink */
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color: var(--text-main)">Get in Touch</h2>
        <p class="text-muted mx-auto" style="max-width: 500px;">
            Hi, I'm <strong>Newton Vital</strong>. Have questions about the inventory system? I'm here to help you get started.
        </p>
    </div>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4">
                
                {{-- Address --}}
                <div class="d-flex align-items-start gap-3">
                    <div class="info-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: var(--text-main)">Location</h6>
                        <p class="text-muted mb-0">Sao Jose De Areal<br>Goa, India 403709</p>
                    </div>
                </div>

                {{-- Email --}}
                <div class="d-flex align-items-start gap-3">
                    <div class="info-icon">
                        <i class="bi bi-envelope-at-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: var(--text-main)">Email Me Directly</h6>
                        <p class="text-muted mb-0"><a href="mailto:newtonfrancs@gmail.com" class="text-decoration-none text-muted">newtonfrancs@gmail.com</a></p>
                    </div>
                </div>

                {{-- Instagram --}}
                <div class="d-flex align-items-start gap-3">
                    <div class="info-icon">
                        <i class="bi bi-instagram"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1" style="color: var(--text-main)">Follow Me</h6>
                        <p class="mb-0">
                            <a href="https://instagram.com/nxwtxn" target="_blank" class="social-link text-muted">
                                @nxwtxn
                            </a>
                        </p>
                    </div>
                </div>

                {{-- Map --}}
                <div class="map-container mt-2">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d61567.81827415443!2d73.9482811!3d15.3214811!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfb16892e22c9b%3A0xc076757b322f1837!2sSao%20Jose%20De%20Areal%2C%20Goa!5e0!3m2!1sen!2sin!4v1712318000000!5m2!1sen!2sin" 
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card contact-card shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4" style="color: var(--text-main)">Send a Message</h4>
                    
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase opacity-75" style="color: var(--text-main)">Your Name</label>
                                <input type="text" class="form-control" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase opacity-75" style="color: var(--text-main)">Email Address</label>
                                <input type="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase opacity-75" style="color: var(--text-main)">Subject</label>
                                <select class="form-select form-control">
                                    <option selected>General Inquiry</option>
                                    <option>Technical Support</option>
                                    <option>Suggestion</option>
                                    <option>Business Partnership</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-uppercase opacity-75" style="color: var(--text-main)">Message</label>
                                <textarea class="form-control" rows="4" placeholder="How can I help you today?" required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm">
                                    <i class="bi bi-send-fill me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection