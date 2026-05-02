<x-mail::message>
# New order #{{ $order->order_number }}

**Store:** {{ $tenant->name }}

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
