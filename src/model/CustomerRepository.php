<?php

namespace sbwms;

use sbwms\CustomerMapper;

class CustomerRepository {

    /** @var CustomerMapper */
    private $mapper;

    public function __construct(CustomerMapper $_mapper) {
        $this->mapper = $_mapper;
    }

    /**
     * Get a Customer instance from the database by id
     *
     * @param string The customerId in the form of 'C0001'
     * @return Customer An instance of Customer
     */
    public function findById(string $customerId) {
        $customer = $this->mapper->find(['customer_id' => $customerId]);
        return $customer;
    }

    /**
     * Find all the customers
     *
     * TODO: Consider about using collections
     *
     * @return array|null Returns an array of Customer instances
     */
    public function findAllCustomers() {
        $customers = $this->mapper->find();
        return $customers;
    }

    public function findAllSansAccount() {
        $sql = "SELECT customer.* FROM customer WHERE customer.customer_id NOT IN (SELECT user.profile_id FROM user)";
        $customers = $this->mapper->find($binding = [], $sql);
        return $customers;
    }

    public function save(Customer $customer) {
        if ($customer->getCustomerId() === null) {
            return $this->mapper->insert($customer);
        }
        return $this->mapper->update($customer);
    }

    public function addVehicle(Customer $c, Vehicle $v) {
        
    }
}
