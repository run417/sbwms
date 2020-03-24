<?php

namespace sbwms\Model\User;

use sbwms\Model\CustomerRepository;
use sbwms\Model\Employee\EmployeeRepository;
use sbwms\Model\User\User;
use DateTimeImmutable;

class UserEntityManager {
    private $customerRepository;
    private $employeeRepository;

    public function __construct(CustomerRepository $_cr, EmployeeRepository $_er) {
        $this->customerRepository = $_cr;
        $this->employeeRepository = $_er;
    }

    public function createEntity(array $data) {
        if (!isset($data['dataSource'])) exit('data source not set');
        $user = null;

        if ($data['dataSource'] === 'user') {
            $user = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $user = $this->createFromDbRecord($data);
        }

        return $user;
    }

    public function createFromUserData(array $data) {
        $arguments = [
            'userRole' => $data['userRole'],
            'status' => $data['status'],
            'username' => $data['username'],
            'password' => $data['password'],
        ];
        if ($data['userRole'] === 'customer') {
            $profile = $this->customerRepository->findById($data['profileId']);
        } else {
            $profile = $this->employeeRepository->findById($data['profileId']);
        }
        $user = new User($arguments, $profile);
        return $user;
    }

    public function createFromDbRecord(array $data) {
        $arguments = [
            'userId' => $data['user_id'],
            'userRole' => $data['user_role'],
            'status' => $data['user_status'],
            'username' => $data['username'],
            'password' => $data['hashed_password'],
            'dateCreated' => new DateTimeImmutable($data['creation_date']),
        ];
        if ($data['user_role'] === 'customer') {
            $profile = $this->customerRepository->findById($data['profile_id']);
        } else {
            $profile = $this->employeeRepository->findById($data['profile_id']);
        }
        $user = new User($arguments, $profile);
        return $user;
    }
}