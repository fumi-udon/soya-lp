@extends('layouts.soya-app')

@section('title', 'Réservation confirmée | Söya.')

@section('content')
    <div class="text-center mb-6">
        <div class="mx-auto mb-4 flex items-center justify-center w-16 h-16 rounded-full"
             style="background: rgba(37, 211, 102, 0.15);">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                 fill="none" stroke="#1a9e4a" stroke-width="2.5" stroke-linecap="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; font-weight: 700; color: #110A08;">
            Réservation confirmée
        </h1>
        <p class="mt-2 text-sm leading-relaxed" style="color: #A3B8C9;">
            Merci, {{ $reservation['name'] }}.<br>
            Nous avons bien reçu votre demande de réservation.
        </p>
    </div>

    <div class="rounded-2xl p-5 mb-4"
         style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
        <p style="font-size: 0.65rem; font-weight: 700; color: #A3B8C9; letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 1rem;">
            Détails
        </p>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between gap-4">
                <dt style="color: #A3B8C9;">Réf.</dt>
                <dd style="color: #110A08; font-weight: 600;">{{ $reservation['reservation_id'] }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt style="color: #A3B8C9;">Date</dt>
                <dd style="color: #110A08; font-weight: 600; text-align: right;">{{ $formattedDate }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt style="color: #A3B8C9;">Heure</dt>
                <dd style="color: #110A08; font-weight: 600;">{{ $reservation['time'] }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt style="color: #A3B8C9;">Personnes</dt>
                <dd style="color: #110A08; font-weight: 600;">
                    {{ $reservation['guests'] }} {{ $reservation['guests'] > 1 ? 'personnes' : 'personne' }}
                </dd>
            </div>
        </dl>
    </div>

    <div class="rounded-2xl p-4 mb-4 text-sm leading-relaxed"
         style="background: rgba(163,184,201,0.12); border: 1px solid rgba(163,184,201,0.25); color: #110A08;">
        <p class="font-semibold mb-2">À noter</p>
        <p class="mb-2">
            Nous vous attendons avec plaisir. Merci de venir à l'heure — un retard de plus de 20 minutes entraînera l'annulation automatique de la réservation.
        </p>
        <p>
            Pour toute modification, merci de nous appeler au
            <a href="{{ $accessTelHref }}" style="color: #110A08; font-weight: 700; text-decoration: underline;">
                {{ $accessTelDisplay }}
            </a>.
        </p>
    </div>

    <a href="{{ url('/') }}" class="soya-btn-primary" style="display: block; text-align: center; text-decoration: none;">
        Retour à l'accueil
    </a>
@endsection
