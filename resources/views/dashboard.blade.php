@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main)">Executive Dashboard</h2>
            <p class="text-muted mb-0">Real-time inventory and sales tracking.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                <i class="bi bi-calendar3 me-1"></i> {{ date('D, d M Y') }}
            </span>
        </div>
    </div>

    {{-- 1. General Stats Row (Now at the top) --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm" style="background: var(--bg-card); border-left: 5px solid #6366f1 !important; border-radius: 18px;">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold mb-3">Inventory Size</h6>
                    <h3 class="fw-bold mb-0">{{ $totalProducts }} <small class="fs-6 text-muted">SKUs</small></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm" style="background: var(--bg-card); border-left: 5px solid #10b981 !important; border-radius: 18px;">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold mb-3">Total Sales (Gross)</h6>
                    <h3 class="fw-bold mb-0">₹{{ number_format($totalSales, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm" style="background: var(--bg-card); border-left: 5px solid #f59e0b !important; border-radius: 18px;">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small fw-bold mb-3">Total Investment</h6>
                    <h3 class="fw-bold mb-0">₹{{ number_format($totalPurchases, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- 2. Recent Sales Table --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden" style="background: var(--bg-card); border-radius: 20px;">
                <div class="card-header border-0 py-3 d-flex justify-content-between align-items-center" style="background: rgba(0,0,0,0.03)">
                    <h5 class="mb-0 fw-bold" style="color: var(--text-main)">Recent Product Sales</h5>
                    <span class="badge rounded-pill bg-primary px-3">Live Feed</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead style="background: rgba(0,0,0,0.02)">
                            <tr style="color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">
                                <th class="ps-4">Product</th>
                                <th>Qty</th>
                                <th>Revenue (Gross)</th>
                                <th class="pe-4">Net Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salesData as $item)
                            @php
                                $productName = $item->product->product_name ?? 'Deleted Product';
                                $costPrice = $item->product->unit_price ?? 0;
                                
                                $revenue = $item->selling_price * $item->quantity;
                                $tax = $revenue * 0.05;
                                $grossRevenue = $revenue + $tax;
                                
                                $lineProfit = ($item->selling_price - $costPrice) * $item->quantity;
                            @endphp
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold">{{ $productName }}</div>
                                    <div class="text-muted smaller" style="font-size: 0.75rem;">
                                        {{ $item->created_at->format('h:i A') }} • Sale #{{ $item->sale_id }}
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark rounded-pill border">{{ $item->quantity }}</span></td>
                                <td class="fw-semibold">₹{{ number_format($grossRevenue, 2) }}</td>
                                <td class="pe-4 fw-bold {{ $lineProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $lineProfit >= 0 ? '+' : '' }}₹{{ number_format($lineProfit, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">No sales yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- 3. Low Stock Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="background: var(--bg-card); border-radius: 20px;">
                <div class="card-header border-0 py-3 bg-danger bg-opacity-10">
                    <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Critical Inventory</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($lowStockAlerts as $alert)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 bg-transparent">
                            <div>
                                <div class="fw-bold text-dark">{{ $alert->product_name }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($alert->alert_date)->diffForHumans() }}</small>
                            </div>
                            <span class="badge bg-danger rounded-pill">{{ $alert->current_qty }} Left</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-5 text-muted bg-transparent border-0">Inventory levels healthy.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Action Menu --}}
    <div class="d-flex flex-wrap justify-content-center gap-3 mt-5 mb-5">
        <a href="{{ route('sales') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>New Sale
        </a>
        <a href="{{ route('purchase') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill border-2 fw-bold">
            <i class="bi bi-cart-plus me-2"></i>Restock
        </a>
        <a href="{{ route('customers') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill border-2 fw-bold">
             <i class="bi bi-people me-2"></i>Customer Directory
        </a>
        <a href="{{ route('home') }}" class="btn btn-link text-muted text-decoration-none px-4">
            <i class="bi bi-house me-2"></i>Exit
        </a>
    </div>
</div>
@endsection