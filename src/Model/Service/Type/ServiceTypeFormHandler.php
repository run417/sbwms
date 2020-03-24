<?php

namespace sbwms\Model\Service\Type;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Service\Type\ServiceType;

class ServiceTypeFormHandler implements FormHandlerInterface{
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, ServiceTypeEntityManager $_stem) {
        $this->validator = $_v;
        $this->entityManager = $_stem;
    }

    public function validate(array $data) {
        $errors = [];

        $name = $data['name'] ?? '';
        $hours = $data['hours'] ?? '';
        $minutes = $data['minutes'] ?? '';

        if ($name === '') {
            $errors[] = 'Service type name cannot be empty';
        }
        if ($hours === '') {
            $errors[] = 'Service hours is not set';
        }
        if ($minutes === '') {
            $errors[] = 'Service minutes is not set';
        }
        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    public function serialize(ServiceType $servicetype) {
        $hours = $servicetype->getDuration()->format('%hH');
        $minutes = $servicetype->getDuration()->format('%iM');
        $data = [
            'serviceTypeId' => $servicetype->getId(),
            'name' => $servicetype->getName(),
            'status' => $servicetype->getStatus(),
            'hours' => $hours,
            'minutes' => $minutes,
        ];
        return \json_encode($data);
    }

    public function isServiceTypeNameUnique(string $name, $currentId) {
        return $this->validator->isServiceTypeNameUnique($name, $currentId);
    }
}

