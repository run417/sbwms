<?php

namespace sbwms\Model\Vehicle;

use sbwms\Model\Customer;

class Vehicle {

    /** @var Customer */
    private $owner;

    /** @var string */
    private $id;
    private $make;
    private $model;
    private $regNo;
    private $year;
    private $type;
    private $vin;

    public function __construct(array $properties) {
        $this->id = $properties['vehicleId'] ?? null;
        $this->make = $properties['make'];
        $this->model = $properties['model'];
        $this->regNo = $properties['regNo'] ?? null;
        $this->year = $properties['year'];
        $this->type = $properties['type'] ?? null;
        $this->vin = $properties['vin'] ?? null;
    }

    /**
     * Get the value of id
     */
    public function getVehicleId() {
        return $this->id;
    }

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the value of owner Id
     */
    public function getOwnerId() {
        return $this->owner->getCustomerId();
    }

    /**
     * Get the value of make
     */
    public function getMake() {
        return $this->make;
    }

    /**
     * Get the value of model
     */
    public function getModel() {
        return $this->model;
    }


    /**
     * Get the value of regNo
     */
    public function getRegNo() {
        return $this->regNo;
    }

    /**
     * Get the value of type
     */
    public function getType() {
        return $this->type;
    }
    /**
     * Get the value of year
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * Get the value of vin
     */
    public function getVin() {
        return $this->vin;
    }

    public function getVehicleDetails() {
        return (
            $this->id . ' ' .
            $this->make . ' ' .
            $this->model . ' ' .
            $this->year . ' ' .
            $this->regNo
        );
    }

    public function getMakeModelYear() {
        return (
            $this->make . ' ' .
            $this->model . ' ' .
            $this->year
        );
    }
    /**
     * Set the owner of this vehicle
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * Set the owner of this vehicle
     */
    public function setOwner(Customer $_customer) {
        $this->owner = $_customer;
        $this->owner->setVehicle($this); // passes by reference
    }
}
