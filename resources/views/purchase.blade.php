@extends('layouts.app')

@section('content')
<style>
    .purchase-card {
        background: var(--bg-card);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-color);
        border-radius: 24px;
    }

    .item-row {
        background: rgba(0, 0, 0, 0.02);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    [data-bs-theme="dark"] .item-row {
        background: rgba(255, 255, 255, 0.03);
    }

    .item-row:hover {
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .form-control, .form-select {
        background-color: transparent !important;
        border: 2px solid var(--border-color);
        color: var(--text-main) !important;
        border-radius: 12px;
        padding: 0.75rem 1rem;
    }

    .remove-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .remove-btn:hover {
        background: #ef4444;
        color: white;
    }

    .sticky-summary {
        position: sticky;
        bottom: 1.5rem;
        background: #0f172a;
        color: white;
        border-radius: 20px;
        padding: 1.25rem 2.5rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 3rem;
        z-index: 100;
    }
</style>

<div class="container py-5">
    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    {{-- WhatsApp Notification Alert - Integrated --}}
    @if(session('wa_url'))
        <div class="alert shadow-lg border-0 rounded-4 mb-4 p-4 d-flex justify-content-between align-items-center" 
             style="background: rgba(37, 211, 102, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(37, 211, 102, 0.3) !important;">
            <div class="d-flex align-items-center">
                <div class="bg-success p-3 rounded-circle me-3 shadow">
                    <i class="bi bi-whatsapp text-white fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-white">Send Request to Supplier</h6>
                    <p class="small mb-0 opacity-75 text-white">Order recorded. Click to notify the vendor via WhatsApp.</p>
                </div>
            </div>
            <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow-sm">
                Send Message <i class="bi bi-send-fill ms-2"></i>
            </a>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main)">Purchase Order</h2>
            <p class="text-muted mb-0">Record factory restocking with 5% GST calculation.</p>
        </div>
        <div class="bg-primary bg-opacity-10 p-3 rounded-4">
            <i class="bi bi-box-seam-fill text-primary fs-3"></i>
        </div>
    </div>

    <div class="card purchase-card shadow-lg">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('purchase') }}" method="POST" id="purchase-form">
                @csrf
                
                <div class="mb-5">
                    <label class="form-label small fw-bold text-uppercase opacity-75">Select Supplier</label>
                    <select name="supplier_id" class="form-select form-select-lg" required>
                        <option value="" selected disabled>Choose a Registered Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Products to Restock</h5>
                    <button type="button" id="add-row" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-plus-lg me-2"></i> Add Another Item
                    </button>
                </div>

                <div id="purchase-items-container">
                    <div class="row g-3 item-row align-items-start">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold opacity-50">Product</label>
                            <select name="items[0][product_id]" class="form-select product-select" onchange="updateStockInfo(this)" required>
                                <option value="" disabled selected>Select Item</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-current-stock="{{ $product->stock->available_quantity ?? 0 }}">
                                        {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="stock-label text-muted d-block mt-1 ps-1"></small>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold opacity-50">Qty</label>
                            <input type="number" name="items[0][quantity]" class="form-control qty-input" placeholder="0" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold opacity-50">Cost Price (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 text-muted">₹</span>
                                <input type="number" step="0.01" name="items[0][price]" class="form-control price-input border-start-0" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex justify-content-center pt-4">
                            <div style="width: 38px;"></div>
                        </div>
                    </div>
                </div>

                <div class="sticky-summary">
                    <div class="d-flex align-items-center gap-4 text-white">
                        <div>
                            <span class="small text-uppercase fw-bold opacity-75 d-block text-white-50">Subtotal</span>
                            <h5 class="mb-0">₹ <span id="subtotal-display">0.00</span></h5>
                        </div>
                        <div class="border-start border-secondary ps-4">
                            <span class="small text-uppercase fw-bold opacity-75 d-block text-white-50">GST (5%)</span>
                            <h5 class="mb-0">₹ <span id="gst-display">0.00</span></h5>
                        </div>
                        <div class="border-start border-secondary ps-4">
                            <span class="small text-uppercase fw-bold opacity-75 d-block text-white-50">Total Investment</span>
                            <h3 class="fw-bold mb-0">₹ <span id="total-display">0.00</span></h3>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <input type="hidden" name="total_amount" id="subtotal_input" value="0">
                        <input type="hidden" name="gst_amount" id="gst_input" value="0">
                        <input type="hidden" name="grand_total" id="grand_total_input" value="0">
                        
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold shadow">
                            Submit Order <i class="bi bi-check2-all ms-1"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let rowIdx = 1;

    function updateStockInfo(select) {
        const option = select.options[select.selectedIndex];
        const stock = option.getAttribute('data-current-stock');
        const label = select.closest('.col-md-5').querySelector('.stock-label');
        label.innerHTML = `<i class="bi bi-info-circle me-1"></i> Current Stock: <strong>${stock}</strong>`;
    }

    document.getElementById('add-row').addEventListener('click', function() {
        const container = document.getElementById('purchase-items-container');
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${rowIdx}]`);
            input.value = '';
        });

        newRow.querySelector('.stock-label').innerText = '';
        const actionCol = newRow.querySelector('.col-md-1');
        actionCol.innerHTML = `<button type="button" class="remove-btn" onclick="removeRow(this)"><i class="bi bi-trash3-fill"></i></button>`;
        
        container.appendChild(newRow);
        rowIdx++;
    });

    function removeRow(btn) {
        btn.closest('.item-row').remove();
        updateTotal();
    }

    function updateTotal() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            subtotal += (qty * price);
        });

        let gstAmount = subtotal * 0.05;
        let grandTotal = subtotal + gstAmount;
        
        const formatConfig = { minimumFractionDigits: 2, maximumFractionDigits: 2 };

        document.getElementById('subtotal-display').innerText = subtotal.toLocaleString('en-IN', formatConfig);
        document.getElementById('gst-display').innerText = gstAmount.toLocaleString('en-IN', formatConfig);
        document.getElementById('total-display').innerText = grandTotal.toLocaleString('en-IN', formatConfig);
        
        document.getElementById('subtotal_input').value = subtotal.toFixed(2);
        document.getElementById('gst_input').value = gstAmount.toFixed(2);
        document.getElementById('grand_total_input').value = grandTotal.toFixed(2);
    }

    document.getElementById('purchase-form').addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input') || e.target.classList.contains('price-input')) {
            updateTotal();
        }
    });

    document.getElementById('purchase-form').addEventListener('submit', function(e) {
        const btn = document.getElementById('submit-btn');
        if (btn.disabled) {
            e.preventDefault();
            return false;
        }
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span> Processing...`;
    });
</script>
@endsection