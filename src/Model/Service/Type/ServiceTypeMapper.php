<?php

namespace sbwms\Model\Service\Type;

use PDO;
use DateInterval;
use sbwms\Model\BaseMapper;
use sbwms\Model\Service\Type\ServiceType;

class ServiceTypeMapper extends BaseMapper {
    protected $pdo;
    private $entityManager;
    private $tableName = 'service_type';

    public function __construct(PDO $_pdo, ServiceTypeEntityManager $_stem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_stem;
    }

    /**
     * Create a ServiceType object from an array with properties
     *
     * @param array An array containing service type data
     * @return ServiceType An instance of ServiceType
     */
    public function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * Find by id, Find by field, Find all
     */
    public function find(array $binding = [], string $query = '') {

        $stmt = $this->executeQuery($binding, $query);
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

        $serviceTypes = [];

        if ($stmt->rowCount() >= 1) {
            foreach ($result_set as $record) {
                $record['_origin'] = 'database';
                $serviceTypes[] = $this->createEntity($record);
            }
        }

        return $serviceTypes;
    }

    /**
     * Create a service type record in the database.
     *
     * @param ServiceType An instance of ServiceType
     * @return bool Returns true on successful row creation
     */
    public function insert(ServiceType $serviceType) {
        $bindings = $this->getServiceTypeBindings($serviceType);
        $sql = $this->generateInsertSql($this->tableName, \array_keys($bindings));
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($bindings);
            if ($result) {
                $data = ['id' => $bindings['service_type_id'], 'name' => $bindings['name']];

                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\PDOException $ex) {
            \var_dump($ex->getMessage());
            exit();
        }
    }

    /**
     * Update a Service type record in database
     *
     * @param ServiceType An instance of ServiceType object
     * @return bool Returns true if the update is a success
     */
    public function update(ServiceType $serviceType) {
        $bindings = $this->getServiceTypeBindings($serviceType);
        $sql = $this->generateUpdateSql($this->tableName, \array_keys($bindings), 'service_type_id');
        try {
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($bindings);
            if ($result) {
                $data = ['id' => $bindings['service_type_id'], 'name' => $bindings['name']];
                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\PDOException $ex) {
            \var_dump($ex->getMessage());
            exit();
        }
    }

    /**
     * Extract properties of a ServiceType object to an php array
     *
     * Used when inserting a record to the database. This method will
     * extract the properties of the ServiceType object to an assoc array
     * that has the keys o
     *
     * @param ServiceType An instance of the service type object
     * @return array An array that contain key-value pairs of
     * database table fields and values.
     */
    private function getServiceTypeBindings(ServiceType $serviceType) {
        $bindings = [
            'service_type_id' => $serviceType->getServiceTypeId() ?? $this->generateId(),
            'name' => $serviceType->getName(),
            'status' => $serviceType->getStatus(),
            'estimated_duration' => $serviceType->getDuration()->format('%hH%iM'),
        ];

        return $bindings;
    }

    /**
     * Generate a unique key
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "ST" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
