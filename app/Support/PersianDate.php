<?php

namespace App\Support;

use DateTimeInterface;

class PersianDate
{
    public static function date(DateTimeInterface $date, string $separator = '/'): string
    {
        [$year, $month, $day] = self::toJalali(
            (int) $date->format('Y'),
            (int) $date->format('n'),
            (int) $date->format('j'),
        );

        return PersianNumber::digits(sprintf('%04d%s%02d%s%02d', $year, $separator, $month, $separator, $day));
    }

    /**
     * @return array{0: int, 1: int, 2: int}
     */
    private static function toJalali(int $gregorianYear, int $gregorianMonth, int $gregorianDay): array
    {
        $gregorianDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $jalaliDaysInMonth = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

        $gy = $gregorianYear - 1600;
        $gm = $gregorianMonth - 1;
        $gd = $gregorianDay - 1;

        $gregorianDayNumber = 365 * $gy
            + intdiv($gy + 3, 4)
            - intdiv($gy + 99, 100)
            + intdiv($gy + 399, 400);

        for ($i = 0; $i < $gm; $i++) {
            $gregorianDayNumber += $gregorianDaysInMonth[$i];
        }

        if ($gm > 1 && (($gregorianYear % 4 === 0 && $gregorianYear % 100 !== 0) || ($gregorianYear % 400 === 0))) {
            $gregorianDayNumber++;
        }

        $gregorianDayNumber += $gd;
        $jalaliDayNumber = $gregorianDayNumber - 79;
        $jalaliCycle = intdiv($jalaliDayNumber, 12053);
        $jalaliDayNumber %= 12053;

        $jy = 979 + (33 * $jalaliCycle) + (4 * intdiv($jalaliDayNumber, 1461));
        $jalaliDayNumber %= 1461;

        if ($jalaliDayNumber >= 366) {
            $jy += intdiv($jalaliDayNumber - 1, 365);
            $jalaliDayNumber = ($jalaliDayNumber - 1) % 365;
        }

        for ($i = 0; $i < 11 && $jalaliDayNumber >= $jalaliDaysInMonth[$i]; $i++) {
            $jalaliDayNumber -= $jalaliDaysInMonth[$i];
        }

        return [$jy, $i + 1, $jalaliDayNumber + 1];
    }
}
