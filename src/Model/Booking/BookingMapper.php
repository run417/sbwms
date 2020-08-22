<?php

namespace sbwms\Model\Booking;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Booking\Booking;
use sbwms\Model\Booking\BookingEntityManager;


class BookingMapper extends BaseMapper {
    /** @var PDO */
    protected $pdo;
    private $entityManager;
    private $tableName = 'booking';

    public function __construct(PDO $_pdo, BookingEntityManager $_bem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_bem;
    }

    /**
     * Create a Booking instance from an array with Booking class properties
     *
     * @param Vehicle A vehicle instance
     * @param ServiceType A ServiceType instance
     * @param ScheduleEntry A ScheduleEntry instance
     * @param string The booking status 'confirmed' | 'pending'
     * @return Booking An instance of Booking
     */
    public function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }


    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of Booking instances or an empty array
     */
    public function find(array $binding, string $query) {

        $stmt = $this->executeQuery($binding, $query);
        $resultSet = $stmt->fetchAll();

        /* check if no matching records are found */
        if (!is_array($resultSet)) {
            exit('Failure');
        }

        $bookings = [];
        foreach ($resultSet as $record) {
            $record['_origin'] = 'database';
            $bookings[] = $this->createEntity($record);
        }
        return $bookings;
    }

    /**
     * @param Booking
     * @return array
     */
    public function insert(Booking $booking) {
        $bindings = $this->getBindings($booking);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO booking (booking_id, vehicle_id, service_type_id, employee_id, date_reserved, start_time, end_time, status) VALUES (:booking_id, (SELECT vehicle_id FROM vehicle WHERE vehicle_id = :vehicle_id), (SELECT service_type_id FROM service_type WHERE service_type_id = :service_type_id), (SELECT employee_id FROM employee WHERE employee_id = :employee_id), :date_reserved, :start_time, :end_time, :status)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) { // explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['booking_id']];
                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            // you can handle possible concurrency issue
            // (same primary key here too)
            // var_dump($ex->getMessage());
            return (int) $ex->getCode();
        }
    }

    public function update(Booking $booking) {
        $bindings = $this->getBindings($booking);
        try {
            $this->pdo->beginTransaction();
            $sql = sprintf(
                "UPDATE booking SET
                    vehicle_id = (SELECT vehicle_id FROM vehicle WHERE vehicle_id = :vehicle_id),
                    service_type_id =(SELECT service_type_id FROM service_type WHERE service_type_id = :service_type_id),
                    employee_id = (SELECT employee_id FROM employee WHERE employee_id = :employee_id),
                    date_reserved = :date_reserved,
                    start_time = :start_time,
                    end_time = :end_time,
                    status = :status
                WHERE booking_id = :booking_id"
            );
            // $sql = \preg_replace('/\s{2,}/', '', $sql);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();
            if ($result === true) { // explicit checking (don't trust pdo commit)
                return [
                    'result' => $result,
                    'data' => ['id' => $bindings['booking_id']],
                ];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\Throwable $th) {
            $this->pdo->rollBack();
            // you can handle possible concurrency issue
            // (same primary key here too)
            // var_dump($ex->getMessage());
            return (int) $ex->getCode();
        }
    }

    private function getBindings(Booking $booking) {

        $bindings = [
            'booking_id' => $booking->getBookingId() ?? $this->generateBookingId(),
            'vehicle_id' => $booking->getVehicle()->getVehicleId(),
            'service_type_id' => $booking->getServiceType()->getServiceTypeId(),
            'employee_id' => $booking->getEmployee()->getEmployeeId(),
            'date_reserved' => $booking->getStartDateTime()->format('Y-m-d'),
            'start_time' => $booking->getStartDateTime()->format('H:i:s'),
            'end_time' => ($booking->getStartDateTime()->add($booking->getServiceType()->getDuration()))->format('H:i:s'),
            'status' => $booking->getStatus(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key for the Booking table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateBookingId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "B" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
