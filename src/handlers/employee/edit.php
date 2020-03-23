<?php

use sbwms\Employee\EmployeeMapper;
use sbwms\Employee\EmployeeRepository;

$id = $request->query->get('id');

if ($id !== null && $id !== '') {
    $employeeMapper = new EmployeeMapper($pdoAdapter);
    $employee = (new EmployeeRepository($employeeMapper))->findById($id);

    echo $employeeMapper->toJson($employee);
    return;
    // exit(var_dump($cjson));

}
if ($request->getMethod() === 'POST') {
    /** @var array */
    $formData = $request->request->getIterator()->getArrayCopy();

    /** @var EmployeeMapper */
    $employeeMapper = new EmployeeMapper($pdoAdapter);

    /** @var Employee */
    $employee = $employeeMapper->create($formData);

    /** @var EmployeeRepository */
    $employeeRepository = new EmployeeRepository($employeeMapper);

    /** @var true|null */
    $result = $employeeRepository->save($employee);
    // $result = 'test';

    /* 
        0 = success
        1 = failure (expect error list)
    */

    /** @var int */
    $successStatus = 1;

    if ($result === true) { $successStatus = 0; }
    $resultArray = [
        'result' => $result,
        'success' => $successStatus,
    ];

    echo json_encode($resultArray); // buffered
    return;
}

require_once 'list.php';