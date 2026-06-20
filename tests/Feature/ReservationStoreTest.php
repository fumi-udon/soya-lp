<?php

namespace Tests\Feature;

use App\Mail\NewReservationNotification;
use App\Support\ReservationSlots;
use Carbon\Carbon;
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

    public function test_reservation_flow_sends_mail_and_shows_complete_page(): void
    {
        Mail::fake();

        $bookableDate = $this->bookableDate();
        $payload = [
            'name' => 'Jane Doe',
            'date' => $bookableDate->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
        ];

        $this->post('/reservation/confirm', $payload)
            ->assertRedirect(route('reservation.confirm'));

        $this->get(route('reservation.confirm'))
            ->assertOk()
            ->assertSee('pas encore confirmée')
            ->assertSee('Jane Doe');

        $this->post('/reservation')
            ->assertRedirect(route('reservation.complete'));

        $expectedSubject = sprintf(
            '[SOYA] Jane Doe, 2P, %s, 19h00',
            $bookableDate->format('n/j'),
        );

        Mail::assertSent(NewReservationNotification::class, function (NewReservationNotification $mail) use ($expectedSubject) {
            return $mail->hasTo('soya.menzah9@gmail.com')
                && $mail->customerName === 'Jane Doe'
                && $mail->bookingTime === '19:00'
                && $mail->partySize === 2
                && $mail->envelope()->subject === $expectedSubject;
        });

        $this->get(route('reservation.complete'))
            ->assertOk()
            ->assertSee('Réservation confirmée')
            ->assertSee('Jane Doe')
            ->assertSee('20 minutes');

        $this->get(route('reservation.complete'))
            ->assertRedirect(route('reservation'));
    }

    public function test_reservation_confirm_validates_required_fields(): void
    {
        Mail::fake();

        $response = $this->post('/reservation/confirm', []);

        $response->assertRedirect(route('reservation'));
        $response->assertSessionHasErrors(['name', 'date', 'time', 'guests']);
        Mail::assertNothingSent();
    }

    public function test_reservation_store_requires_pending_session(): void
    {
        Mail::fake();

        $this->post('/reservation')
            ->assertRedirect(route('reservation'));

        Mail::assertNothingSent();
    }

    public function test_reservation_store_rejects_sunday(): void
    {
        Mail::fake();

        $sunday = Carbon::now()->next(Carbon::SUNDAY);
        if ($sunday->gt(now()->addDays(7))) {
            $this->markTestSkipped('No Sunday within the 7-day booking window.');
        }

        $response = $this->post('/reservation/confirm', [
            'name' => 'Jane Doe',
            'date' => $sunday->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
        ]);

        $response->assertSessionHasErrors('date');
        Mail::assertNothingSent();
    }

    public function test_reservation_store_rejects_date_beyond_seven_days(): void
    {
        Mail::fake();

        $tooFar = now()->addDays(8);
        while ($tooFar->isSunday()) {
            $tooFar->addDay();
        }

        $response = $this->post('/reservation/confirm', [
            'name' => 'Jane Doe',
            'date' => $tooFar->format('Y-m-d'),
            'time' => '19:00',
            'guests' => 2,
        ]);

        $response->assertSessionHasErrors('date');
        Mail::assertNothingSent();
    }

    public function test_reservation_store_rejects_invalid_time_slot(): void
    {
        Mail::fake();

        $response = $this->post('/reservation/confirm', [
            'name' => 'Jane Doe',
            'date' => $this->bookableDate()->format('Y-m-d'),
            'time' => '15:00',
            'guests' => 2,
        ]);

        $response->assertSessionHasErrors('time');
        Mail::assertNothingSent();
    }

    public function test_reservation_slots_include_lunch_and_dinner_windows(): void
    {
        $slots = ReservationSlots::allowedTimes();

        $this->assertContains('12:00', $slots);
        $this->assertContains('14:30', $slots);
        $this->assertContains('18:30', $slots);
        $this->assertContains('21:30', $slots);
        $this->assertNotContains('14:45', $slots);
        $this->assertNotContains('15:00', $slots);
    }

    protected function bookableDate(): Carbon
    {
        $date = now();
        while ($date->isSunday()) {
            $date->addDay();
        }

        return $date;
    }
}
