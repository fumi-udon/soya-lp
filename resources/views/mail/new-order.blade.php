<x-mail::message>
<div style="color: #c62828; font-weight: 700; font-size: 15px; line-height: 1.55; margin: 0 0 20px 0; padding: 12px 14px; border: 2px solid #c62828; border-radius: 8px; background-color: #ffebee;">
    <p style="margin: 0 0 10px 0;">[未確定オーダーです]</p>
    <p style="margin: 0 0 14px 0;">お客様からの注文をもって、注文を確定してください。</p>
    <p style="margin: 0 0 8px 0; direction: rtl; text-align: right;" dir="rtl" lang="ar">[الطلب مازال مش مؤكّد]</p>
    <p style="margin: 0; direction: rtl; text-align: right;" dir="rtl" lang="ar">ثبّت الأوردر على حساب اللي بعثو الزبون (الكليان).</p>
</div>

# Order request #{{ $order->order_number }}

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
