<?php

namespace sbwms\Service;

use sbwms\PDOAdapter;
use sbwms\Service\ServiceType;

class ServiceTypeMapper {
    private $adapter;
    private $tableName = 'service_type';

    public function __construct(PDOAdapter $_adapter) {
        $this->adapter = $_adapter;
    }

    /**
     * Create a ServiceType object from an array with properties
     * 
     * @param array An array containing service type data
     * @return ServiceType An instance of ServiceType
     */
    public function create(array $attributes) {
        return (new ServiceType($attributes));
    }

    /**
     * Find all service types
     * 
     * @return array An array of service type instances
     */
    public function findAll() {
        $record_set = $this->adapter->findAll($this->tableName);
        $serviceTypes = [];
        if (is_array($record_set) && count($record_set) > 0) {
            foreach ($record_set as $record) {
                $serviceTypes[] = $this->instantiate($record);
            }
            return $serviceTypes;
        }
        return null;
    }

    /**
     * Create a service type record in the database.
     * 
     * @param ServiceType An instance of ServiceType
     * @return bool Returns true on successful row creation
     */
    public function insert(ServiceType $serviceType) {
        $bindings = $this->properties($serviceType);
        $result = $this->adapter->insert($bindings, $this->tableName);
        return $result;
    }

    /**
     * Update a Service type record in database
     * 
     * @param ServiceType An instance of ServiceType object
     * @return bool Returns true if the update is a success
     */
    public function update(ServiceType $serviceType) {
        $bindings = $this->properties($serviceType);
        // Pop unique keys
        $result = $this->adapter->update($bindings, $this->tableName);
        return $result;
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
    private function properties(ServiceType $serviceType) {
        $properties = [
            'service_type_id' => $serviceType->getServiceTypeId() ?? $this->generateId(),
            'name' => $serviceType->getName(),
            'estimated_duration' => $serviceType->getDuration(),
        ];

        return $properties;
    }

    /**
     * Instantiate a ServiceType class using a database record
     * 
     * This is a private helper method. It is needed because the 
     * the database array keys are different from the keys used elsewhere
     * in the application
     * 
     * @param array An assoc. array containing database record
     * @return ServiceType
     */
    private function instantiate(array $record) {
        $properties = [
            'serviceTypeId' => $record['service_type_id'],
            'name' => $record['name'],
            'duration' => $record['estimated_duration'],

        ];
        return new ServiceType($properties);
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
        $id = "ST" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }    
}