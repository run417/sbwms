<?php

namespace sbwms\Employee;

use PDO;
use DateTimeImmutable;
use DateInterval;
use sbwms\Model\BaseMapper;
use sbwms\Model\Employee\Employee;
use sbwms\Model\Employee\Shift;
use sbwms\Model\Employee\Schedule;
use sbwms\Model\Employee\Entry;
use sbwms\Model\Service\Type\ServiceType;

class EmployeeMapper extends BaseMapper{

    protected $pdo;
    private $entityManager;
    private $tableName = 'employee';

    public function __construct(PDO $_pdo, EmployeeEntityManager $_eem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_eem;
    }

    public function createEntity(array $data) {
        $employee = $this->entityManager->createEntity($data);
        return $employee;
    }

    /**
     * Find by id, Find by field, Find all
     */
    public function find(array $bindings=[], string $query='', array $detailQueries=[]) {
        $stmt = $this->executeQuery($bindings, $query);
        $result_set = $stmt->fetchAll();
        /* If result_set is false then its a failure somewhere */
        if (is_bool($result_set) && $result_set === FALSE) {
            // /* TODO */ handle this conveniently
            exit('FetchAll Failure');
        }

        $employees = [];
        if ($stmt->rowCount() >= 1) {
            foreach ($result_set as $r) {
                $r['dataSource'] = 'database';
                if ($detailQueries) {
                    $details = $this->findDetails(['employee_id' => $r['employee_id']], $detailQueries);
                    $r = array_merge($r, $details);
                }
                $employees[] = $this->createEntity($r);
                // $employees[] = ($r);
                // var_dump($employees);
            }
        }
        return $employees;
    }

    private function findDetails(array $bindings, array $queries) {
        $resultSet = [];
        foreach ($queries as $key => $query) {
            $stmt = $this->executeQuery($bindings, $query);
            $resultSet[$key] = $stmt->fetchAll();
        }
        return $resultSet;
    }

    public function insert(Employee $employee) {
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

        $empBindings = $this->getEmployeeBindings($employee);
        $shiftBindings = $this->getShiftBindings($employee);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO employee (`employee_id`, `first_name`, `last_name`, `telephone`, `email`, `nic`, `birth_date`, `employee_position_id`, `joined_date`, `booking_availability`) VALUES (:employee_id, :first_name, :last_name, :telephone, :email, :nic, :birth_date, :employee_position_id, :joined_date, :booking_availability)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($empBindings);

            if ($empBindings['employee_position_id'] == '104') {
                // to insert into working time
                $sql = "INSERT INTO `working_time` (`shift_start`, `shift_end`, `employee_id`) VALUES (:shift_start, :shift_end, (SELECT `employee_id` FROM employee WHERE employee_id = :employee_id))";
                $stmt = $this->pdo->prepare($sql);
                // push the foreign key
                $shiftBindings['employee_id'] = $empBindings['employee_id'];
                $stmt->execute($shiftBindings);

                // // delete service types
                // $sql = "DELETE FROM employee_service_detail WHERE employee_id=:employee_id";
                // $stmt = $this->pdo->prepare($sql);
                // $stmt->execute(['employee_id' => $empBindings['employee_id']]);
                // insert into employee service types
                $bindings = $this->getServiceTypeBindings($employee, $empBindings['employee_id']);
                $sql = "INSERT INTO `employee_service_detail` (`employee_id`, `service_type_id`) VALUES (:employee_id, :service_type_id)";
                $stmt = $this->pdo->prepare($sql);
                foreach ($bindings as $b) {
                    $stmt->execute($b);
                }
            }

            $result = $this->pdo->commit();

            if ($result) {
                $data = ['id' => $empBindings['employee_id'], 'name' => $empBindings['first_name']];

                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }

        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            \var_dump($ex->getMessage());
        }
    }

    public function update(Employee $employee) {
        $empBindings = $this->getEmployeeBindings($employee);
        $shiftBindings = $this->getShiftBindings($employee);

        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($this->generateUpdateSql('employee', array_keys($empBindings), 'employee_id'));

            $result = $stmt->execute($empBindings);

            $stmt = $this->pdo->prepare($this->generateUpdateSql('working_time',array_keys($shiftBindings), 'employee_id'));

            if ($empBindings['employee_position_id'] == '104') {
                // push the foreign key value to execute
                $shiftBindings['employee_id'] = $empBindings['employee_id'];
                $result = $stmt->execute($shiftBindings);

                // // delete service types
                $sql = "DELETE FROM employee_service_detail WHERE employee_id=:employee_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['employee_id' => $empBindings['employee_id']]);

                // insert into employee service types
                $bindings = $this->getServiceTypeBindings($employee, $empBindings['employee_id']);
                $sql = "INSERT INTO `employee_service_detail` (`employee_id`, `service_type_id`) VALUES (:employee_id, :service_type_id)";
                $stmt = $this->pdo->prepare($sql);
                foreach ($bindings as $b) {
                    $stmt->execute($b);
                }
            }
            // \var_dump($stmt->rowCount());
            $result = $this->pdo->commit();

            if ($result) {
                $data = ['id' => $empBindings['employee_id'], 'name' => $empBindings['first_name']];

                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }

        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            var_dump($ex->getMessage());
            exit();
        }
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
    private function getEmployeeBindings(Employee $employee) {
        $employeeBindings = [
            'employee_id' => $employee->getEmployeeId() ?? $this->generateId(),
            // 'employee_title' => $employee->getTitle(),
            'first_name' => $employee->getFirstName(),
            'booking_availability' => $employee->getBookingAvailability(),
            'last_name' => $employee->getLastName(),
            'telephone' => $employee->getTelephone(),
            'email' => $employee->getEmail(),
            'nic' => $employee->getNic(),
            'birth_date' => $employee->getBirthDate(),
            'employee_position_id' => $employee->getRoleId(),
            'joined_date' => $employee->getDateJoined(),
        ];

        return $employeeBindings;
    }

    private function getShiftBindings(Employee $employee) {
        $shiftBindings = [
            'shift_start' => $employee->getShiftStart(),
            'shift_end' => $employee->getShiftEnd(),
        ];
        return $shiftBindings;
    }

    private function getScheduleBindings(Employee $employee) {
        // for each object in entries array. and / or the assignedJobs object
        $scheduleBindings = [
            '',
        ];
    }

    private function getServiceTypeBindings(Employee $employee, string $id) {
        // for each object in entries array. and / or the assignedJobs object
        $serviceTypes = $employee->getServiceTypeIds();
        $bindings = [];
        foreach($serviceTypes as $s) {
            $bindings[] = [
                'employee_id' => $id,
                'service_type_id' => $s,
            ];
        }
        return $bindings;
    }

    /**
     * Generate a unique key
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "E" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }
}
