<?php

namespace sbwms\Model\Employee;

use sbwms\Model\Employee\EmployeeMapper;

class EmployeeRepository {
    /** @var EmployeeMapper */
    private $mapper;
    private $detailQueries = [
        "jobs" => "SELECT * FROM booking WHERE employee_id = :employee_id AND (status = 'Pending' OR status = 'Confirmed');",
        "serviceTypes" => "SELECT employee_service_detail.service_type_id, service_type.name, service_type.status, service_type.estimated_duration FROM employee_service_detail JOIN service_type ON employee_service_detail.service_type_id = service_type.service_type_id WHERE employee_id = :employee_id",
    ];

    public function __construct(EmployeeMapper $_mapper) {
        $this->mapper = $_mapper;
    }

    /**
     * Get a Employee instance from the database by id
     *
     * @param string The employeeId in the form of 'C0001'
     * @return Employee An instance of Employee
     */
    public function findById(string $employeeId) {
        $sql = "SELECT employee.*, shift_start, shift_end, break_start, break_end FROM employee LEFT JOIN working_time ON employee.employee_id = working_time.employee_id LEFT JOIN break_time ON employee.employee_id = break_time.employee_id WHERE employee.employee_id = :employee_id";
        $bindings = ['employee_id' => $employeeId];
        $employee = $this->mapper->find($bindings, $sql, $this->detailQueries);
        return array_shift($employee);
    }

    /**
     * Find all the employees
     *
     * TODO: Consider about using collections
     *
     * @return array|null Returns an array of Employee instances
     */
    public function findAll() {
        $sql = "SELECT employee.*, shift_start, shift_end, break_start, break_end FROM employee LEFT JOIN working_time ON employee.employee_id = working_time.employee_id LEFT JOIN break_time ON employee.employee_id = break_time.employee_id";
        $employees = $this->mapper->find([], $sql, $this->detailQueries);
        return $employees;
    }

    public function findAllSansAccount() {
        $sql = "SELECT employee.*, shift_start, shift_end, break_start, break_end FROM employee LEFT JOIN working_time ON employee.employee_id = working_time.employee_id LEFT JOIN break_time ON employee.employee_id = break_time.employee_id WHERE employee.employee_id NOT IN (SELECT user.profile_id FROM user)";

        $employees = $this->mapper->find([], $sql);
        return $employees;
    }

    /**
     * Find all the employees
     *
     * TODO: Consider about using collections
     *
     * @return array|null Returns an array of Employee instances
     */
    public function findAllServiceCrew() {
        $sql = "SELECT employee.*, shift_start, shift_end, break_start, break_end FROM employee LEFT JOIN working_time ON employee.employee_id = working_time.employee_id LEFT JOIN break_time ON employee.employee_id = break_time.employee_id WHERE employee.employee_position_id = :employee_position_id";
        $bindings = ['employee_position_id' => '104'];
        $employees = $this->mapper->find($bindings, $sql);
        return $employees;
    }

    public function findAllByBookingAndService(string $serviceTypeId) {
        $sql = "SELECT employee.*, shift_start, shift_end, break_start, break_end FROM `employee_service_detail` JOIN employee ON employee.employee_id = employee_service_detail.employee_id LEFT JOIN working_time ON employee.employee_id = working_time.employee_id LEFT JOIN break_time ON employee.employee_id = break_time.employee_id WHERE `service_type_id` = :service_type_id AND employee.booking_availability=:ba";

        $employees = $this->mapper->find(['service_type_id' => $serviceTypeId, 'ba' => 'yes'], $sql, $this->detailQueries);
        return $employees;
    }

    public function findAllByServiceId(string $serviceTypeId) {
        $sql = "SELECT employee.*, shift_start, shift_end, break_start, break_end FROM `employee_service_detail` JOIN employee ON employee.employee_id = employee_service_detail.employee_id LEFT JOIN working_time ON employee.employee_id = working_time.employee_id LEFT JOIN break_time ON employee.employee_id = break_time.employee_id WHERE `service_type_id` = :service_type_id";

        $employees = $this->mapper->find(['service_type_id' => $serviceTypeId], $sql);
        return $employees;
    }

    public function findAllEmployeesWithJobCount() {
        $sql = "SELECT employee.*, shift_start, shift_end, break_start, break_end FROM employee LEFT JOIN working_time ON employee.employee_id = working_time.employee_id LEFT JOIN break_time ON employee.employee_id = break_time.employee_id";
        $detailQueries = [
            'jobCount' => "SELECT count(booking.employee_id) AS job_count FROM booking WHERE employee_id = :employee_id",
        ];
        $employees = $this->mapper->find([], $sql, $detailQueries);
        return $employees;
    }

    /**
     * Save an instance to the database
     *
     * This method determines whether an instance should be created or updated
     * based on the the id of the instance.
     *
     * @param Employee Instance of an Employee
     * @return boolean|string Returns true if insert or update succeeds or the error message
     */
    public function save(Employee $employee) {
        if ($employee->getEmployeeId() === null) {
            return $this->mapper->insert($employee);
        }
        return $this->mapper->update($employee);
    }
}