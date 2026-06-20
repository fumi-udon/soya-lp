<?php

namespace App\Support;

class ReservationSlots
{
    /**
     * @return list<string> HH:MM slots (30-minute increments)
     */
    public static function allowedTimes(): array
    {
        $slots = [];

        foreach (self::range('12:00', '14:30', 30) as $time) {
            $slots[] = $time;
        }

        foreach (self::range('18:30', '21:30', 30) as $time) {
            $slots[] = $time;
        }

        return $slots;
    }

    /**
     * @return list<string>
     */
    private static function range(string $start, string $end, int $stepMinutes): array
    {
        $slots = [];
        $current = strtotime($start);
        $endAt = strtotime($end);

        while ($current <= $endAt) {
            $slots[] = date('H:i', $current);
            $current = strtotime("+{$stepMinutes} minutes", $current);
        }

        return $slots;
    }
}
