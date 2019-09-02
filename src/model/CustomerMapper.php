<?php
namespace sbwms;
use sbwms\PDOAdapter;
use sbwms\Customer;

class CustomerMapper {
    private $adapter;
    private $tableName = 'customer';
    
    public function __construct(PDOAdapter $_pdo) {
        $this->adapter = $_pdo;
    }

    /**
     * Get Customer object by an Id
     * 
     * @param string $customerId 'C0001'
     * @return object|null Returns a Customer object or null
     * if multiple records or no records are found.
     */
    public function findById(string $customerId) {
        $binding = ['customer_id' => $customerId];
        $record = $this->adapter->findByField($binding, $this->tableName);
        if (is_array($record) && count($record) === 1) {
            return $this->instantiate(array_shift($record));
        } elseif (is_array($record) && count($record) > 1) {
            exit('More than one record!');
        }
        return null;
    }

    /**
     * Find all customers
     * 
     * @return array An array of customer objects
     */
    public function findAll() {
        $record_set = $this->adapter->findAll($this->tableName);
        $customers = [];
        if (is_array($record_set) && count($record_set) > 0) {
            foreach ($record_set as $record) {
                $customers[] = $this->instantiate($record);
            }
            return $customers;
        }
        return null;
    }

    /**
     * Create a Customer object from an array with properties
     * 
     * @param array An array containing customer data
     * @return Customer A customer object
     */
    public function create(array $attributes) {
        return (new Customer($attributes));
    }

    /**
     * Create a customer record in the database.
     * 
     * @param object Customer $customer
     * @return bool $result
     */
    public function create(Customer $customer) {
        $bindings = $this->properties($customer);
        $result = $this->adapter->insert($bindings, $this->tableName);
        return $result;
    }

    /**
     * Update a customer record in database
     * 
     * @param object Customer $customer
     * @return bool $result
     */
    public function update(Customer $customer) {
        $bindings = $this->properties($customer);
        $result = $this->adapter->update($bindings, $this->tableName);
        return $result;
    }

    /**
     * Instantiate a Customer object using a database record
     * @param array $record An assoc. array containing database record
     * @return object Customer
     */
    private function instantiate(array $record) {
        $properties = [
            'customerId' => $record['customer_id'],
            'firstName' => $record['first_name'],
            'lastName' => $record['last_name'],
            'telephone' => $record['telephone'],
            'email' => $record['email'],
        ];
        return new Customer($properties);
    }

    /**
     * Extract properties of a Customer object to an php array
     * 
     * @param object Customer $customer
     * @return array $properties Returns an array that
     * contain key-value pairs of table fields and values.
     */
    private function properties(Customer $customer) {
        $properties = [
            'customer_id' => $customer->getCustomerId(),
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'telephone' => $customer->getTelephone(),
            'email' => $customer->getEmail(),
        ];
        if ($properties['customer_id'] === null) {
            exit("customer id not set");
        }
        return $properties;
    }
}