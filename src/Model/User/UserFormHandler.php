<?php

namespace sbwms\Model\User;

use sbwms\Model\CustomerRepository;
use sbwms\Model\Employee\EmployeeRepository;
use sbwms\Model\Validator;
use sbwms\Model\User\UserEntityManager;

class UserFormHandler {
    private $validator;
    private $userEntityManager;
    private $customerRepository;
    private $employeeRepository;
    private $errors = [];

    public function __construct(
        Validator $_validator,
        UserEntityManager $_userEntityManager,
        CustomerRepository $_customerRepository,
        EmployeeRepository $_employeeRepository
        ) {
        $this->validator = $_validator;
        $this->userEntityManager = $_userEntityManager;
        $this->customerRepository = $_customerRepository;
        $this->employeeRepository = $_employeeRepository;
    }

    public function validate(array $data) {
        $userRole = $data['userRole'] ?? '';
        $profileId = $data['profileId'] ?? '';
        $status = $data['status'] ?? '';
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if (!empty($this->errors)) $this->errors['validationError'];
        return $this->errors;
        // if ($userRole )
    }

    public function createEntity(array $data) {
        return $this->userEntityManager->createEntity($data);
    }



    public function findProfilesSansAccount(string $userRole) {
        if ($userRole === 'customer') {
            return $this->customerRepository->findAllSansAccount();
        } else {
            return $this->employeeRepository->findAllSansAccount();
        }
    }

    public function isUserRoleInValid(string $userRole) { // note: invalid
        return !($this->validator->isUserRoleValid($userRole)); // note: valid
    }

    public function isUsernameUnique(string $username) {
        return $this->validator->isUsernameUnique($username);
    }

}
