<?php

namespace Tests\Unit;

use App\Support\ReservationSlots;
use PHPUnit\Framework\TestCase;

class ReservationSlotsTest extends TestCase
{
    public function test_allowed_times_are_thirty_minute_increments_within_service_hours(): void
    {
        $slots = ReservationSlots::allowedTimes();

        $this->assertSame([
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30',
        ], $slots);
    }
}
