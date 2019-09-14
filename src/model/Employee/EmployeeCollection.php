<?php

namespace sbwms\Employee;

use sbwms\Employee\Employee;
use sbwms\Service\ServiceType;

class EmployeeCollection {
    
    /** @var array */
    private $employees;

    public function __construct(array $_employees) {
        $this->employees = $_employees;
    }

    public function getAvailableTimes(ServiceType $serviceType, array $dateRange) {

    }

}