<?php

namespace sbwms\Model\Booking;

use DateTimeImmutable;
use sbwms\Model\Vehicle\VehicleRepository;
use sbwms\Model\Service\Type\ServiceTypeRepository;
use sbwms\Model\Employee\EmployeeRepository;
use sbwms\Model\Booking\Booking;

/**
 * Creates Booking Entity object
 */
class BookingEntityManager {

    private $vehicleRepository;
    private $employeeRepository;
    private $serviceTypeRepository;

    public function __construct(
        VehicleRepository $_vr,
        EmployeeRepository $_er,
        ServiceTypeRepository $_str
    ) {
        $this->vehicleRepository = $_vr;
        $this->employeeRepository = $_er;
        $this->serviceTypeRepository = $_str;
    }

    /**
     * Create Booking instance
     */
    public function createEntity(array $data) {
        if (!isset($data['_origin'])) exit('data source not set');

        $booking = null;

        if ($data['_origin'] === 'user') {
            $booking = $this->createFromUserData($data);
        }

        if ($data['_origin'] === 'database') {
            $booking = $this->createFromDbRecord($data);
        }

        return $booking;
    }

    private function createFromUserData(array $data) {
        $vehicle = $this->vehicleRepository->findById($data['vehicle']);
        $employee = $this->employeeRepository->findById($data['employeeId']);
        $serviceType = $this->serviceTypeRepository->findById($data['serviceType']);
        $dateTime = DateTimeImmutable::createFromFormat('YmdHi', $data['timeSlot']);

        $booking = new Booking($vehicle, $employee, $dateTime, $serviceType);
        return $booking;
    }

    private function createFromDbRecord(array $data) {
        // create booking entity from db record
        $vehicle = $this->vehicleRepository->findById($data['vehicle_id']);
        $employee = $this->employeeRepository->findById($data['employee_id']);
        $serviceType = $this->serviceTypeRepository->findById($data['service_type_id']);
        $dateTimeString = $data['date_reserved'] . $data['start_time'];
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-dH:i:s', $dateTimeString);
        $booking = new Booking(
            $vehicle,
            $employee,
            $dateTime,
            $serviceType,
            $data['booking_id'],
            $data['status'],
            $data['date_created']
        );
        return $booking;
    }

    public function getServiceTypes() {
        return $this->serviceTypeRepository->findAllOperational();
    }

    public function getVehicles() {
        return $this->vehicleRepository->findAllActive();
    }
}
