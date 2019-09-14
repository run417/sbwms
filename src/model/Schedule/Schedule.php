<?php

namespace sbwms\Schedule;

use sbwms\Service\ServiceType;

class Schedule {

    /** @var array Collection of Entry instances */
    private $schedule;

    public function __construct(array $entries) {
        $this->schedule = $entries;
    }

    
    public function getAvailableTimes(ServiceType $serviceType) {
        
    }
}