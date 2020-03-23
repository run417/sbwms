<?php

namespace sbwms\Model\Booking;

use sbwms\Model\FormHandlerInterface;
use sbwms\Model\Validator;
use sbwms\Model\Booking\BookingEntityManager;
use sbwms\Model\Service\ServiceOrder\ServiceOrderEntityManager;
use sbwms\Model\Service\Type\ServiceTypeRepository;
use sbwms\Model\Vehicle\VehicleRepository;

class BookingFormHandler implements FormHandlerInterface {
    private $validator;
    private $entityManager;

    public function __construct(Validator $_v, BookingEntityManager $_soem) {
        $this->validator = $_v;
        $this->entityManager = $_soem;
    }

    public function validate(array $data) {
        $errors = [];

        $serviceType = $data['serviceType'] ?? '';
        $vehicle = $data['vehicle'] ?? '';
        $timeSlot = $data['timeSlot'] ?? '';

        if ($serviceType === '') {
            $this->errors['serviceType'] = "Please select a service";
        } elseif (!$this->validator->isServiceTypeValid($serviceType)) {
            $this->errors['serviceType'] = "Invalid service selected. Please refresh page and try again";
        }

        if ($timeSlot === '') {
            $this->errors['timeSlot'] = "Please select a time slot";
        }
        if ($vehicle === '') {
            $this->errors['vehicle'] = "Please select a customer";
        }

        if (!empty($errors)) { $errors['validationError'] = true; }
        return $errors;
    }

    public function createEntity(array $data) {
        return $this->entityManager->createEntity($data);
    }

    // // if entity manager is for service order
    // public function getServiceTypes() {
    //     return $this->entityManager->getBookingEntityManager()->getServiceTypes();
    // }
    // public function getVehicles() {
    //     return $this->entityManager->getBookingEntityManager()->getVehicles();
    // }

    public function getServiceTypes() {
        return $this->entityManager->getServiceTypes();
    }

    public function getVehicles() {
        return $this->entityManager->getVehicles();
    }

}
