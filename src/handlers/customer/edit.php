<?php
use sbwms\CustomerRepository;
use sbwms\CustomerMapper;

$id = $request->query->get('id');

if ($id !== null && $id !== '') {
    $customerMapper = new CustomerMapper($pdoAdapter);
    $customer = (new CustomerRepository($customerMapper))->findById($id);

    echo $customerMapper->toJson($customer);
    return;
    // exit(var_dump($cjson));

}
if ($request->getMethod() === 'POST') {
    /** @var array */
    $formData = $request->request->getIterator()->getArrayCopy();

    /** @var CustomerMapper */
    $customerMapper = new CustomerMapper($pdoAdapter);

    /** @var Customer */
    $customer = $customerMapper->create($formData);

    /** @var CustomerRepository */
    $customerRepository = new CustomerRepository($customerMapper);

    /** @var true|null */
    $result = $customerRepository->save($customer);
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