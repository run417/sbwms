<?php

namespace sbwms\Employee;

use sbwms\PDOAdapter;
use sbwms\Employee\Employee;

class EmployeeMapper {
    private $adapter;
    private $tableName = 'employee';
    
    public function __construct(PDOAdapter $_pdo) {
        $this->adapter = $_pdo;
    }

    /**
     * Create a Employee object from an array with properties
     * 
     * @param array An array containing employee data
     * @return Employee An instance of Employee
     */
    public function create(array $attributes) {
        return (new Employee($attributes));
    }

    /**
     * Get Employee object by an Id
     * 
     * @param string $employeeId 'E0001'
     * @return object|null Returns a Employee object or null
     * if multiple records or no records are found.
     */
    public function findById(string $employeeId) {
        $binding = ['employee_id' => $employeeId];
        $record = $this->adapter->findByField($binding, $this->tableName);
        if (is_array($record) && count($record) === 1) {
            return $this->instantiate(array_shift($record));
        } elseif (is_array($record) && count($record) > 1) {
            exit('More than one record!');
        }
        return null;
    }

    /**
     * Find all employees
     * 
     * @return array An array of employee instances
     */
    public function findAll() {
        $record_set = $this->adapter->findAll($this->tableName);
        $employees = [];
        if (is_array($record_set) && count($record_set) > 0) {
            foreach ($record_set as $record) {
                $employees[] = $this->instantiate($record);
            }
            return $employees;
        }
        return null;
    }

    /**
     * Create a employee record in the database.
     * 
     * @param Employee An instance of Employee
     * @return bool Returns true on successful row creation
     */
    public function insert(Employee $employee) {
        $bindings = $this->properties($employee);
        $result = $this->adapter->insert($bindings, $this->tableName);
        return $result;
    }

    /**
     * Update a employee record in database
     * 
     * @param Employee An instance of Employee object
     * @return bool Returns true if the update is a success
     */
    public function update(Employee $employee) {
        $bindings = $this->properties($employee);
        // Pop unique keys
        $result = $this->adapter->update($bindings, $this->tableName);
        return $result;
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
    private function properties(Employee $employee) {
        $properties = [
            'employee_id' => $employee->getEmployeeId() ?? $this->generateId(),
            // 'employee_title' => $employee->getTitle(),
            'first_name' => $employee->getFirstName(),
            'last_name' => $employee->getLastName(),
            'telephone' => $employee->getTelephone(),
            'email' => $employee->getEmail(),
            'nic' => $employee->getNic(),
            'employee_position_id' => $employee->getRole(),
            'joined_date' => $employee->getDateJoined(),
        ];

        return $properties;
    }

    /**
     * Instantiate a Employee class using a database record
     * 
     * This is a private helper method. It is needed because the 
     * the database array keys are different from the keys used elsewhere
     * in the application
     * 
     * @param array An assoc. array containing database record
     * @return Employee
     */
    private function instantiate(array $record) {
        $properties = [
            'employeeId' => $record['employee_id'],
            // 'title' => $record['employee_title'],
            'firstName' => $record['first_name'],
            'lastName' => $record['last_name'],
            'telephone' => $record['telephone'],
            'email' => $record['email'],
            'nic' => $record['nic'],
            'role' => $record['employee_position_id'],
            'dateJoined' => $record['joined_date'],
        ];
        return new Employee($properties);
    }    

    /**
     * Generate a unique key
     * 
     * This is generated using the row count of a table
     * 
     * @return string The id
     */
    private function generateId() {
        $count = $this->adapter->getRowCount($this->tableName) + 1;
        $id = "E" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }

    /**
     * Serialize Employee instance to JSON
     */
    public function toJson(Employee $employee) {
        
        $c['employeeId'] = $employee->getEmployeeId();
        // $c['title'] = $employee->getTitle();
        $c['firstName'] = $employee->getFirstName();
        $c['lastName'] = $employee->getLastName();
        $c['telephone'] = $employee->getTelephone();
        $c['email'] = $employee->getEmail();
        $c['nic'] = $employee->getNic();
        $c['dateJoined'] = $employee->getDateJoined();
        $c['role'] = $employee->getRole();

        return \json_encode($c);
    }

}
