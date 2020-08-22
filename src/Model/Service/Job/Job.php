<?php

namespace sbwms\Model\Service\Job;

use sbwms\Model\Booking\Booking;
use DateTimeInterface;

class Job {
    private $jobId;
    private $booking;
    private $status;
    private $startDateTime;

    public function __construct(Booking $_b, string $_status, DateTimeInterface $_sdt, string $_id = null) {
        $this->jobId = $_id;
        $this->booking = $_b;
        $this->status = $_status;
        $this->startDateTime = $_sdt;
    }

    /**
     * Get the value of jobId
     * @return string|null
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the booking object
     * @return Booking
     */
    public function getBooking() {
        return $this->booking;
    }

    /**
     * Get the status of service job
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }
}