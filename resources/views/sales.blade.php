@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Transaction Failed</h6>
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        :root {
            --bg-card: rgba(255, 255, 255, 0.95);
            --border-color: rgba(0, 0, 0, 0.08);
            --primary: #6366f1;
            --text-main: #1e293b;
        }

        .sales-card {
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
        }

        .sticky-summary {
            position: sticky;
            bottom: 1.5rem;
            background: #0f172a;
            color: white;
            border-radius: 20px;
            padding: 1.25rem 2.5rem;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 3rem;
            z-index: 100;
        }

        .stock-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 5px;
            margin-top: 5px;
            display: inline-block;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main)">New Sale Transaction</h2>
            <p class="text-muted mb-0">GST (5%) is calculated automatically on the subtotal.</p>
        </div>
        <div class="bg-primary bg-opacity-10 p-3 rounded-4">
            <i class="bi bi-receipt text-primary fs-3"></i>
        </div>
    </div>

    <div class="card sales-card shadow-lg">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('sales.store') }}" method="POST" id="sales-form">
                @csrf
                
                <div class="mb-5">
                    <label class="form-label small fw-bold text-uppercase opacity-75">Customer Details</label>
                    <select name="customer_id" class="form-select form-select-lg" required>
                        <option value="" disabled selected>Select a customer...</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->customer_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Line Items</h5>
                    <button type="button" id="add-row" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                        <i class="bi bi-plus-lg me-2"></i> Add Item
                    </button>
                </div>

                <div id="item-list">
                    <div class="row g-3 item-row align-items-start">
                        <div class="col-md-5">
                            <label class="form-label small fw-bold opacity-50">Product</label>
                            <select name="items[0][id]" class="form-select product-select" onchange="checkStock(this)" required>
                                <option value="" disabled selected>Select Item</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" 
                                            data-price="{{ $p->price }}" 
                                            data-stock="{{ $p->stock->available_quantity ?? 0 }}">
                                        {{ $p->product_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="stock-info mt-1"></div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold opacity-50">Qty</label>
                            <input type="number" name="items[0][qty]" class="form-control qty-input" 
                                   placeholder="0" min="1" oninput="validateQty(this)" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold opacity-50">Selling Price (₹)</label>
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

                {{-- Updated Sticky Footer Summary with GST --}}
                <div class="sticky-summary">
                    <div class="d-flex align-items-center gap-4">
                        <div>
                            <span class="small text-uppercase fw-bold opacity-75 d-block text-white-50">Subtotal</span>
                            <h5 class="mb-0 text-white">₹ <span id="subtotal-display">0.00</span></h5>
                        </div>
                        <div class="border-start border-secondary ps-4">
                            <span class="small text-uppercase fw-bold opacity-75 d-block text-white-50">GST (5%)</span>
                            <h5 class="mb-0 text-white">₹ <span id="gst-display">0.00</span></h5>
                        </div>
                        <div class="border-start border-secondary ps-4">
                            <span class="small text-uppercase fw-bold opacity-75 d-block text-white-50">Total Payable</span>
                            <h3 class="fw-bold mb-0 text-white">₹ <span id="total-display">0.00</span></h3>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <input type="hidden" name="total_amount" id="subtotal_input" value="0">
                        <input type="hidden" name="gst_amount" id="gst_input" value="0">
                        <input type="hidden" name="grand_total" id="grand_total_input" value="0">
                        
                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold shadow">
                            Finish Sale <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let rowIdx = 1;

    function checkStock(select) {
        const option = select.options[select.selectedIndex];
        const stock = parseInt(option.getAttribute('data-stock'));
        const price = option.getAttribute('data-price');
        const row = select.closest('.item-row');
        
        row.querySelector('.price-input').value = price;
        
        const infoDiv = row.querySelector('.stock-info');
        if (stock <= 5) {
            infoDiv.innerHTML = `<span class="stock-badge bg-danger bg-opacity-10 text-danger">Low Stock: ${stock} left</span>`;
        } else {
            infoDiv.innerHTML = `<span class="stock-badge bg-success bg-opacity-10 text-success">In Stock: ${stock}</span>`;
        }
        
        row.querySelector('.qty-input').setAttribute('max', stock);
        updateTotal();
    }

    function validateQty(input) {
        const max = parseInt(input.getAttribute('max')) || 0;
        const val = parseInt(input.value) || 0;
        
        if (val > max) {
            input.classList.add('is-invalid');
            input.value = max;
            alert(`Cannot exceed available stock (${max})`);
        } else {
            input.classList.remove('is-invalid');
        }
        updateTotal();
    }

    document.getElementById('add-row').addEventListener('click', function() {
        const container = document.getElementById('item-list');
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelectorAll('input, select').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${rowIdx}]`);
            input.value = '';
            input.classList.remove('is-invalid');
        });
        
        newRow.querySelector('.stock-info').innerHTML = '';
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

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('price-input')) {
            updateTotal();
        }
    });
</script>
@endsection