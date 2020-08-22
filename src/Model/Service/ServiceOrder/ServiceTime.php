<?php

namespace sbwms\Model\Service\ServiceOrder;

use DateInterval;
use DateTimeImmutable;

class ServiceTime {
    /** @var DateTimeImmutable */
    private $startDateTime;

    /** @var DateTimeImmutable */
    private $finishDateTime;

    /** @var DateTimeImmutable */
    private $lastOnHoldStart;

    /** @var DateTimeImmutable */
    private $lastOnHoldEnd;

    /** @var DateInterval */
    private $serviceTime;

    /** @var DateInterval */
    private $onHoldTime;

    public function __construct(
        DateTimeImmutable $_sdt = null,
        DateTimeImmutable $_fdt = null,
        DateInterval $_st = null,
        DateTimeImmutable $_los = null,
        DateTimeImmutable $_loe = null,
        DateInterval $_ot = null
    ) {
        $this->startDateTime = $_sdt;
        $this->finishDateTime = $_fdt;
        $this->serviceTime = $_st;
        $this->lastOnHoldStart = $_los;
        $this->lastOnHoldEnd = $_loe;
        $this->onHoldTime = $_ot;
    }

    public function startTimer(DateTimeImmutable $now) {
        if ($this->startDateTime) {
            var_dump($this->startDateTime);
            exit('service is already started');
        }
        $this->startDateTime = $now;
    }

    /**
     * Set restart service time.
     * Set on hold ending time and calculate on hold time and service time.
     * @return void
     */
    public function setOnholdEnd(DateTimeImmutable $now) {
        $this->lastOnHoldEnd = $now;
        $onHoldTime = $this->lastOnHoldStart->diff($now);
        $this->setOnHoldTime($onHoldTime);
    }

    /**
     * @return void
     */
    public function setOnHoldTime(DateInterval $onHoldTime) {
        if ($this->onHoldTime !== null) {
            $tempDate = new \DateTime('00:00:00');
            $cloneTemp = clone $tempDate;
            $tempDate->add($this->onHoldTime);
            $tempDate->add($onHoldTime);
            $this->onHoldTime = $cloneTemp->diff($tempDate); // add if onHoldTime is not null
        } else {
            $this->onHoldTime = $onHoldTime;
        }
    }

    /**
     * @return DateInterval
     */
    public function getOnHoldTime() {
        return $this->onHoldTime;
    }

    /**
     * Set on hold start date time and calculate service time
     * @return void
     */
    public function setServiceOnHoldStart(DateTimeImmutable $now) {
        $this->lastOnHoldStart = $now;
        $serviceTime = $this->startDateTime->diff($now);
        $this->setServiceTime($serviceTime);
    }

    public function getServiceTime() {
        // exit(var_dump($this->startDateTime));
        if ($this->onHoldTime !== null) {
            $serviceTimeIncHoldTime = (new DateTimeImmutable())->diff($this->startDateTime);
            $tempDate = new \DateTime('00:00:00');
            $cloneTemp = clone $tempDate;
            $tempDate->add($serviceTimeIncHoldTime);
            $tempDate->sub($this->onHoldTime);
            return $cloneTemp->diff($tempDate);
        }
        return $this->startDateTime->diff((new DateTimeImmutable()));
    }

    public function getStillServiceTime() {
        // exit(var_dump($this->startDateTime));
        return $this->serviceTime;
    }

    /**
     * Set total service time
     * @return void
     */
    public function setServiceTime(DateInterval $serviceTime) {
        if ($this->serviceTime !== null) {
            $tempDate = new \DateTime('00:00:00');
            $cloneTemp = clone $tempDate;
            $tempDate->add($this->serviceTime);
            $tempDate->add($serviceTime);
            $this->serviceTime = $cloneTemp->diff($tempDate); // add if onHoldTime is not null
        } else {
            $this->serviceTime = $serviceTime; // when setting service time for the first time
        }
    }

    public function getStartDateTime() {
        return $this->startDateTime;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getLastOnHoldStart() {
        return $this->lastOnHoldStart;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getLastOnHoldEnd() {
        return $this->lastOnHoldEnd;
    }

    public function setFinishTime(DateTimeImmutable $now) {
        $this->finishDateTime = $now;
    }

    public function getFinishTime() {
        return $this->finishDateTime;
    }
}
