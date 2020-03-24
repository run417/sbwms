<?php

namespace sbwms\Model\Booking;

use sbwms\Model\Service\Type\ServiceTypeRepository;
use sbwms\Model\Employee\EmployeeRepository;
use DateTimeImmutable;
use DateInterval;
use DatePeriod;
use sbwms\Model\SystemDateTime;

class ScheduleService {

    private $serviceCenterOptions;
    private $bookingDateRange;
    private $serviceTypeRepository;
    private $employeeRepository;

    public function __construct(
        ServiceTypeRepository $_serviceTypeRepository,
        EmployeeRepository $_employeeRepository
    ) {
        $this->serviceTypeRepository = $_serviceTypeRepository;
        $this->employeeRepository = $_employeeRepository;
        $this->bookingDateRange = 7;

    }

    /**
     *
     * Todo:
     * * if service type not valid
     * @param string Service Type Id like 'ST0001'
     * @return array Time slots for the provided service type
     */
    private function getTimeSlot($serviceTypeId) {
        // find the service type object from database
        $serviceType = $this->serviceTypeRepository->findById($serviceTypeId);
        // find all employees who perform the above service
        $employees = $this->employeeRepository->findAllByBookingAndService($serviceType->getServiceTypeId());
        //below data should be from database or config
        $centreClosingTime = DateTimeImmutable::createFromFormat('H:i', '17:00');
        // $currentTime = DateTimeImmutable::createFromFormat('H:i', '10:00');
        $currentTime = SystemDateTime::currentDateTime();
        $start = new DateTimeImmutable();
        // $start = DateTimeImmutable::createFromFormat('H:i', '10:00');
        // if current time is greater than the day then start from the next day
        if ($currentTime >= $centreClosingTime) { // what if midnight?
            $start = $start->add((new DateInterval('P1D')))->setTime(9,0);
        }

        $days = $this->bookingDateRange; // +1 to include last day in loop
        $range = new DateInterval("P{$days}D");
        $end = $start->add($range);
        $interval = new DateInterval("P1D");
        $period = new DatePeriod($start, $interval, $end);

        $dayEmployeeTimeSlots = [];
        foreach ($period as $date) {
            // exit(var_dump($date));
            $employeeTimeSlot = [];
            foreach ($employees as $e) {
                $employeeTimeSlot[$e->getEmployeeId()] = $e->getAvailability($serviceType, $date);
                $dayEmployeeTimeSlots[$date->format('Y-m-d')] = $employeeTimeSlot;
            }
        }

        return $dayEmployeeTimeSlots;
    }

    // public function getAllTimeSlots($serviceTypeId) {
    //     return $this->getTimeSlot($serviceTypeId);
    // }

    public function getTimeSlotArray(string $serviceTypeId) {
        $dayEmployeeTimeSlots = $this->getTimeSlot($serviceTypeId);
        // prepare data for the select html element
        $date = [];
        $uniquePerDayTs = [];
        foreach ($dayEmployeeTimeSlots as $day => $employees) {
            $stringDay = (DateTimeImmutable::createFromFormat('Y-m-d', $day))->format("l d/m");
            foreach ($employees as $timeslots) {
                foreach ($timeslots as $t) {
                    // if (!isset($date[$stringDay])) { $date[$stringDay][] = $key; }
                    // if (!in_array($key, $date[$stringDay]) && array_key_exists($stringDay, $date)) {
                    //     $date[$stringDay][] = $key;
                    if (!in_array($t, $uniquePerDayTs)) {
                        $uniquePerDayTs[] = $t;
                        // $date[$stringDay][] = $t;
                        $date[$stringDay][] = [(DateTimeImmutable::createFromFormat('YmdHi', $t))->format("h:i A"), $t];
                    }
                }
            }
        }


        return $date;
    }

    public function getTimeSlotSelectHTMLPartial(string $serviceTypeId) {
        $timeSlots = $this->getTimeSlotArray($serviceTypeId);
        $htmlString = "";
        foreach ($timeSlots as $day => $slot) {
            $htmlString .= "<optgroup label=\"$day\">";
            foreach ($slot as $s) {
                $htmlString .= "<option value=\"$s[1]\">$s[0]</option>";
            }
            $htmlString .= "</optgroup>";
        }

        return $htmlString;
    }

    public function getEmployeeFromTimeSlot(string $timeSlot, string $serviceTypeId) {
        // most likely you won't have to generate time slots every time
        // you can put them in a session and check
        $dayEmployeeTimeSlots = $this->getTimeSlot($serviceTypeId);
        $timeSlotEmployee = [];
        foreach ($dayEmployeeTimeSlots as $day => $employeeTimeSlots) {
            foreach ($employeeTimeSlots as $employeeId => $timeSlots) {
                foreach ($timeSlots as $slot) {
                    // $timeSlotEmployee[$day][$daySlots][] = $employeeId;
                    $timeSlotEmployee[$slot][] = $employeeId;
                }
            }
        }

        // get the employees for the time slot
        $employeeList = [];
        if (\array_key_exists($timeSlot, $timeSlotEmployee)) {
            $employeeList = $timeSlotEmployee[$timeSlot];
        } else {
            echo 'Invalid TimeSlot';
            exit();
        }

        // select an employee randomly from the employee list
        $employee = null;
        if (!empty($employeeList)) {
            $i = rand(0, (count($employeeList)-1));
            $employee = $employeeList[$i];
        }

        return $employee;
    }
}
