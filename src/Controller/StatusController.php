<?php

namespace sbwms\Controller;

use sbwms\Model\SystemDateTime;
use PDO;
use DateTimeImmutable;
use DateInterval;
use sbwms\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends BaseController {
    private $request;

    /** @var PDO */
    protected $pdo;

    public function __construct(Request $_r, PDO $_p) {
        $this->request = $_r;
        $this->pdo = $_p;
    }

    public function runStatusChange() {
        $currentDateTime = SystemDateTime::currentDateTime();
        $currentTime = $currentDateTime->format('H:i:s');
        $currentDate = $currentDateTime->format('Y:m:d');

        $bookingUpdateCount = 0;
        $this->pdo->beginTransaction();
        // $sql = "UPDATE service_order INNER JOIN booking ON service_order.booking_id = booking.booking_id SET service_order.service_status = :status WHERE booking.date_reserved = :currentDate AND booking.start_time <= :currentTime AND service_order.service_status = :upcoming";

        // set booking status to late
        $sql = "UPDATE booking SET booking.status = 'late' WHERE booking.date_reserved = :currentDate AND booking.start_time < :currentTime AND booking.status = 'confirmed'";

        $bindings = ['currentDate' => $currentDate, 'currentTime' => $currentTime];

        $stmt = $this->pdo->prepare($sql);
        /** @var \PDOStatement */
        $stmt->execute($bindings);
        $bookingUpdateCount += $stmt->rowCount();

        // set late to cancelled
        $currentTimeMinusTen = $currentDateTime->sub(new DateInterval('PT10M'))->format('H:i:s');
        $sql = "UPDATE booking SET booking.status = 'cancelled' WHERE booking.start_time < :currentTimeMinusTen AND booking.status != 'cancelled' AND booking.status = 'late'";

        $bindings = ['currentTimeMinusTen' => $currentTimeMinusTen];

        $stmt = $this->pdo->prepare($sql);
        /** @var \PDOStatement */
        $stmt->execute($bindings);
        $bookingUpdateCount += $stmt->rowCount();

        $result = $this->pdo->commit();

        $result = [
            'result' => $result,
            'bookings_changed' => $bookingUpdateCount,
            /* 'service_orders_changed' => $serviceUpdateCount, */
        ];
        return new Response(json_encode($result));
    }
}