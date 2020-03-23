<?php

namespace sbwms\Model\Service\Type;

use DateInterval;
use sbwms\Model\Service\Type\ServiceType;

class ServiceTypeEntityManager {

    public function createEntity(array $data) {
        if (!isset($data['dataSource'])) exit('data source not set');
        $serviceType = null;

        if ($data['dataSource'] === 'user') {
            $serviceType = $this->createFromUserData($data);
        }
        if ($data['dataSource'] === 'database') {
            $serviceType = $this->createFromDbRecord($data);
        }
        return $serviceType;
    }

    public function createFromUserData(array $data) {
        $data['duration'] = $data['hours'] . $data['minutes'];
        unset($data['hours'], $data['minutes']);
        $arguments = [
            'serviceTypeId' => $data['serviceTypeId'] ?? null,
            'name' => $data['name'],
            'status' => $data['status'],
            'duration' => (new DateInterval('PT'.$data['duration'])),
        ];
        $serviceType = new ServiceType($arguments);
        return $serviceType;
    }

    public function createFromDbRecord(array $data) {
        $arguments = [
            'serviceTypeId' => $data['service_type_id'],
            'name' => $data['name'],
            'status' => $data['status'],
            'duration' => (new DateInterval('PT'.$data['estimated_duration'])),
        ];
        $serviceType = new ServiceType($arguments);
        return $serviceType;
    }
}