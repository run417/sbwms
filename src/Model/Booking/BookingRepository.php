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
        VehicleMapper $_vm,
        ServiceTypeMapper $_sm,
        BookingMapper $_bm
    ) {
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
    public function findConfirmedAndRealized() {
        $sql = "SELECT * FROM booking WHERE status = 'confirmed' OR status = 'realized'";
        $bindings = [];
        $bookings = $this->bookingMapper->find($bindings, $sql);
        return $bookings;
    }

    public function findByDateAndEmployee(string $date, string $employeeId) {
        $sql = "SELECT booking.* FROM booking WHERE booking.status = 'confirmed'";

        // $sql = "SELECT booking.*, service_order.service_order_id, service_status, notes, job_card_id, diagnosis FROM booking LEFT JOIN service_order ON booking.booking_id = service_order.booking_id LEFT JOIN job_card ON service_order.service_order_id = job_card.service_order_id WHERE service_order.service_status = :service_status";
        $bindings = [];
        if ($date === 'all' && $employeeId === 'all') {
            $sql .= '';
        } elseif ($date === 'all' && $employeeId) {
            $sql .= " AND booking.employee_id=:employee_id";
            $bindings = ['employee_id' => $employeeId];
        } elseif ($date && $employeeId === 'all') {
            $sql .= " AND booking.date_reserved = :date";
            $bindings = ['date' => $date];
        } else {
            $sql .= " AND booking.date_reserved = :date AND booking.employee_id=:employee_id";
            $bindings = ['date' => $date, 'employee_id' => $employeeId];
        }
        $bookings = $this->bookingMapper->find($bindings, $sql);
        return $bookings;
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
