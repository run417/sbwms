<?php

namespace sbwms\Service;

class ServiceType {

    private $serviceTypeId;
    private $name;
    private $duration;

    public function __construct(array $args) {
        $this->serviceTypeId = $args['serviceTypeId'] ?? null;
        $this->name = $args['name'];
        $this->duration = $args['duration'];
    }

    /**
     * Get the value of serviceTypeId
     */ 
    public function getServiceTypeId()
    {
        return $this->serviceTypeId;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of duration
     */ 
    public function getDuration()
    {
        return $this->duration;
    }
}