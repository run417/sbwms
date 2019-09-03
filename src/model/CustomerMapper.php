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
     * @param Customer An instance of Customer
     * @return bool Returns true on successful row creation
     */
    public function insert(Customer $customer) {
        $bindings = $this->properties($customer);
        $result = $this->adapter->insert($bindings, $this->tableName);
        return $result;
    }

    /**
     * Update a customer record in database
     * 
     * @param Customer An instance of Customer object
     * @return bool Returns true if the update is a success
     */
    public function update(Customer $customer) {
        $bindings = $this->properties($customer);
        $result = $this->adapter->update($bindings, $this->tableName);
        return $result;
    }

    /**
     * Instantiate a Customer object using a database record
     * 
     * This is a private helper method. It is needed because the 
     * the database array keys are different from the keys used elsewhere
     * in the application
     * 
     * @param array An assoc. array containing database record
     * @return Customer
     */
    private function instantiate(array $record) {
        $properties = [
            'customerId' => $record['customer_id'],
            'title' => $record['customer_title'],
            'firstName' => $record['first_name'],
            'lastName' => $record['last_name'],
            'telephone' => $record['telephone'],
            'email' => $record['email'],
            'regDate' => $record['registration_date'],
        ];
        return new Customer($properties);
    }

    /**
     * Extract properties of a Customer object to an php array
     * 
     * Used when inserting a record to the database. This method will
     * extract the properties of the Customer object to an assoc array
     * that has the keys o
     * 
     * @param Customer An instance of the customer object
     * @return array An array that contain key-value pairs of 
     * database table fields and values.
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

    /**
     * Generate a unique key
     * 
     * This is generated using the row count of a table
     * 
     * @return string The id
     */
    private function generateId() {
        $count = $this->adapter->getRowCount($this->tableName) + 1;
        $id = "C" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }
}