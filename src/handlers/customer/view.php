<?php
use sbwms\CustomerRepository;
use sbwms\CustomerMapper;

$id = $request->query->get('id');

if ($id !== null && $id !== '') {
    $customerMapper = new CustomerMapper($pdoAdapter);
    $customer = (new CustomerRepository($customerMapper))->findById($id);

    if ($customer === null) {
        require_once 'list.php';
        return;
    }
    // exit(var_dump($cjson));

}
require_once VIEWS . 'customer/viewCustomer.view.php';