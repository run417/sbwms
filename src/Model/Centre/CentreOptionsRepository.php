<?php

namespace sbwms\Model\Centre;

use sbwms\Model\Centre\BusinessHours\BusinessHours;
use sbwms\Model\Centre\BusinessHours\BusinessHoursMapper;

class CentreOptionsRepository {
    private $oPMapper;

    public function __construct(BusinessHoursMapper $_op) {
        $this->oPMapper = $_op;
    }

    public function getBusinessHours() {
        $sql = "SELECT * FROM operating_period";
        $operatingPeriod = $this->oPMapper->find([], $sql);
        return $operatingPeriod;
    }

    public function save($ob) {
        if ($ob instanceof BusinessHours) {
            return $this->oPMapper->update($ob);
        }
        exit('Cannot handle this object type');
    }
}