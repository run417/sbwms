<?php

use sbwms\Employee\EmployeeMapper;
use sbwms\Employee\EmployeeRepository;

/** @var EmployeeMapper */
$employeeMapper = new EmployeeMapper($pdoAdapter);

/** @var EmployeeRepository */
$employeeRepository = new EmployeeRepository($employeeMapper);

/** @var array|null */
$employees = $employeeRepository->findAllEmployees();

/* 
    Address the issues that would arise if $employees becomes anything
    other than an array of Employee instances.
*/


require_once VIEWS . 'employee/listEmployee.view.php';
