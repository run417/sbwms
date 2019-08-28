<?php
$postcount = ($request->request->count()); // $_POST Variables
if ($postcount !== 0) {
    /* Customer Details */
    $firstname = $request->request->get('customer_first_name');
    $lastName = $request->request->get('customer_last_name');
    $telephone = $request->request->get('customer_telephone');
    $email = $request->request->get('customer_email');

    /* Vehicle Details */
    $make = $request->request->get('vehicle_make');
    $model = $request->request->get('vehicle_model');
    $year = $request->request->get('vehicle_year');
    $registrationNo = $request->request->get('vehicle_registration_no');
    $vinNo = $request->request->get('vehicle_id_no');
    
    /* 
        0 = success
        1 = failure (expect error list)
    */

    $result = 0;
    echo $result; // buffered
    return;
}
require_once VIEWS . 'customer/createCustomer.view.php';