<?php

namespace sbwms\Model\Service\Bay;

use sbwms\Model\Service\Bay\Bay;

class BayEntityManager {
    public function createEntity($data) {
        if (!isset($data['dataSource'])) exit('data source not set');

        $bay = null;

        if ($data['dataSource'] === 'user') {
            $bay = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $bay = $this->createFromDbRecord($data);
        }

        return $bay;
    }

    private function createFromUserData(array $data) {
        $arguments = [
            'bayId' => $data['bayId'] ?? null,
            'bayType' => $data['bayType'],
            'bayStatus' => $data['bayStatus'],
        ];
        return new Bay($arguments);
    }

    private function createFromDbRecord(array $data) {
        $arguments = [
            'bayId' => $data['bay_id'],
            'bayType' => $data['bay_type'],
            'bayStatus' => $data['bay_status'],
        ];
        return new Bay($arguments);
    }
}