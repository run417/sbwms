<?php

namespace sbwms\Model\Inventory\Supplier;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Inventory\Supplier\Supplier;

class SupplierFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, SupplierEntityManager $_sutem) {
        $this->validator = $_v;
        $this->entityManager = $_sutem;
    }

    public function validate(array $data) {
        $errors = [];

        $name = $data['supplierName'] ?? '';
        $company = $data['companyName'] ?? '';
        $telephone = $data['telephone'] ?? '';
        $email = $data['email'] ?? '';

        if ($name === '') {
            $errors[] = 'Supplier Name cannot be empty';
        }

        if ($company === '') {
            $errors[] = 'Company Name cannot be empty';
        }

        if ($telephone === '') {
            $errors[] = 'Telephone cannot be empty';
        }

        if ($email === '') {
            $errors[] = 'Email cannot be empty';
        }

        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(Supplier $supplier) {
        $data = [
            'supplierId' => $supplier->getSupplierId(),
            'supplierName' => $supplier->getSupplierName(),
            'companyName' => $supplier->getCompanyName(),
            'telephone' => $supplier->getTelephone(),
            'email' => $supplier->getEmail(),
        ];
        return \json_encode($data);
    }
}