<?php

namespace sbwms\Model;

use sbwms\Model\BaseMapper;
use sbwms\Model\Customer;
use sbwms\Model\Vehicle\Vehicle;
use DateTime;
use PDO;

class CustomerMapper extends BaseMapper {
    protected $pdo;
    private $primaryKey; // customer primary key that is shared with the instances this mapper handles
    private $customerTable = 'customer';
    private $vehicleTable = 'vehicle';

    public function __construct(PDO $_pdo) {
        $this->pdo = $_pdo;
    }

    /**
     * Create a Customer instance from an array with properties
     *
     * @param array An array containing service type data
     * @return Customer An instance of Customer
     */
    public function createEntity(array $attributes) {
        $data = $this->convertKeys($attributes);
        $customer = new Customer($data);
        $vehicles = $this->_createVehicleEntities($data);
        // if no vehicles the vehicles property will be null in the customer instance.
        foreach ($vehicles as $v) {
            $v->setOwner($customer);
            // $customer->setVehicle($v);
        }
        // $vehicle->setOwner($customer);
        return $customer;
    }

    /**
     * @param array
     * @return array An array of Vehicle instances
     */
    private function _createVehicleEntities(array $data) {
        // a database customer record can have multiple vehicles
        // user data can only have one vehicle and the 'vehicles' key will not
        // be set currently.
        $vehiclesArray = [];
        if (\array_key_exists('vehicles', $data) && \is_array($data['vehicles'])) {
            foreach ($data['vehicles'] as $vData) {
                $vehiclesArray[] = (new Vehicle($vData));
            }
        } elseif (\array_key_exists('make', $data)) {
            // if there is no 'vehicles' key then the existence of the 'make'
            // key is determined. This means the data is from the user (UI).
            $vehiclesArray[] = (new Vehicle($data));
        }
        return $vehiclesArray;
    }

    /**
     * Get Customer instances from the database
     *
     * @param array
     * @param string SQL query
     * @return Customer|array A customer instances or an array of customer instances
     */
    public function find($binding=[], $query='') {

        // find the customer first
        // then find their vehicless.
        // a customer has zero or many vehicles. (it should be one or many)

        // bindings and sql are empty
        if (empty($binding) && empty($query)) {
            $sql = "SELECT customer.* FROM customer";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }

        if (empty($binding) && !empty($query)) {
            $sql = $query;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }

        // if only bindings are provided
        if (!empty($binding) && empty($query)) {
            $column = key($binding); // column name i.e customer_id
            $value = $binding[$column]; // attribute value 'C0001'

            // only customer table columms are expected in the bindings array
            $sql = "SELECT customer.* FROM customer WHERE customer.$column = :field";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['field' => $value]);
        }

        // if there both bindings and sql are provided
        if (!empty($binding) && !empty($query)) {
            $column = key($binding); // column name i.e customer_id
            $value = $binding[$column]; // attribute value 'C0001'

            $sql = $query;

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($binding);
        }

        $result_set = $stmt->fetchAll();

        /* If result_set is false then its a failure somewhere */
        if (is_bool($result_set) && $result_set === FALSE) {
            // /* TODO */ handle this conveniently
            exit('FetchAll Failure');
        }

        /* check if no matching records are found */
        if (is_array($result_set) && count($result_set) === 0) {
            return null;
        }

        // if condition possibly redundant
        if ($stmt->rowCount() >= 1) {

            $sql = "SELECT vehicle.* FROM vehicle  WHERE customer_id = :customer_id";
            $stmt = $this->pdo->prepare($sql);
            $cus_with_vehicles= [];
            foreach ($result_set as $c) {
                $stmt->execute(['customer_id' => $c['customer_id']]);
                $v = $stmt->fetchAll();
                if ($stmt->rowCount() >= 0) {
                    // if the no vehicles the 'vehicles' array will be empty
                    $c['vehicles'] = $v;
                }
                $cus_with_vehicles[] = $c;
            }


            foreach ($cus_with_vehicles as $record) {
                $customers[] = $this->createEntity($record);
            }

            if (\count($customers) === 1) {
                return \array_shift($customers);
            }

            return $customers;
        }
    }

    private function _findVehicles($customer_set) {
        $sql = "SELECT vehicle.* FROM vehicle  WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        $cus_with_vehicles= [];
        foreach ($customer_set as $c) {
            $stmt->execute(['customer_id' => $c['customer_id']]);
            $v = $stmt->fetchAll();
            if ($stmt->rowCount() > 0) {
                $c['vehicles'] = $v;
            }
            $cus_with_vehicles[] = $c;
        }
        return $cus_with_vehicles;
    }

    /**
     * Create a customer record in the database.
     *
     * @param Customer An instance of Customer
     * @return bool Returns true on successful row creation
     */
    public function insert(Customer $customer) {
        // exit(var_dump($customer->getVehicles()));
        // todo: customer_id is null because you are getting bindings from
        // two different methods. customer_id used both bindings but is only
        // created in a single method. There should be a way that both methods
        // should be able to use the unique customer id.
        // possible_solution: private property of the unique customer_id.
        // it will be set only once and will check for the existence of a
        // previous key and the uniqueness of the current key with regards
        // to the private instance key.
        $customerBindings = $this->getCustomerBindings($customer);
        $vehicles = $customer->getVehicles();
        $vehicleColumns = $this->getVehicleBindings(array_shift($vehicles));
        // exit(var_dump($vehicleColumns));
        // array_pop($vehicleColumns); // pop 'customer_id' important that 'customer_id' key should be the last key in the array.

        try {
            $this->pdo->beginTransaction();

            $sql = $this->generateInsertSql(
                'customer', array_keys($customerBindings)
            );
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute($customerBindings);

            $sql = $this->generateInsertSql(
                'vehicle',
                array_keys($vehicleColumns)
                /* ['customer' => 'customer_id'] */
            );

            $stmt = $this->pdo->prepare($sql);

            $vehicles = $customer->getVehicles();

            foreach ($vehicles as $v) {
                $bindings = $this->getVehicleBindings($v);
                $stmt->execute($bindings);
            }

            $result = $this->pdo->commit();
            return $result;

        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            \var_dump($ex->getMessage());
            exit();
        }
    }

    /**
     * Update a customer record in database
     *
     * @param Customer An instance of Customer object
     * @return bool Returns true if the update is a success
     */
    public function update(Customer $customer) {
        exit('under construction');
        if ($customer->getCustomerId() === null) {
            exit('Dev Error - Not in database and cannot be updated');
        }

        $bindings = $this->getCustomerBindings($customer);

        $sql = $this->generateUpdateSql($this->tableName, \array_keys($bindings), 'customer_id');

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($bindings);

        $vehicles = $customer->getVehicles();

        foreach ($vehicles as $v) {
            if ($v->getVehicleId() === null) {

            }
        }

        $sql = $this->generateInsertSql(
            'vehicle',
            array_keys($vehicleColumns)
            /* ['customer' => 'customer_id'] */
        );

        $stmt = $this->pdo->prepare($sql);

        $vehicles = $customer->getVehicles();

        foreach ($vehicles as $v) {
            $bindings = $this->getVehicleBindings($v);
            $stmt->execute($bindings);
        }

        try {

            return $result;
        } catch (\PDOException $ex) {
            \var_dump($ex->getMessage());
            exit();
        }
        return $result;
    }

/**
     * Convert the keys of an array so that it can be fed
     * into a ServiceType class
     *
     * This is a private helper method. It is needed because the
     * the database array keys are different from the keys used in the
     * constructors of the domain classes in the application.
     * It checks if the array is from the database and if so
     * it converts the keys to a camelCase format.
     *
     * @param array An assoc. array containing keys usually a database record
     * @return array
     */
    private function convertKeys(array $data) {
        $keys = array_keys($data);
        $t = array_shift($keys);
        if (strpos($t, '_') !== false) {
            // has underscores so this is a database record
            // redefine the keys. notice the same variable $data used.
            $data = [
                'customerId' => $data['customer_id'] ?? null,
                'title' => $data['customer_title'],
                'firstName' => $data['first_name'],
                'lastName' => $data['last_name'],
                'telephone' => $data['telephone'],
                'email' => $data['email'],
                'regDate' => $data['registration_date'], // date could be DateTime instance
                'vehicles' => $data['vehicles'], // is always set because database record
            ];

            if (is_array($data['vehicles'])) {
                $vehicles = []; // vehicles with transformed keys
                foreach ($data['vehicles'] as $v) {
                    $vehicle = [
                        'vehicleId' => $v['vehicle_id'],
                        'make' => $v['make'],
                        'model' => $v['model'],
                        'year' => $v['year'],
                        'type' => $v['type'],
                        'regNo' => $v['reg_no'],
                        'vin' => $v['vin'],
                    ];
                    $vehicles[] = $vehicle;
                }
                $data['vehicles'] = $vehicles; // replaces the old vehicles array.
            }
            return $data;
        }

        return $data;
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
    private function getCustomerBindings(Customer $customer) {
        $binding = [
            'customer_id' => $customer->getCustomerId() ?? $this->generateCustomerId(),
            'customer_title' => $customer->getTitle(),
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'telephone' => $customer->getTelephone(),
            'email' => $customer->getEmail(),
            'registration_date' => $customer->getRegDate() ?? (new DateTime())->format('Y-m-d'),
        ];
        if ($binding['customer_id'] === null) {
            exit("customer id not set");
        }
        return $binding;
    }

    /**
     * Extract properties of a Vehicle object to an php array
     *
     * Used when inserting a record to the database. This method will
     * extract the properties of the Vehicle object to an assoc array
     * that has the keys o
     *
     * @param Vehicle An instance of the customer object
     * @return array An array that contain key-value pairs of
     * database table fields and values.
     */
    private function getVehicleBindings(Vehicle $vehicle) {
        // customer_id is null because they are not set at this time.
        // they are set in getCustomerBindings() method
        $bindings = [
            'vehicle_id' => $vehicle->getVehicleId() ?? $this->generateVehicleId(),
            'vin' => $vehicle->getVin() ?? null,
            'make' => $vehicle->getMake(),
            'model' => $vehicle->getModel(),
            'year' => $vehicle->getYear(),
            'type' => $vehicle->getType(),
            'reg_no' => $vehicle->getRegNo() ?? null,
            'customer_id' => $vehicle->getOwnerId() ?? $this->primaryKey,
        ];
        if ($bindings['customer_id'] === null) {
            exit("customer id not set");
        }
        return $bindings;
    }

    /**
     * Generate a unique key
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateCustomerId() {
        $count = $this->getRowCount($this->customerTable) + 1;
        $id = "C" . str_pad($count, 4, '0', STR_PAD_LEFT);
        if ($this->primaryKey == $id) {
            exit('duplicate key in customerMapper');
        }
        $this->primaryKey = $id;
        return $id;
    }

    /**
     * Generate a unique key for the Vehicle table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateVehicleId() {
        $count = $this->getRowCount($this->vehicleTable) + 1;
        $id = "V" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }
}