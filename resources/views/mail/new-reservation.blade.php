<x-mail::message>
# New Reservation — SÖYA. Menzah 9

**ID:** {{ $reservationId }}  
**Guest:** {{ $customerName }}  
**Date:** {{ $bookingDate }}  
**Time:** {{ $bookingTime }}  
**Party size:** {{ $partySize }} {{ $partySize > 1 ? 'people' : 'person' }}

---

Please confirm this reservation with the guest.

Thanks,<br>
{{ config('mail.from.name') }}
</x-mail::message>
