<?php

namespace App\Traits;

trait WithoutAppends
{
    /**
     * @var bool
     */
    public static $without_appends = false;

    /**
     * Check if $without_appends is enabled.
     *
     * @return array
     */
    protected function getArrayableAppends()
    {
        if (self::$without_appends) {
            return [];
        }
        return parent::getArrayableAppends();
    }
}
