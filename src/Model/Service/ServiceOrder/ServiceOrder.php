<?php

namespace sbwms\Model\Service\ServiceOrder;


use DateTimeImmutable;
use sbwms\Model\Service\JobCard\JobCard;
use sbwms\Model\Booking\Booking;
use sbwms\Model\Service\ServiceOrder\ServiceTime;

class ServiceOrder {
    /** @var string */
    private $serviceOrderId;

    /** @var string */
    private $status;

    /** @var Booking */
    private $booking;

    /** @var JobCard */
    private $jobCard;

    /** @var ServiceTime */
    private $time;

    public function __construct(array $args, Booking $_b, JobCard $_j, ServiceTime $_st) {
        $this->serviceOrderId = $args['serviceOrderId'] ?? null;
        $this->status = $args['status'];
        $this->booking = $_b;
        $this->jobCard = $_j;
        $this->time = $_st;
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

    /**
     * Start service timer
     * @param DateTimeImmutable $_datetime
     * @return void
     */
    public function startTimer(DateTimeImmutable $_datetime) {
        $this->time->startTimer($_datetime);
    }

    /**
     * Get the service start datetime
     * @return DateTimeImmutable
     */
    public function getServiceStart() {
        return $this->time->getStartDateTime();
    }

    /**
     * Get service time
     * @return DateInterval
     */
    public function getServiceTime() {
        if ($this->status !== 'ongoing') {
            return $this->time->getStillServiceTime();
        }
        return $this->time->getServiceTime();
    }

    /**
     * Set service status to 'on-hold'
     * @return void
     */
    public function hold() {
        $this->status = 'on-hold';
        $this->time->setServiceOnHoldStart((new DateTimeImmutable()));
    }

    /**
     * Set service status to 'ongoing' and set timing
     * @return void
     */
    public function restart() {
        $this->status = 'ongoing';
        $this->time->setOnholdEnd((new DateTimeImmutable()));
    }

    /**
     * Set service status to complete and setting the finish time
     * @return void
     */
    public function complete() {
        $this->status = 'completed';
        $this->time->setFinishTime((new DateTimeImmutable()));
    }

    /**
     * Set service status to complete and setting the finish time
     * @return void
     */
    public function terminate() {
        $this->status = 'terminated';
        $this->time->setFinishTime((new DateTimeImmutable()));
    }

    /**
     * Get service completion or termination time
     * @return DateTimeImmutable
     */
    public function getServiceFinishTime() {
        return $this->time->getFinishTime();
    }

    /**
     * Get service restart date time
     * @return DateTimeImmutable
     */
    public function getRestartDateTime() {
        return $this->time->getLastOnHoldEnd();
    }

    /**
     * Get the total time the service was on hold
     * @return DateInterval
     */
    public function getServiceOnHoldtime() {
        return $this->time->getOnHoldTime();
    }
}
