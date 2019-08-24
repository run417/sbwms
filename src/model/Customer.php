<?php

namespace sbwms;

class Customer {
    private $customerId;
    private $firstName;
    private $lastName;
    private $telephone;
    private $email;

    public function __construct($args = []) {
        $this->customerId = $args['customerId'] ?? null;
        $this->lastName = $args['lastName'] ?? null;
        $this->firstName = $args['firstName'] ?? null;
        $this->telephone = $args['telephone'] ?? null;
        $this->email = $args['email'] ?? null;
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
}