<?php

namespace sbwms\Model\Booking;

use sbwms\Model\Vehicle\VehicleMapper;
use sbwms\Model\Service\Type\ServiceTypeMapper;
use sbwms\Model\Booking\BookingMapper;
use sbwms\Model\Booking\Booking;

class BookingRepository {
    private $vehicleMapper;
    private $serviceTypeMapper;
    private $bookingMapper;

    public function __construct(
        VehicleMapper $_vm, ServiceTypeMapper $_sm, BookingMapper $_bm) {
        $this->vehicleMapper = $_vm;
        $this->serviceTypeMapper = $_sm;
        $this->bookingMapper = $_bm;
    }

    public function findById(string $id) {
        $sql = "SELECT * FROM booking WHERE booking_id = :booking_id";
        $bindings = ['booking_id' => $id];
        $booking = $this->bookingMapper->find($bindings, $sql);
        return array_shift($booking);
    }

    /**
     * Find Confirmed and Pending Bookings
     */
    public function findActive() {
        $sql = "SELECT * FROM booking WHERE status = 'confirmed' OR status = 'late' OR status = 'realized' OR status = 'cancelled'";
        $bindings = [];
        $bookings = $this->bookingMapper->find($bindings, $sql);
        return $bookings;
    }

    public function getAllServiceTypes() {
        $serviceTypes = $this->serviceTypeMapper->find();
        return $serviceTypes;
    }

    public function getAllVehicles() {
        $vehicles = $this->vehicleMapper->find();
        return $vehicles;
    }

    public function save(Booking $booking) {
        if ($booking->getBookingId() === null) {
            return $this->bookingMapper->insert($booking);
        }
        return $this->bookingMapper->update($booking);
    }
}