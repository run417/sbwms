<?php

namespace sbwms\Model\Service\Bay;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Service\Bay\Bay;

class BayFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, BayEntityManager $_bayem) {
        $this->validator = $_v;
        $this->entityManager = $_bayem;
    }

    public function validate(array $data) {
        $errors = [];

        $type = $data['bayType'] ?? '';
        $status = $data['bayStatus'] ?? '';

        if ($type === '') {
            $errors[] = 'Bay type cannot be empty';
        }

        if ($status === '') {
            $errors[] = 'Bay status cannot be empty';
        }

        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(Bay $bay) {
        $data = [
            'bayId' => $bay->getBayId(),
            'bayType' => $bay->getBayType(),
            'bayStatus' => $bay->getBayStatus(),
        ];
        return \json_encode($data);
    }
}