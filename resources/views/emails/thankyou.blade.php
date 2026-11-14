<h1>Thank You, {{ $sale->customer->customer_name }}!</h1>
<p>We've successfully processed your order #{{ $sale->id }}.</p>

<h3>Order Summary:</h3>
<ul>
    @foreach($sale->items as $item)
        <li>{{ $item->product->product_name }} - {{ $item->quantity }} x ₹{{ $item->selling_price }}</li>
    @endforeach
</ul>

<p><strong>Total Amount: ₹{{ number_format($sale->total_amount, 2) }}</strong></p>
<p>We appreciate your business!</p>