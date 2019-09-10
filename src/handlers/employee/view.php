<?php

use sbwms\Employee\EmployeeRepository;
use sbwms\Employee\EmployeeMapper;

$id = $request->query->get('id');

if ($id !== null && $id !== '') {
    $employeeMapper = new EmployeeMapper($pdoAdapter);
    $employee = (new EmployeeRepository($employeeMapper))->findById($id);

    if ($employee === null) {
        require_once 'list.php';
        return;
    }
    // exit(var_dump($cjson));

}
require_once VIEWS . 'employee/viewEmployee.view.php';