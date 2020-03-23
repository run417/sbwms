<?php

namespace sbwms\Model\Service\ServiceOrder;

use sbwms\Model\Service\ServiceOrder\ServiceOrder;
use sbwms\Model\Service\ServiceOrder\ServiceOrderMapper;
use sbwms\Model\RecordUpdaterService;
use sbwms\Model\RecordFinderService;

class ServiceOrderRepository {
    private $serviceOrderMapper;
    private $recordUpdaterService;

    public function __construct(
        ServiceOrderMapper $_som,
        RecordUpdaterService $_rus
    ) {
        $this->serviceOrderMapper = $_som;
        $this->recordUpdaterService = $_rus;
    }

    public function findById(string $id) {
        $sql = "SELECT booking.*, service_order.service_order_id, service_status, notes, job_card_id, diagnosis FROM booking LEFT JOIN service_order ON booking.booking_id = service_order.booking_id LEFT JOIN job_card ON service_order.service_order_id = job_card.service_order_id WHERE service_order.service_order_id = :id";
        $detailQueries = [
            'jobCardItems' => "SELECT * FROM job_card_item WHERE job_card_id=:job_card_id",
        ];
        $bindings = ['id' => $id];
        $serviceOrder = $this->serviceOrderMapper->find($bindings, $sql, $detailQueries);
        return array_shift($serviceOrder);
    }

    public function findByBookingId(string $id) {
        $sql = "SELECT booking.*, service_order.service_order_id, service_status, notes, job_card_id, diagnosis FROM booking LEFT JOIN service_order ON booking.booking_id = service_order.booking_id LEFT JOIN job_card ON service_order.service_order_id = job_card.service_order_id WHERE booking.booking_id = :id";
        $detailQueries = [
            'jobCardItems' => "SELECT * FROM job_card_item WHERE job_card_id=:job_card_id",
        ];
        $bindings = ['id' => $id];
        $serviceOrder = $this->serviceOrderMapper->find($bindings, $sql, $detailQueries);
        return array_shift($serviceOrder);
    }

    public function findByStatus(string $status) {
        $sql = "SELECT booking.*, service_order.service_order_id, service_status, notes, job_card_id, diagnosis FROM booking LEFT JOIN service_order ON booking.booking_id = service_order.booking_id LEFT JOIN job_card ON service_order.service_order_id = job_card.service_order_id";

        // if ($status === 'active') {
        //     $sql .= " WHERE service_order.service_status =:ongoing OR service_order.service_status = :on_hold";
        //     $bindings = ['ongoing' => 'ongoing', 'on_hold' => 'on-hold'];
        // } else {
            $sql .= " WHERE service_order.service_status = :service_status";
            $bindings = ['service_status' => $status];
        // }
        $detailQueries = [
            'jobCardItems' => "SELECT * FROM job_card_item WHERE job_card_id=:job_card_id",
        ];
        $serviceOrders = $this->serviceOrderMapper->find($bindings, $sql, $detailQueries);
        return $serviceOrders;
    }

    public function findByDateAndEmployee(string $date, string $employeeId) {
        $sql = "SELECT booking.*, service_order.service_order_id, service_status, notes, job_card_id, diagnosis FROM booking LEFT JOIN service_order ON booking.booking_id = service_order.booking_id LEFT JOIN job_card ON service_order.service_order_id = job_card.service_order_id WHERE service_order.service_status = :service_status";
        $bindings = ['service_status' => 'upcoming'];
        if ($date === 'all' && $employeeId === 'all') {
            $sql .= '';
        } elseif ($date === 'all' && $employeeId) {
            $sql .= " AND booking.employee_id=:employee_id";
            $bindings = ['service_status' => 'upcoming', 'employee_id' => $employeeId];
        } elseif ($date && $employeeId === 'all') {
            $sql .= " AND booking.date_reserved = :date";
            $bindings = ['service_status' => 'upcoming', 'date' => $date];
        } else {
            $sql .= " AND booking.date_reserved = :date AND booking.employee_id=:employee_id";
            $bindings = ['service_status' => 'upcoming', 'date' => $date, 'employee_id' => $employeeId];
        }
        $serviceOrders = $this->serviceOrderMapper->find($bindings, $sql);
        return $serviceOrders;
    }

    /**
     * Find Confirmed and Pending Bookings
     */
    // public function findActive() {
    //     $sql = "SELECT * FROM booking WHERE status = 'confirmed' OR status = 'pending'";
    //     $bindings = [];
    //     $bookings = $this->bookingMapper->find($bindings, $sql);
    //     return $bookings;
    // }

    public function save(ServiceOrder $serviceOrder) {
        if ($serviceOrder->getBooking()->getBookingId() === null) {
            return $this->serviceOrderMapper->insert($serviceOrder);
        }
        return $this->serviceOrderMapper->update($serviceOrder);
    }

    public function holdService(array $data) {
        return $this->recordUpdaterService->holdServiceOrder($data);
    }

    public function startService(array $data) {
        return $this->recordUpdaterService->startServiceOrder($data);
    }
}