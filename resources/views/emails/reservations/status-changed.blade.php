@component('mail::message')
# Mise à jour de votre réservation

Bonjour {{ $reservation->nom }},

Nous vous informons que le statut de votre réservation (référence : #{{ $reservation->reference }}) a été mis à jour.

**Nouveau statut :** {{ $statusLabel }}

### Détails de la réservation :
- **Circuit :** {{ $reservation->circuit->titre }}
- **Dates :** Du {{ $reservation->date_debut->format('d/m/Y') }} au {{ $reservation->date_fin->format('d/m/Y') }}
- **Nombre de voyageurs :** {{ $reservation->nombre_personnes }}
- **Montant total :** {{ number_format($reservation->montant_total, 2, ',', ' ') }} €

@if($reservation->statut === 'confirmee')
Votre réservation a été confirmée. Nous vous remercions de votre confiance et nous nous réjouissons de vous accueillir prochainement.
@elseif($reservation->statut === 'en_attente')
Votre réservation est en attente de traitement. Notre équipe reviendra vers vous dans les plus brefs délais.
@elseif($reservation->statut === 'annulee')
Votre réservation a été annulée. Si vous n'êtes pas à l'origine de cette annulation, veuillez nous contacter rapidement.
@elseif($reservation->statut === 'terminee')
Votre séjour est maintenant terminé. Nous espérons que vous avez passé un agréable moment et nous vous remercions de votre confiance.
@endif

@component('mail::button', ['url' => route('reservations.show', $reservation)])
Voir ma réservation
@endcomponent

Pour toute question, n'hésitez pas à nous contacter :
- Par téléphone : +228 XX XX XX XX
- Par email : contact@theelomtours.com

Cordialement,<br>
L'équipe The Elom Tours
@endcomponent