<?php

namespace sbwms\User;

class User {

    private $userId;
    private $username;
    private $password;
    private $status;
    private $typeId;
    private $role;
    
    private $type;
    
    public function __construct(array $args) {
        $this->userId = $args['userId'] ?? null;
        $this->username = $args['username'] ?? null;
        $this->password = $args['password'] ?? null;
        $this->status = $args['status'] ?? null;
        $this->typeId = $args['typeId'] ?? null;
        $this->role = $args['role'] ?? null;
        $this->type = $args['type'] ?? null;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of typeId
     */ 
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

}