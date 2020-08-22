<?php

namespace sbwms\Model\Centre\BusinessHours;

class BusinessHoursEntityManager {
    public function createEntity(array $data) {

        if (!isset($data['_origin'])) exit('data source not set');
        $operatingPeriod = null;

        if ($data['_origin'] === 'user') {
            $operatingPeriod = $this->createFromUserData($data);
        }

        if ($data['_origin'] === 'database') {
            $operatingPeriod = $this->createFromDbRecord($data);
        }

        return $operatingPeriod;
    }

    public function createFromUserData(array $data) {
        return new BusinessHours($data);
    }

    public function createFromDbRecord(array $data) {
        unset($data['_origin']);
        $args = [];
        foreach ($data as $d) {
            $day = $d['day'];
            $args['day'][$day] = 'on'; // same as user checkbox
            $args['open'][$day] = $d['opening'];
            $args['close'][$day] = $d['closing'];
        }
        if (empty($data)) {
            $args = ['day' => [], 'open' => [], 'close' => []];
        }
        return new BusinessHours($args);
    }
}
