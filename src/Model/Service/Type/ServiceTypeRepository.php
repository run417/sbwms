<?php

namespace sbwms\Model\Service\Type;

use sbwms\Model\Service\Type\ServiceTypeMapper;

class ServiceTypeRepository {

    /** @var ServiceTypeMapper */
    private $mapper;

    public function __construct(ServiceTypeMapper $_mapper) {
        $this->mapper = $_mapper;
    }

    /**
     * Find all the service types
     *
     * TODO: Consider about using collections
     *
     * @return array|null Returns an array of ServiceType instances
     */
    public function findAll() {
        $sql = "SELECT * FROM service_type WHERE record_state=:record_state";
        $bindings = ['record_state' => 1];
        $serviceTypes = $this->mapper->find($bindings, $sql);
        return $serviceTypes;
    }

    /**
     * Find all active service types
     *
     * TODO: Consider about using collections
     *
     * @return array|null Returns an array of ServiceType instances
     */
    public function findAllOperational() {
        $sql = "SELECT * FROM service_type WHERE record_state=:record_state AND status=:status";
        $bindings = ['record_state' => 1, 'status' => 'operational'];
        $serviceTypes = $this->mapper->find($bindings, $sql);
        return $serviceTypes;
    }

    public function findById(string $id) {
        $sql = "SELECT * FROM service_type WHERE service_type_id=:service_type_id AND record_state=:record_state";
        $bindings = ['service_type_id' => $id, 'record_state' => 1];
        $serviceType = $this->mapper->find($bindings, $sql);
        return array_shift($serviceType);
    }

    /**
     * Save an instance to the database
     *
     * This method determines whether an instance should be created or updated
     * based on the the id of the instance.
     *
     * @param ServiceType Instance of an ServiceType
     * @return boolean|string Returns true if insert or update succeeds or the error message
     */
    public function save(ServiceType $serviceType) {
        if ($serviceType->getServiceTypeId() === null) {
            return $this->mapper->insert($serviceType);
        }
        return $this->mapper->update($serviceType);
    }
}
