<?php

namespace sbwms\Model\Centre\BusinessHours;

class BusinessHoursEntityManager {
    public function createEntity(array $data) {

        if (!isset($data['dataSource'])) exit('data source not set');
        $operatingPeriod = null;

        if ($data['dataSource'] === 'user') {
            $operatingPeriod = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $operatingPeriod = $this->createFromDbRecord($data);
        }

        return $operatingPeriod;
    }

    public function createFromUserData(array $data) {
        return new BusinessHours($data);
    }

    public function createFromDbRecord(array $data) {
        unset($data['dataSource']);
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