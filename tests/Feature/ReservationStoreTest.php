<?php

namespace Tests\Feature;

use App\Mail\NewReservationNotification;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ReservationStoreTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'mail.from.address' => 'soya.menzah9@gmail.com',
            'mail.from_name_reservation' => '[SOYA]',
            'mail.reservation_notification.address' => 'soya.menzah9@gmail.com',
            'mail.reservation_notification.send_enabled' => true,
        ]);
    }

    public function test_reservation_store_sends_mail(): void
    {
        Mail::fake();

        $tomorrow = now()->addDay();
        $dateStr = $tomorrow->format('Y-m-d');

        $response = $this->post('/reservation', [
            'name' => 'Jane Doe',
            'date' => $dateStr,
            'time' => '19:00',
            'guests' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $expectedSubject = sprintf(
            '[SOYA] Jane Doe, 2P, %s, 19h00',
            $tomorrow->format('n/j'),
        );

        Mail::assertSent(NewReservationNotification::class, function (NewReservationNotification $mail) use ($expectedSubject) {
            return $mail->hasTo('soya.menzah9@gmail.com')
                && $mail->customerName === 'Jane Doe'
                && $mail->bookingTime === '19:00'
                && $mail->partySize === 2
                && $mail->envelope()->subject === $expectedSubject;
        });
    }

    public function test_reservation_store_validates_required_fields(): void
    {
        Mail::fake();

        $response = $this->post('/reservation', []);

        $response->assertSessionHasErrors(['name', 'date', 'time', 'guests']);
        Mail::assertNothingSent();
    }
}
