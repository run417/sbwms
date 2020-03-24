<?php

namespace sbwms\Model;

use sbwms\Model\ProfileInterface;
use sbwms\Model\Vehicle\Vehicle;

class Customer implements ProfileInterface {
    private $customerId;
    private $title;
    private $firstName;
    private $lastName;
    private $telephone;
    private $email;
    private $regDate;

    /** @var array An array of Vehicle instances */
    private $vehicles;

    public function __construct($args = []) {
        $this->customerId = $args['customerId'] ?? null;
        $this->title = $args['title'] ?? null;
        $this->firstName = $args['firstName'] ?? null;
        $this->lastName = $args['lastName'] ?? null;
        $this->telephone = $args['telephone'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->regDate = $args['regDate'] ?? null;
    }

    /**
     * Get the value of customer id
     * Alias of getCustomerId to conform to ProfileInterface
     */
    public function getId(){
        return $this->getCustomerId();
    }

    public function getRole(){
        return 'customer';
    }
    /**
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName() {
        return $this->getTitle() . ' ' . $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * Get the value of telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of regDate
     */
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the vehicles owned by this customer
     */
    public function setVehicle(Vehicle $_vehicle) {
        $this->vehicles[] = $_vehicle;
    }

    /**
     * Get the vehicles owned by this customer
     *
     * @return array An array of Vehicle instancess
     */
    public function getVehicles() {
        return $this->vehicles ?? [];
    }
}