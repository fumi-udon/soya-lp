<x-mail::message>
# Nouvelle réservation — SÖYA. Menzah 9

**Réf.:** {{ $reservationId }}  
**Client:** {{ $customerName }}  
**Date:** {{ $bookingDate }}  
**Heure:** {{ $bookingTime }}  
**Couverts:** {{ $partySize }} {{ $partySize > 1 ? 'personnes' : 'personne' }}

---

Une nouvelle demande de réservation a bien été reçue.

Merci de préparer l'accueil du client. Nous comptons sur vous pour confirmer la disponibilité de la table.

Bonne journée,<br>
{{ config('mail.from.name') }}
</x-mail::message>
