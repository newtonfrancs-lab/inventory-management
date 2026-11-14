@extends('layouts.app')

@section('content')
<style>
    /* Premium Layout Enhancements */
    .product-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        transition: all 0.3s ease;
    }
    
    .form-control, .form-select {
        background-color: transparent !important;
        border: 2px solid var(--border-color);
        color: var(--text-main) !important;
        padding: 12px 16px;
        border-radius: 12px;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .valuation-box {
        background: rgba(99, 102, 241, 0.05);
        border: 1px dashed var(--primary);
        border-radius: 16px;
        padding: 20px;
    }

    .form-label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.8;
        color: var(--text-main);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <h2 class="fw-bold mb-1" style="color: var(--text-main)">Register New Product</h2>
                <p class="text-muted">Fill in the details below to add stock to your inventory.</p>
            </div>

            <div class="card product-card shadow-lg">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Validation Alerts --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 mb-4 d-flex align-items-center">
                            <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
                            <ul class="mb-0 small fw-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control form-control-lg" placeholder="e.g. Premium Grade Steel" required>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Unit Price (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 text-muted">₹</span>
                                    <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control form-control-lg border-start-0" placeholder="0.00" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Classification</label>
                                <select name="category_id" class="form-select form-select-lg" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Initial Quantity (Opening Stock)</label>
                            <input type="number" name="opening_stock" id="opening_stock" class="form-control form-control-lg" placeholder="0" min="0" required>
                        </div>

                        <div class="valuation-box mb-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small d-block mb-1">Calculated Inventory Value</span>
                                    <h3 class="fw-bold mb-0 text-primary">₹ <span id="total_stock_value">0.00</span></h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                    <i class="bi bi-calculator-fill fs-3"></i>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-secondary w-50 rounded-pill fw-bold py-3">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary w-50 rounded-pill fw-bold py-3">
                                <i class="bi bi-check-lg me-2"></i> Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Real-time Calculation Script (Logic Only) --}}
<script>
    const unitPriceInput = document.getElementById('unit_price');
    const stockInput = document.getElementById('opening_stock');
    const totalDisplay = document.getElementById('total_stock_value');

    function calculateTotal() {
        const price = parseFloat(unitPriceInput.value) || 0;
        const stock = parseFloat(stockInput.value) || 0;
        const total = price * stock;
        totalDisplay.innerText = total.toLocaleString(undefined, {
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2
        });
    }

    unitPriceInput.addEventListener('input', calculateTotal);
    stockInput.addEventListener('input', calculateTotal);
</script>
@endsection