<?php

namespace sbwms\Model\Service\Type;

use DateInterval;

class ServiceType {

    private $serviceTypeId;
    private $name;
    private $status;

    /** @var DateTimeInterval */
    private $duration;

    public function __construct(array $args) {
        $this->serviceTypeId = $args['serviceTypeId'] ?? null;
        $this->name = $args['name'];
        $this->status = $args['status'];
        $this->duration = $args['duration'];
    }

    /**
     * Get the value of serviceTypeId
     */
    public function getServiceTypeId() {
        return $this->serviceTypeId;
    }

    /**
     * Alias of getServiceTypeId()
     */
    public function getId() {
        return $this->getServiceTypeId();
    }

    /**
     * Get the value of name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the value of duration
     *
     * @return DateTimeInterval
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * Get the value of status
     */
    public function getStatus() {
        return $this->status;
    }
}
