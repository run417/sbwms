<?php

namespace sbwms\Model\Service\ServiceOrder;

use PDO;
use DateTimeImmutable;
use DateInterval;
use sbwms\Model\BaseMapper;
use sbwms\Model\Booking\Booking;

class ServiceOrderMapper extends BaseMapper {

    protected $pdo;
    private $entityManager;
    private $tableName = 'service_order';

    public function __construct(PDO $_pdo, ServiceOrderEntityManager $_soem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_soem;
    }

    public function createEntity(array $data) {
        $serviceorder = $this->entityManager->createEntity($data);
        return $serviceorder;
    }

    /**
     * Find by id, Find by field, Find all
     */
    public function find(array $bindings = [], string $query = '', array $detailQueries = []) {
        $stmt = $this->executeQuery($bindings, $query);
        $result_set = $stmt->fetchAll();
        /* If result_set is false then its a failure somewhere */
        if (is_bool($result_set) && $result_set === FALSE) {
            // /* TODO */ handle this conveniently
            exit('FetchAll Failure');
        }

        $serviceOrders = [];
        if ($stmt->rowCount() >= 1) {
            foreach ($result_set as $r) {
                $r['_origin'] = 'database';
                if ($detailQueries) {
                    $details = $this->findDetails(['job_card_id' => $r['job_card_id']], $detailQueries);
                    $r = array_merge($r, $details);
                }
                $serviceOrders[] = $this->createEntity($r);
                // $serviceOrders[] = $r;
            }
        }
        return $serviceOrders;
    }

    private function findDetails(array $bindings, array $queries) {
        $resultSet = [];
        foreach ($queries as $key => $query) {
            $stmt = $this->executeQuery($bindings, $query);
            $resultSet[$key] = $stmt->fetchAll();
        }
        return $resultSet;
    }

    public function insert(ServiceOrder $serviceOrder) {
        // exit('in insert service order');
        // insert employee record
        // todo: multiple inserts.
        // for each table prepare the bindings array in a different method.
        // begin the transaction inside try statement
        // make the sql string
        // prepare the string
        // bind the values from the relevant array
        // execute the statement
        // do the same for the other table
        // commit
        // catch if error and rollback
        // note: if all values are strings then you don't need to bind
        // todo: a method to get an sql insert string based on a array.

        $bookingBindings = $this->getBookingBindings($serviceOrder->getBooking());
        $serviceOrderBindings = $this->getServiceOrderBindings($serviceOrder, $bookingBindings['booking_id']);
        $jobCardBindings = $this->getJobCardBindings($serviceOrder, $serviceOrderBindings['service_order_id']);
        $jobCardItemBindings = $this->getJobCardItemBindings($serviceOrder, $jobCardBindings['job_card_id']);
        $serviceTimeBindings = $this->getServiceTimeBindings($serviceOrder, $serviceOrderBindings['service_order_id']);

        // exit(\var_dump($bookingBindings, $serviceOrderBindings, $jobCardBindings, $jobCardItemBindings));

        try {
            $this->pdo->beginTransaction();

            /* CREATE NEW SERVICE ORDER
                todo
                    update booking status

            */

            // to insert into service order
            $sql = "UPDATE booking SET `status` = :status WHERE `booking_id` = :booking_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bookingBindings);

            // to insert into service order
            $sql = "INSERT INTO `service_order` (`service_order_id`, `service_status`, `booking_id`) VALUES (:service_order_id, :service_status, (SELECT `booking_id` FROM booking WHERE booking_id = :booking_id))";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($serviceOrderBindings);

            // insert into service time
            $sql = "INSERT INTO `service_time` (`service_start_datetime`, `service_time`, `service_order_id`) VALUES (:service_start_datetime, :service_time, (SELECT `service_order_id` FROM service_order WHERE service_order_id = :service_order_id))";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($serviceTimeBindings);

            // to insert into job card
            $sql = "INSERT INTO `job_card` (`job_card_id`, `service_order_id`, `diagnosis`, `notes`) VALUES (:job_card_id, (SELECT `service_order_id` FROM service_order WHERE service_order_id = :service_order_id), :diagnosis, :notes)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($jobCardBindings);

            // to insert into job items
            $sql = "INSERT INTO `job_card_item` (`job_card_id`, `item_id`, `quantity`) VALUES ((SELECT `job_card_id` FROM job_card WHERE job_card_id = :job_card_id), (SELECT `item_id` FROM item WHERE item_id = :item_id), :quantity)";
            $stmt = $this->pdo->prepare($sql);
            foreach ($jobCardItemBindings as $items) {
                $stmt->execute($items);
            }

            $result = $this->pdo->commit();

            if ($result) {
                $data = ['id' => $bookingBindings['booking_id'], 'name' => 'no name', 'serviceOrderId' => $serviceOrderBindings['service_order_id']];

                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            \var_dump($ex);
        }
    }

    public function update(ServiceOrder $serviceOrder) {
        exit('updating service order not implemented');
        // $empBindings = $this->getEmployeeBindings($employee);
        // $shiftBindings = $this->getShiftBindings($employee);

        // try {
        //     $this->pdo->beginTransaction();
        //     $stmt = $this->pdo->prepare($this->generateUpdateSql('employee', array_keys($empBindings), 'employee_id'));

        //     $result = $stmt->execute($empBindings);
        //     \var_dump($stmt->rowCount());

        //     $stmt = $this->pdo->prepare($this->generateUpdateSql('working_time',array_keys($shiftBindings), 'employee_id'));
        //     // push the foreign key value to execute
        //     $shiftBindings['employee_id'] = $empBindings['employee_id'];
        //     $result = $stmt->execute($shiftBindings);
        //     \var_dump($stmt->rowCount());
        //     $this->pdo->commit();

        // } catch (\Exception $ex) {
        //     $this->pdo->rollBack();
        //     var_dump($ex->getMessage());
        //     exit();
        // }
        // $sql = "UPDATE `employee` SET `first_name` = :first_name, `last_name` = :last_name, `telephone` = :telephone, `email` = :email, `nic` = :nic, `birth_date` = :birth_date, `employee_position_id` = :employee_id, `joined_date` = :joined_date WHERE `employee`.`employee_id` = :employee_id";
        // $sql = "UPDATE `working_time` SET `shift_start` = :shift_start, `shift_end` = :shift_end WHERE `employee_id` = :employee_id";
    }

    /**
     * Extract properties of a Employee object to an php array
     *
     * Used when inserting a record to the database. This method will
     * extract the properties of the Employee object to an assoc array
     * that has the keys o
     *
     * @param Employee An instance of the employee object
     * @return array An array that contain key-value pairs of
     * database table fields and values.
     */
    private function getServiceOrderBindings(ServiceOrder $serviceOrder, string $id) {
        $employeeBindings = [
            'service_order_id' => $serviceOrder->getId() ?? $this->generateServiceOrderId(),
            // 'employee_title' => $employee->getTitle(),
            'service_status' => $serviceOrder->getStatus(),
            'booking_id' => $id,
        ];

        return $employeeBindings;
    }

    private function getServiceTimeBindings(ServiceOrder $serviceOrder, string $id) {
        $bindings = [
            'service_start_datetime' => $serviceOrder->getServiceStart()->format('Y-m-d H:i:s'),
            'service_time' => $serviceOrder->getServiceTime()->format('P%dDT%hH%iM%SS'),
            'service_order_id' => $id,
        ];

        return $bindings;
    }

    private function getJobCardBindings(ServiceOrder $serviceOrder, string $id) {
        $bindings = [
            'job_card_id' => $serviceOrder->getJobCard()->getId() ?? $this->generateJobCardId(),
            'service_order_id' => $id,
            'diagnosis' => $serviceOrder->getJobCard()->getDiagnosis(),
            'notes' => $serviceOrder->getJobCard()->getNotes(),
        ];

        return $bindings;
    }

    private function getJobCardItemBindings(ServiceOrder $serviceOrder, string $id) {
        $bindings = [];
        $items = $serviceOrder->getJobCard()->getItems();
        foreach ($items as $item) {
            $itemBinding = [
                'job_card_id' => $id,
                'item_id' => $item->getId(),
                'quantity' => $item->getQuantity(),
            ];
            $bindings[] = $itemBinding;
        }
        return $bindings;
    }

    private function getBookingBindings(Booking $booking) {
        $bindings = [
            'booking_id' => $booking->getBookingId(),
            'status' => $booking->getStatus(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateServiceOrderId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "SOR" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }

    /**
     * Generate a unique key for the Booking table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateJobCardId() {
        $count = $this->getRowCount('job_card') + 1;
        $id = "JOB" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
