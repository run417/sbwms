<?php

namespace sbwms\Model\Booking;

use DateTimeImmutable;
use sbwms\Model\Vehicle\Vehicle;
use sbwms\Model\Employee\Employee;
use sbwms\Model\Service\Type\ServiceType;

class Booking {
    /** @var string */
    private $bookingId;
    private $status;
    private $creationDate;
    private $initiator;

    /** @var Vehicle */
    private $vehicle;

    /** @var DateTimeImmutable */
    private $startDateTime;

    /** @var Employee */
    private $employee;

    /** @var array An array of ServiceType instances */
    private $serviceType;


    public function __construct(
        Vehicle $_vehicle,
        Employee $_employee,
        DateTimeImmutable $_dateTime,
        ServiceType $_serviceType,
        string $_bookingId = null,
        string $_status = null,
        string $_creationDate = null
    ) {
        $this->vehicle = $_vehicle;
        $this->employee = $_employee;
        // $this->customer = $_vehicle->getOwner();
        $this->startDateTime = $_dateTime;
        $this->addServiceType($_serviceType);
        $this->bookingId = $_bookingId;
        $this->status = $_status;
        $this->creationDate = $_creationDate;
    }

    /**
     * Get the value of bookingId
     */
    public function getBookingId() {
        return $this->bookingId;
    }

    /**
     * Get the value of bookingId
     */
    public function getId() {
        return $this->bookingId;
    }

    public function setPendingStatus() {
        $this->setStatus('pending');
    }

    /**
     * Set booking status to 'confirmed'
     */
    public function confirm() {
        $this->setStatus('confirmed');
    }

    /**
     * Set booking status to 'realized'
     * @return void
     */
    public function realize() {
        $isConfirmed = $this->getStatus() === 'confirmed';
        $isStartDateValid = $this->getStartDateTime() > (new DateTimeImmutable());
        if ($isConfirmed && $isStartDateValid) {
            $this->setStatus('realized');
        } else {
            exit('booking class - cannot realize booking');
        }
    }

    /**
     * Get the status of the booking
     */
    public function getStatus() {
        return $this->status;
    }

    public function setStatus(string $status) {
        if ($status === 'pending' || $status === 'confirmed' || $status === 'realized' || $status === 'cancelled') {
            $this->status = $status;
        } else {
            exit($status . ' status is not recognized!');
        }
    }

    public function addServiceType(ServiceType $_serviceType) {
        $this->serviceType = $_serviceType;
    }

    /**
     * @return array
     */
    public function getServiceType() {
        return $this->serviceType;
    }

    /**
     * Get the value of customer
     */
    public function getCustomer() {
        return $this->vehicle->getOwner();
    }

    /**
     * Get the value of vehicle
     * @return Vehicle
     */
    public function getVehicle() {
        return $this->vehicle;
    }

    /**
     * Get the value of employee
     * @return Employee
     */
    public function getEmployee() {
        return $this->employee;
    }

    /**
     * Get the value of startDateTime
     * @return DateTimeImmutable
     */
    public function getStartDateTime() {
        return $this->startDateTime;
    }
}
