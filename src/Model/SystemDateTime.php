<?php

namespace sbwms\Model;

use DateInterval;
use DateTimeImmutable;

/**
 * Get the date and time.
 * All system functions that need date and time will use this class.
 * All methods returns immutables.
 */
class SystemDateTime {

    public static function currentDateTime() {
        $hourOffset = 0;
        $minuteOffset = 0;
        $dateTime = new DateTimeImmutable();

        return new DateTimeImmutable();
    }

    public function addToCurrentTime(DateInterval $dateInterval) {
        return $this->currentTime()->add($dateInterval);
    }

}