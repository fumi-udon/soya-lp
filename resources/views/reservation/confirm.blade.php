@extends('layouts.soya-app')

@section('title', 'Confirmation | Söya.')

@section('content')
    <div class="rounded-2xl p-4 mb-5 border-2"
         style="background: #fff8e6; border-color: #e60012;">
        <p class="text-sm font-bold" style="color: #e60012;">
            ⚠ Votre réservation n'est pas encore confirmée
        </p>
        <p class="text-xs mt-2 leading-relaxed" style="color: #110A08;">
            Veuillez vérifier les informations ci-dessous, puis appuyez sur «&nbsp;Confirmer la réservation&nbsp;» pour finaliser votre demande.
        </p>
    </div>

    @if (session('error'))
        <div class="rounded-2xl p-4 mb-4 text-sm"
             style="background: #fff0f0; border: 1px solid rgba(230,0,18,0.25); color: #110A08;">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-2xl p-5 mb-5"
         style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
        <p style="font-size: 0.65rem; font-weight: 700; color: #A3B8C9; letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 1rem;">
            Récapitulatif
        </p>

        <dl class="space-y-4 text-sm">
            <div>
                <dt class="soya-label mb-1">Nom</dt>
                <dd style="color: #110A08; font-weight: 600;">{{ $reservation['name'] }}</dd>
            </div>
            <div>
                <dt class="soya-label mb-1">Date</dt>
                <dd style="color: #110A08; font-weight: 600;">{{ $formattedDate }}</dd>
            </div>
            <div>
                <dt class="soya-label mb-1">Heure</dt>
                <dd style="color: #110A08; font-weight: 600;">{{ $reservation['time'] }}</dd>
            </div>
            <div>
                <dt class="soya-label mb-1">Nombre de personnes</dt>
                <dd style="color: #110A08; font-weight: 600;">
                    {{ $reservation['guests'] }} {{ $reservation['guests'] > 1 ? 'personnes' : 'personne' }}
                </dd>
            </div>
        </dl>
    </div>

    <form method="POST" action="{{ route('reservation.store') }}" class="flex flex-col gap-3">
        @csrf
        <button type="submit" class="soya-btn-primary">
            Confirmer la réservation
        </button>
    </form>

    <a href="{{ route('reservation') }}" class="soya-btn-secondary mt-3">
        Modifier
    </a>
@endsection
