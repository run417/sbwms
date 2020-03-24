<?php

namespace sbwms\Model\Inventory\Grn;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Inventory\Grn\Grn;

class GrnFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, GrnEntityManager $_gem) {
        $this->validator = $_v;
        $this->entityManager = $_gem;
    }

    public function validate(array $data) {
        $errors = [];
        $name = $data['items'] ?? '';
        if ($name === '') {
            $errors[] = 'No items received!';
        }
        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(Item $item) {
        exit('no serializing');
    }
}