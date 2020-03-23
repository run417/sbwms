<?php

namespace sbwms\Model\Employee;

use sbwms\Model\Service\Type\ServiceType;
use sbwms\Model\Employee\Entry;
use sbwms\Model\Employee\Shift;

use DateTimeInterface;
use DateTimeImmutable;
use sbwms\Model\SystemDateTime;

class Schedule {

    /** @var array Collection of Entry / Time slot instances */
    private $jobs;

    /** @var Shift */
    private $shift;

    /** @var array */
    private $assignedJobs;

    private $operatingDate;

    public function __construct(Shift $_shift, $_jobs = []) {
        $this->shift = $_shift;
        $this->jobs = $_jobs;
    }

    public function filterByDate() {
        $filtered = [];
        $date = $this->getOpDate();
        foreach ($this->jobs as $j) {
            if ($j->getDate() === $date->format('Y-m-d')) {
            //    echo ('has jobs assigned on this date<br>');
               $filtered[] = $j;
            }
        }
        return $filtered;
    }

    public function assignServiceJob() {}

    public function isEmpty() {
        return empty($this->jobs);
    }

    private function getCurrentDateTime() {
        // return (new DateTimeImmutable())->add(new \DateInterval('PT1M'));
        // return (new DateTimeImmutable());
        return SystemDateTime::currentDateTime();
        // return DateTimeImmutable::createFromFormat('H:i', '16:01');
    }

    /**
     * @param array $jobs
     * @return array $schedule
     */
    private function makeSchedule(array $jobs) {
        if (!isset($this->operatingDate)) { exit('Schedule date is not set'); }
        $schedule = $jobs;

        // make shift start entry
        $todate = $this->getCurrentDateTime()->format('Y-m-d');
        $currentDate = $this->getOpDate()->format('Y-m-d');
        $shiftStartEntry = new Entry([
            'type' => 'shift',
            'date' => $this->getOpDate()->format('Y-m-d'),
            'start' => ($todate === $currentDate) ? $this->getCurrentDateTime() : $this->getShiftStartDateTime(), // the scheduleService filters if the time is greater than centre closing time.
        ]);

        $shiftEndEntry = new Entry([
            'type' => 'shift',
            'date' => $this->getOpDate()->format('Y-m-d'),
            'start' => $this->getShiftEndDateTime(),
        ]);

        $breakEntry = $this->getBreakEntry();


        array_push($schedule, $breakEntry);
        usort($schedule, [$this, 'sortSchedule']);
        array_unshift($schedule, $shiftStartEntry);
        array_push($schedule, $shiftEndEntry);
        return $schedule;
    }

    /**
     * @param ServiceType
     * @param DateTime
     * @return array
     */
    public function getAvailableTimes(ServiceType $s, DateTimeInterface $d) {
        // check if leave, holiday (in this class or employee class)
        // check whether a break is applicable to the current date
        $date = $this->setOperatingDate($d);

        $jobs = $this->filterByDate();
        $schedule = $this->makeSchedule($jobs);
        // usort($schedule, [$this, 'sortSchedule']); // end time sort? check for same endtime
        // var_dump($schedule);
        // exit();
        $jobCount = count($jobs);
        // echo "has $jobCount jobs assigned<br>";

        // add duration to shift start and compare it. if new time is
        // less than the start time of the 1st entry of jobs then (in this case)
        // the shift start is a possible start time. (also note the left over
        // time if any for possible uses). if not move to the second entry and
        // repeat. if there are no other entries then compare the current entry
        // end time with the shift end time and note possible job start times.

        $duration = $s->getDuration();
        $i = 0;
        $num = count($schedule);
        $timeSlots = [];

        foreach ($schedule as $key => $entry) {
            $todate = $this->getCurrentDateTime()->format('Y-m-d');
            $currentDate = $this->getOpDate()->format('Y-m-d');
            if (($todate === $currentDate)
                && ($this->getCurrentDateTime() >= $entry->getEnd())
                && ($entry->getType() !== 'shift')) {
                // var_dump($entry);
                unset($schedule[$key]);
            }
        }
        $schedule = array_values($schedule);
        // exit(var_dump($schedule));

        foreach ($schedule as $entry) {
            // var_dump($schedule);
            // exit();
            $t1 = $entry->getEnd()->add($duration);
            $t2 = $entry->getEnd();
            $next = isset($schedule[$i+1]) ? $schedule[$i+1]->getStart() : null;
            while ($next && $t1 <= $next) {
                // $timeSlots[] = $t2->format('Y-m-d H:i:s');
                // the below format is used as input value
                $timeSlots[] = $t2->format('YmdHi');
                // echo "{$t2->format('Y-m-d H:i:s')}<br>";
                // taking out the break / schedule around the break time
                $t2 = $t2->add($duration); // when this is 16:30
                $t1 = $t1->add($duration); // this is 18:30

                // var_dump($diff);
                // recalculate by adding the left over time to the beginning
                if (($t2 < $next) && !($t1 <= $next)) {
                    // if (!($t1 <= $next) && ($diff <= $duration)) {
                        // diff < duration
                        // echo "has left over time<br>";

                    $diff = $t2->diff($next);
                    // reinitialize values t1 and t2
                    $t1 = $entry->getEnd()->add($duration);
                    $t2 = $entry->getEnd();

                    $t2 = $t2->add($diff);

                    while ($next && $t1 <= $next) {
                        // $timeSlots[] = $t2->format('Y-m-d H:i:s');
                        $timeSlots[] = $t2->format('YmdHi');
                        // echo "{$t2->format('Y-m-d H:i:s')}<br>";
                        $t2 = $t2->add($duration); // when this is 16:30
                        $t1 = $t1->add($duration); // this is 18:30
                    }
                    // add the left over to the last possible start time to create another possible start time (overlapping start times)
                    // diff $t2 from $next->getStart() and add to possible start to create an overlapping start time. (note mutables)
                }
            }
            // \var_dump($t2);
            // \var_dump($diff);
            $i += 1;
        }
        return $timeSlots;
    }

    private function sortSchedule($a, $b) {
        if ($a->getEnd() == $b->getEnd()) { return 0; }
        return ($a->getEnd() < $b->getEnd()) ? -1 : 1;
    }

    /**
     * @return DateTimeImmutable
     */
    private function getShiftStartDateTime() {
        $date = $this->getOpDate()->format('Y-m-d');
        $time = $this->getShiftStartTime();
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);
        return $dateTime;
    }

    /**
     * @return DateTimeImmutable
     */
    private function getShiftEndDateTime() {
        $date = $this->getOpDate()->format('Y-m-d');
        $time = $this->getShiftEndTime();
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);
        return $dateTime;
    }

    /**
     * @return Entry
     */
    private function getBreakEntry() {
        $startTimeStr = $this->getBreakStartTime();
        $endTimeStr = $this->getBreakEndTime();
        $dateStr = $this->getOpDate()->format('Y-m-d');
        $start = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $dateStr . ' ' . $startTimeStr
        );
        $end = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $dateStr . ' ' . $endTimeStr
        );
        return new Entry([
            'start' => $start,
            'end' => $end,
            'date' => $dateStr,
            'type' => 'break',
        ]);
    }


    public function getShiftStartTime() {
        return $this->shift->getShiftStart();
    }

    public function getShiftEndTime() {
        return $this->shift->getShiftEnd();
    }

    public function getBreakStartTime() {
        return $this->shift->getBreakStart();

    }

    public function getBreakEndTime() {
        return $this->shift->getBreakEnd();
    }

    public function setShiftStart() {}

    public function setShiftEnd() {}

    private function getOpDate() {
        return $this->operatingDate;
    }

    private function setOperatingDate(DateTimeInterface $date) {
        $this->operatingDate = $date;
        return $this->operatingDate;
    }
}
