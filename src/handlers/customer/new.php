<?php
use sbwms\Customer;
use sbwms\CustomerMapper;
use sbwms\CustomerRepository;

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
    
    
    /* 
        0 = success
        1 = failure (expect error list)
    */

    /** @var int */
    $successStatus = 1;

    if ($result === true) { $successStatus = 0; }

    echo $successStatus; // buffered
    return;
}
require_once VIEWS . 'customer/createCustomer.view.php';
// require_once VIEWS . 'customer/new.customer.partial.view.php';
