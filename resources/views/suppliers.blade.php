@extends('layouts.app')

@section('content')
<style>
    /* UI Variables for Consistency */
    :root {
        --bg-card: rgba(255, 255, 255, 0.95);
        --border-color: rgba(0, 0, 0, 0.08);
        --primary: #6366f1;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    .glass-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.05) !important;
    }

    .form-control {
        background-color: transparent !important;
        border: 2px solid var(--border-color);
        color: var(--text-main) !important;
        border-radius: 12px;
        padding: 0.75rem 1rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .supplier-table thead {
        background: rgba(0, 0, 0, 0.02);
    }

    .supplier-table th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: var(--text-muted);
        border-bottom: 2px solid var(--border-color);
        padding: 1.25rem;
    }

    .supplier-table td {
        padding: 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .action-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: 0.2s;
    }

    .btn-add-purchase {
        background: #0f172a;
        color: white;
        border-radius: 14px;
        padding: 0.8rem 1.5rem;
        transition: 0.3s;
        border: none;
    }

    .btn-add-purchase:hover {
        background: #1e293b;
        transform: translateY(-2px);
        color: white;
    }

    .supplier-icon {
        width: 45px;
        height: 45px;
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>

<div class="container py-5">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main)">Supplier Directory</h2>
            <p class="text-muted mb-0">Manage your product sources and contact details.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('purchase') }}" class="btn btn-add-purchase shadow-sm">
                <i class="bi bi-cart-plus me-2"></i>New Purchase
            </a>
        </div>
    </div>

    {{-- Session Feedback --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
        </div>
    @endif

    <div class="row g-4">
        {{-- Left Side: Registration Form --}}
        <div class="col-lg-4">
            <div class="card glass-card shadow-lg border-0">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Register Supplier</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('suppliers') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold opacity-75">Company Name</label>
                            <input type="text" name="supplier_name" class="form-control" placeholder="Global Tech Industries" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold opacity-75">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted">+91</span>
                                <input type="text" name="phone" class="form-control border-start-0" placeholder="98765 43210" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold opacity-75">Primary Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Headquarters address..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm">
                            Add to Directory
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Side: Supplier List --}}
        <div class="col-lg-8">
            <div class="card glass-card shadow-lg border-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table supplier-table mb-0">
                        <thead>
                            <tr>
                                <th>Supplier Identity</th>
                                <th>Contact</th>
                                <th>Location</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="supplier-icon me-3">
                                            <i class="bi bi-building fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block text-dark">{{ $supplier->supplier_name }}</span>
                                            <small class="text-muted">ID: #SUP-{{ $supplier->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                        <i class="bi bi-telephone me-1 text-primary"></i> {{ $supplier->phone }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted d-inline-block text-truncate" style="max-width: 150px;">
                                        {{ $supplier->address ?? 'No address listed' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    {{-- Delete Supplier Form --}}
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" 
                                          onsubmit="return confirm('Remove {{ $supplier->supplier_name }}? All purchase records for this supplier will be affected.');" 
                                          class="m-0 d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn btn-outline-danger btn-sm border-0" title="Remove Supplier">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="Empty" style="width: 80px; opacity: 0.3;">
                                    <p class="text-muted mt-3 fw-medium">Your supplier directory is empty.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection