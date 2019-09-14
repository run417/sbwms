<?php

namespace sbwms\Vehicle;

class Vehicle {
    
    /** @var Customer */
    private $owner;

    /** @var string */
    private $id;
    private $make;
    private $model;
    private $regNo;
    private $year;
    private $vin;

    public function __construct(array $properties) {
        $this->id = $properties['id'];
        $this->make = $properties['make'];
        $this->model = $properties['model'];
        $this->regNo = $properties['regNo'];
        $this->year = $properties['year'];
        $this->vin = $properties['vin'];
        $this->owner = $properties['owner'];
    }



    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of make
     */ 
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }


    /**
     * Get the value of regNo
     */ 
    public function getRegNo()
    {
        return $this->regNo;
    }

    /**
     * Get the value of year
     */ 
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Get the value of vin
     */ 
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Get the value of owner
     */ 
    public function getOwner()
    {
        return $this->owner;
    }
}
