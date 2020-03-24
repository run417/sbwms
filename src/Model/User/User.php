<?php

namespace sbwms\Model\User;

use sbwms\Model\ProfileInterface;

class User {

    private $userId;
    private $username;
    private $password;
    private $userRole;
    private $accountType;
    private $status;
    private $profile;
    private $dateCreated;


    public function __construct(array $args, ProfileInterface $_profile) {
        $this->userId = $args['userId'] ?? null;
        $this->dateCreated = $args['dateCreated'] ?? null;
        $this->username = $args['username'];
        $this->password = $args['password'];
        $this->status = $args['status'];
        $this->userRole = $args['userRole'];
        $this->profile = $_profile;
        $this->setAccountType();
    }

    /**
     * Get the value of userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get the value of userId
     */
    public function getId()
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
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Get the value of role
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    public function setAccountType() {
        $role = $this->profile->getRole();
        if ($role === 'customer') {
            $this->accountType = \strtolower($role);
        } else {
            $this->accountType = 'staff';
        }
    }

    public function getAccountType() {
        return $this->accountType;
    }

    /**
     * Get the value of dateCreated
     * @return DateTimeImmutable DateTime of user record creation in the database
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
