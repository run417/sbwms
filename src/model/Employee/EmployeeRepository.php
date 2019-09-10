<?php

namespace sbwms\Employee;

use sbwms\Employee\EmployeeMapper;

class EmployeeRepository {
    /** @var EmployeeMapper */
    private $mapper;

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
        $employee = $this->mapper->findById($employeeId);
        return $employee;
    }

    /**
     * Find all the employees
     * 
     * TODO: Consider about using collections
     * 
     * @return array|null Returns an array of Employee instances
     */
    public function findAllEmployees() {
        $employees = $this->mapper->findAll();
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