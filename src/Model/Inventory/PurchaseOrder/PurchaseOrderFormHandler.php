<?php

namespace sbwms\Model\Inventory\PurchaseOrder;

use sbwms\Model\Validator;
use sbwms\Model\FormHandlerInterface;

class PurchaseOrderFormHandler implements FormHandlerInterface {
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, PurchaseOrderEntityManager $_pem) {
        $this->validator = $_v;
        $this->entityManager = $_pem;
    }

    public function validate(array $data) {
        $errors = [];
        $name = $data['date'] ?? '';
        if ($name === '') {
            $errors[] = 'Purchase Order date cannot be empty';
        }
        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(PurchaseOrder $subcategory) {
        $data = [];
        return \json_encode($data);
    }
}