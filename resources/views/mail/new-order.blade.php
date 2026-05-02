<x-mail::message>
<div style="color: #c62828; font-weight: 700; font-size: 15px; line-height: 1.6; margin: 0 0 20px 0; padding: 12px 14px; border: 2px solid #c62828; border-radius: 8px; background-color: #ffebee; direction: ltr; text-align: left;" lang="tn-Latn">
    <p style="margin: 0 0 10px 0;">[L'ordre mzl mch confirmed]</p>
</div>

# Request #{{ $order->order_number }}

**Guest:** {{ $order->customer_name }}  
**Phone:** {{ $order->customer_phone }}  
**Type:** {{ $order->order_type }}

@if($order->notes)
**Notes:** {{ $order->notes }}

@endif
---

@foreach($lines as $row)
- **{{ $row['line'] }}** — {{ $row['price'] }}
@if($row['kitchen'])
  - *Kitchen label:* {{ $row['kitchen'] }}
@endif
@if($row['extras'])
  - Extras: {{ $row['extras'] }}
@endif

@endforeach

---

**Total:** {{ number_format((float) $order->total_price, 3, '.', '') }} DT

@if($order->is_test)
<x-mail::panel>
This order was flagged as a **test** (customer name).
</x-mail::panel>
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
