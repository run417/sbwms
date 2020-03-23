<?php

namespace sbwms\Model\Service\ServiceOrder;

use sbwms\Model\Service\JobCard\JobCard;
use sbwms\Model\Booking\Booking;

class ServiceOrder {
    private $serviceOrderId;
    private $booking;
    private $jobCard;
    private $status;

    public function __construct(array $args, Booking $_b, JobCard $_j) {
        $this->serviceOrderId = $args['serviceOrderId'] ?? null;
        $this->status = $args['status'];
        $this->booking = $_b;
        $this->jobCard = $_j;
    }

    /**
     * Get the value of serviceOrderId
     */
    public function getId() {
        return $this->serviceOrderId;
    }

    /**
     * Get the value of booking
     */
    public function getBooking() {
        return $this->booking;
    }

    /**
     * Get the value of jobCard
     */
    public function getJobCard() {
        return $this->jobCard;
    }

    /**
     * Get the value of status
     */
    public function getStatus() {
        return $this->status;
    }
}