@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .customer-avatar {
        width: 45px; height: 45px;
        background: #f0f2f5;
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px; font-weight: bold; color: #0d6efd;
    }
    .btn-action {
        width: 35px; height: 35px;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
</style>

<div class="container-fluid py-5 px-4">
    {{-- Success Alerts --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        {{-- Left Side: Form --}}
        <div class="col-lg-4">
            <div class="card glass-card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4"><i class="bi bi-person-plus me-2 text-primary"></i>New Client</h5>
                    <form action="{{ route('customers') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Dean Winchester" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="+1 555-0123">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="dean@impala67.com">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Side: List --}}
        <div class="col-lg-8">
            <div class="card glass-card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Customer Database <span class="badge bg-light text-primary ms-2">{{ count($customers) }}</span></h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-4">Client</th>
                                <th>Contact</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="customer-avatar me-3">{{ strtoupper(substr($customer->customer_name, 0, 1)) }}</div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $customer->customer_name }}</div>
                                            <small class="text-muted">{{ $customer->email ?? 'No email' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-dark border"><i class="bi bi-telephone me-1"></i> {{ $customer->phone ?? 'N/A' }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <a href="#" class="btn btn-action btn-outline-primary rounded-pill"><i class="bi bi-clock-history"></i></a>
                                        
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Delete {{ $customer->customer_name }}?');" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action btn-outline-danger rounded-pill"><i class="bi bi-trash3"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-5 text-muted">No clients yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection