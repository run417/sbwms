<?php

namespace sbwms\Service;

use sbwms\Service\ServiceTypeMapper;

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
    public function findAllServiceTypes() {
        $serviceTypes = $this->mapper->findAll();
        return $serviceTypes;
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