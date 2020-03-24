<?php

namespace sbwms\Model;

use sbwms\Model\Customer;

class CustomerSerializerService {

    public function json(Customer $c) {
        $customer = [];
        $customer['customerId'] = $c->getCustomerId();
        $customer['title'] = $c->getTitle();
        $customer['firstName'] = $c->getfirstName();
        $customer['lastName'] = $c->getlastName();
        $customer['telephone'] = $c->gettelephone();
        $customer['email'] = $c->getemail();
        return \json_encode($customer);
    }
}