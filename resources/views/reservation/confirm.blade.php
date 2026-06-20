@extends('layouts.soya-app')

@section('title', 'Confirmation | Söya.')

@section('content')
    <div class="rounded-xl px-3 py-2 mb-2 border-2"
         style="background: #fff8e6; border-color: #e60012;">
        <p class="text-xs font-bold leading-snug" style="color: #e60012;">
            ⚠ Pas encore confirmé — vérifiez puis appuyez sur Confirmer.
        </p>
    </div>

    @if (session('error'))
        <div class="rounded-xl px-3 py-2.5 mb-3 text-xs"
             style="background: #fff0f0; border: 1px solid rgba(230,0,18,0.25); color: #110A08;">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-xl p-3"
         style="background: #ffffff; border: 1px solid rgba(163,184,201,0.3);">
        <p class="mb-2"
           style="font-size: 0.55rem; font-weight: 700; color: #A3B8C9; letter-spacing: 0.18em; text-transform: uppercase;">
            Récapitulatif
        </p>

        <dl class="soya-recap-grid">
            <div class="soya-recap-item soya-recap-item--full">
                <dt>Nom</dt>
                <dd>{{ $reservation['name'] }}</dd>
            </div>
            <div class="soya-recap-item">
                <dt>Date</dt>
                <dd>{{ $formattedDate }}</dd>
            </div>
            <div class="soya-recap-item">
                <dt>Heure</dt>
                <dd>{{ $reservation['time'] }}</dd>
            </div>
            <div class="soya-recap-item">
                <dt>Personnes</dt>
                <dd>{{ $reservation['guests'] }} {{ $reservation['guests'] > 1 ? 'pers.' : 'pers.' }}</dd>
            </div>
        </dl>
    </div>
@endsection

@section('page-actions')
    <form method="POST" action="{{ route('reservation.store') }}">
        @csrf
        <button type="submit" class="soya-btn-primary">
            Confirmer la réservation
        </button>
    </form>
    <a href="{{ route('reservation') }}" class="soya-btn-secondary" style="margin-top: 0.5rem;">
        Modifier
    </a>
@endsection
