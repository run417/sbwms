<?php

namespace sbwms\Vehicle;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Customer;

class VehicleMapper extends BaseMapper {
    private $tableName = 'vehicle';
    protected $pdo;

    private $keyMap = [
        'customer_id' => 'customerId',
        'customer_title' => 'title',
        'first_name' => 'firstName',
        'last_name' => 'lastName',
        'telephone' => 'telephone',
        'email' => 'email',
        'registration_date' => 'regDate',
        'vehicle_id' => 'vehicleId',
        'make' => 'make',
        'model' => 'model',
        'year' => 'year',
        'type' => 'type',
        'reg_no' => 'regNo',
        'vin' => 'vin',
    ];

    public function __construct(PDO $_pdo) {
        $this->pdo = $_pdo;
    }

    /**
     * Create a Vehicle instance from an array with properties
     * Prepare each constructor e.g convert each
     *
     * @param array An array containing service type data
     * @return Vehicle An instance of Vehicle
     */
    public function createEntity(array $attributes) {
        // if only customerId is present and not other data
        // then find customer and create domain object
        $data = $this->convertKeys($attributes);
        if (!\array_key_exists('firstName', $data)) {
            // customer details does not exists 'firstName is arbitrary'
            $customerId = $data['customerId'];
            $customerData = $this->findCustomer($customerId);
            // temp validity check it should never come here or enable
            // vehicles without owners
            if (empty($customerData)) { exit('User data Error - Customer Not Found'); }
            $data = \array_merge($customerData, $data);
        }

        $customer = new Customer($data);
        $vehicle = new Vehicle($data);
        $vehicle->setOwner($customer);
        return $vehicle;
    }

    /**
     * @param string Customer Id
     * @return array Customer Database record
     */
    private function findCustomer($customerId) {
        $sql = "SELECT * FROM customer WHERE customer_id = :customer_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['customer_id' => $customerId]);
        $result = $stmt->fetchAll();
        if ($stmt->rowCount() === 1) {
            $customer = \array_shift($result);
            $customer = $this->convertKeys($customer);
            // unset($customer['customerId']);
            return $customer;
        } else {
            return [];
        }
    }

    /**
     * Get Customer instances from the database
     *
     * @param array
     * @param string SQL query
     * @return Vehicle|array A Customer instances or an array of Customer instances
     */
    public function find($binding=[], $query='') {

        // find the customer first
        // then find their vehicless.
        // a customer has zero or many vehicles. (it should be one or many)

        // bindings and sql are empty
        if (empty($binding) && empty($query)) {
            $sql = "SELECT vehicle.* FROM vehicle";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }

        // if only bindings are provided
        // if (!empty($binding) && empty($query)) {
        //     $column = key($binding); // column name i.e customer_id
        //     $value = $binding[$column]; // attribute value 'C0001'

        //     // only customer table columms are expected in the bindings array
        //     $sql = "SELECT vehicle.* FROM vehicle WHERE vehilce.$column = :field";

        //     $stmt = $this->pdo->prepare($sql);
        //     $stmt->execute(['field' => $value]);
        // }

        // if there both bindings and sql are provided
        if (!empty($binding) && !empty($query)) {
            $column = key($binding); // column name i.e customer_id
            $value = $binding[$column]; // attribute value 'C0001'
            // Warning this might not working due to above binding destructure

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
            // assumes vehicle is owned by a customer


            // todo instantiate record. first vehicle and then customer
            foreach ($result_set as $record) {
                $vehicles[] = $this->createEntity($record);
            }

            if (\count($vehicles) === 1) {
                return \array_shift($vehicles);
            }

            return $vehicles;
        }
    }

    public function insert(Vehicle $vehicle) {

        $vehicleBindings = $this->getVehicleBindings($vehicle);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO vehicle (vehicle_id, vin, make, model, year, type, reg_no, customer_id) VALUES (:vehicle_id, :vin, :make, :model, :year, :type, :reg_no, (SELECT customer_id FROM customer WHERE customer_id = :customer_id))";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($vehicleBindings);
            $result = $this->pdo->commit();
            if ($result === true) {// explicit checking (don't trust pdo commit)
                $data = ['vehicleId' => $vehicleBindings['vehicle_id']];
                return [
                    'result' => $result,
                    'data' => $data,
                ];
            }

        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            // you can handle possible concurrency issue
            // (same primary key here too)
            // var_dump($ex->getMessage());
            return (int) $ex->getCode();
        }
    }

    /**
     * Update a Vehicle record in database
     *
     * @param Vehicle An instance of Vehicle object
     * @return array Returns true if the update is a success
     */
    public function update(Vehicle $vehicle) {
        if ($vehicle->getVehicleId() === null) {
            exit('Dev Error - Not in database and cannot be updated');
        }

        $vehicleBindings = $this->getVehicleBindings($vehicle);

        $sql = $this->generateUpdateSql($this->tableName, \array_keys($vehicleBindings), 'vehicle_id');


        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($vehicleBindings);

        if ($result) {
            $data = ['vehicleId' => $vehicleBindings['vehicle_id']];
            return [
                'result' => $result,
                'data' => $data,
            ];
        }
    }

    /**
     * Convert the keys of an array so that it can be fed
     * into a domain class. Only job is to convert the array keys
     * with underscores to camelCase as found in the keyMap.
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
    public function convertKeys(array $data) {
        // if input key is not in the mapper keyMap undefined error is raised ????
        foreach ($data as $key => $value) {
            if (strpos($key, '_') !== false) { // contains underscore
                $underscoreKey = $key;
                $camelCaseKey = $this->keyMap[$key];
                $data[$camelCaseKey] = $data[$underscoreKey];
                unset($data[$underscoreKey]);
            }
        }
        return $data;
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
            // 'vehicle_id' => $vehicle->getVehicleId() ?? $this->generateVehicleId(),
            'vehicle_id' => $vehicle->getVehicleId() ?? $this->generateVehicleId(),
            'vin' => $vehicle->getVin() ?? null,
            'make' => $vehicle->getMake(),
            'model' => $vehicle->getModel(),
            'year' => $vehicle->getYear(),
            'type' => $vehicle->getType(),
            'reg_no' => $vehicle->getRegNo() ?? null,
            'customer_id' => $vehicle->getOwnerId() ?? exit('Owner is not set'),
        ];
        if ($bindings['customer_id'] === null) {
            exit("customer id not set");
        }
        return $bindings;
    }

    /**
     * Generate a unique key for the Vehicle table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateVehicleId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "V" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }

}