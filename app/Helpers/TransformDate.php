<?php

namespace App\Helpers;

use Jenssegers\Date\Date;

class TransformDate
{
    public static function format($date_to_format)
    {
        $locale = env('APP_LOCALE');

        $timezone = env('APP_TIMEZONE');
        $date = new Date($date_to_format, $timezone);
        $date::setLocale($locale);

        return $date->format('d \d\e F \d\e Y \á\s H:i');
    }
}
