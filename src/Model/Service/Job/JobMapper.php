<?php

namespace sbwms\Model\Service\Job;

use PDO;

class JobMapper extends BaseMapper {
    /** @var PDO */
    private $pdo;
    private $tableName = 'service_job';

    public function __construct(PDO $_pdo) {
        $this->pdo = $_pdo;
    }

    public function insert(Job $j) {

    }

    private function getBindings(Job $j) {
        $booking = $j->getBooking();
        $vehicle = $j->getBooking()->getVehicle();

        $bindings = [];
        $bindings['service_job'] = [
            'job_id' => $j->getId() ?? $this->generateId(),
            'service_status' => $j->getStatus(),
            'booking_id' => $j->getBooking()->getId(),
        ];
        $bindings['booking'] = [
            'booking_id' => $booking->getId(),
            'status' => $booking->getStatus(),
        ];
        $bindings['vehicle'] = [
            'vehicle_id' => $vehicle->getId(),
            'status' => $vehicle->getStatus(),
        ];
        return $bindings;
    }

    private function generateId() {
        $bindings = [];
    }
}
