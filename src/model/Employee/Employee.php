<?php


namespace sbwms\Employee;

class Employee {

    /** @var string */
    private $employeeId;
    private $firstName;
    private $lastName;
    private $telephone;
    private $email;
    private $nic;
    private $role;
    private $dateJoined;

    private $strrole = [
        104 => 'Service Crew',
        105 => 'Service Supervisor',
        106 => 'Sales Assistant',
    ];

    public function __construct(array $args) {
        $this->employeeId = $args['employeeId'] ?? null;
        $this->firstName = $args['firstName'] ?? null;
        $this->lastName = $args['lastName'] ?? null;
        $this->telephone = $args['telephone'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->nic = $args['nic'] ?? null;
        $this->role = $args['role'] ?? null;
        $this->dateJoined = $args['dateJoined'] ?? null;
    }

    /**
     * Get the value of employeeId
     */ 
    public function getEmployeeId()
    {
        return $this->employeeId;
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
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getFormattedRole() {
        return $this->strrole[$this->getRole()];
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
     * Get the value of nic
     */ 
    public function getNic()
    {
        return $this->nic;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the value of dataJoined
     */ 
    public function getDateJoined()
    {
        return $this->dateJoined;
    }
}