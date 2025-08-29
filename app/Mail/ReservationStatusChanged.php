<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $statusLabels = [
            'en_attente' => 'En attente',
            'confirmee' => 'Confirmée',
            'annulee' => 'Annulée',
            'terminee' => 'Terminée'
        ];

        return $this->subject('Mise à jour de votre réservation #' . $this->reservation->reference)
            ->markdown('emails.reservations.status-changed', [
                'reservation' => $this->reservation,
                'statusLabel' => $statusLabels[$this->reservation->statut] ?? $this->reservation->statut
            ]);
    }
}