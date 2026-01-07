<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum Month: string
{
    case JANUARY = '01';
    case FEBRUARY = '02';
    case MARCH = '03';
    case APRIL = '04';
    case MAY = '05';
    case JUNE = '06';
    case JULY = '07';
    case AUGUST = '08';
    case SEPTEMBER = '09';
    case OCTOBER = '10';
    case NOVEMBER = '11';
    case DECEMBER = '12';

    public static function fromPolishName(string $name): ?self
    {
        $map = [
            'styczeń' => self::JANUARY, 'luty' => self::FEBRUARY, 'marzec' => self::MARCH,
            'kwiecień' => self::APRIL, 'maj' => self::MAY, 'czerwiec' => self::JUNE,
            'lipiec' => self::JULY, 'sierpień' => self::AUGUST, 'wrzesień' => self::SEPTEMBER,
            'październik' => self::OCTOBER, 'listopad' => self::NOVEMBER, 'grudzień' => self::DECEMBER,
        ];

        return $map[mb_strtolower(trim($name))] ?? null;
    }
}
