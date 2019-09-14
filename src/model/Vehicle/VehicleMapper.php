<?php

namespace sbwms\Vehicle;

use sbwms\PDOAdapter;

class VehicleMapper {
    /** @var PDOAdapter */
    private $adapter;

    public function __construct(PDOAdapter $_adapter) {
        $this->adapter = $_adapter;
    }

    /**
     * Get Vehicle object by an Id
     * 
     * @param string $vehicleId 'V0001'
     * @return Vehicle|null Returns a Vehicle instance or null
     * if multiple records or no records are found.
     */
    public function findById(string $vehicleId) {
        $binding = ['vehicle_id' => $vehicleId];
        $record = $this->adapter->findByField($binding, $this->tableName);
        if (is_array($record) && count($record) === 1) {
            return $this->instantiate(array_shift($record));
        } elseif (is_array($record) && count($record) > 1) {
            exit('More than one record!');
        }
        return null;
    }
}