<?php

namespace sbwms\Model\Centre\BusinessHours;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;

class BusinessHoursFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, BusinessHoursEntityManager $_scatem) {
        $this->validator = $_v;
        $this->entityManager = $_scatem;
    }

    public function validate(array $data) {
        $errors = [];
        // $firstName = $data['firstName'] ?? '';
        // $lastName = $data['lastName'] ?? '';
        // $telephone = $data['telephone'] ?? '';
        // $email = $data['email'] ?? '';

        // if ($firstName === '') {
        //     $errors[] = 'First name cannot be empty';
        // }
        // if ($lastName === '') {
        //     $errors[] = 'Last name cannot be empty';
        // }
        // if (($telephone === '') && ($email === '')) {
        //     $errors[] = 'Telephone OR email must be provided';
        // }

        // if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(Employee $employee) {
        // $data = [
        //     'employeeId' => $employee->getEmployeeId(),
        //     'firstName' => $employee->getFirstName(),
        //     'lastName' => $employee->getLastName(),
        //     'telephone' => $employee->getTelephone(),
        //     'email' => $employee->getEmail(),
        //     'nic' => $employee->getNic(),
        //     'dateJoined' => $employee->getDateJoined(),
        //     'role' => $employee->getRole(),
        // ];
        // return \json_encode($data);
    }
}

