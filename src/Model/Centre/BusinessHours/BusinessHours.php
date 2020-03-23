<?php

namespace sbwms\Model\Centre\BusinessHours;

/**
 * The working days of the week and opening and closing times of the
 * service centre.
 */
class BusinessHours {

    const DAYS_OF_WEEK = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    // private $workingDays;
    private $dayTimes;

    public function __construct(array $_dt) {
        $this->dayTimes = $this->setDayTimes($_dt);
    }

    private function setDayTimes($d) {
        foreach (self::DAYS_OF_WEEK as $day) {
            if (!isset($d['day'][$day])) {
                unset($d['open'][$day], $d['close'][$day]);
            }
        }
        unset($d['day']['default'], $d['open']['default'], $d['close']['default']);
        return $d;
    }

    public function isWorkingDay(string $day) {
        return \in_array($day, $this->getWorkingDays());
    }

    public function getOpen(string $day) {
        if (\in_array($day, $this->getWorkingDays())) {
            return $this->dayTimes['open'][$day];
        } else {
            return null;
        }
    }

    public function getClose(string $day) {
        if (\in_array($day, $this->getWorkingDays())) {
            return $this->dayTimes['close'][$day];
        } else {
            return null;
        }
    }

    public function getWorkingDays() {
        if (isset($this->dayTimes['day'])) {
            return array_keys($this->dayTimes['day']);
        } else {
            return [];
        }
    }
}
