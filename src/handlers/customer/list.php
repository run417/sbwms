<?php

use sbwms\CustomerMapper;
use sbwms\CustomerRepository;

/** @var array|null An array of Customer instances or null */
$customers = (new CustomerRepository(new CustomerMapper($pdoAdapter)))->findAllCustomers();

require_once VIEWS . 'customer/listCustomer.view.php';
