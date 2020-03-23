<?php


namespace sbwms\Employee;

use DateTime;
use DateInterval;
use DateTimeInterface;
use sbwms\Model\ProfileInterface;
use sbwms\Model\Employee\Schedule;
use sbwms\Model\Service\Type\ServiceType;

class Employee implements ProfileInterface {

    /** @var string */
    private $employeeId;
    private $firstName;
    private $lastName;
    private $telephone;
    private $email;
    private $nic;
    private $birthDate;
    private $role;
    private $dateJoined;
    private $bookingAvailability;
    private $jobCount;

    /** @var array */
    private $serviceTypes = [];

    /** @var Schedule */
    private $schedule;

    /** @var array */
    private $strrole = [
        104 => 'Service Crew',
        105 => 'Service Supervisor',
        106 => 'Sales Assistant',
    ];

    public function __construct(array $args, array $_serviceTypes=[], Schedule $_schedule=null) {
        $this->employeeId = $args['employeeId'] ?? null;
        $this->role = $args['role'];
        $this->bookingAvailability = $args['bookingAvailability'];
        $this->firstName = $args['firstName'];
        $this->lastName = $args['lastName'];
        $this->telephone = $args['telephone'];
        $this->email = $args['email'];
        $this->nic = $args['nic'];

        $this->birthDate = $this->setBirthDate($this->nic);
        $this->dateJoined = $args['dateJoined'];
        $this->jobCount = $args['jobCount'] ?? null;
        // $this->schedule = $this->setSchedule($_schedule);
        // $this->serviceTypes = $this->setServiceTypes($_serviceTypes);
        $this->schedule = $_schedule;
        $this->serviceTypes = $_serviceTypes;
    }

    /**
     * Alias of getEmployeeId to conform to ProfileInterface
     */
    public function getId(){
        return $this->getEmployeeId();
    }

    public function getAllRoles() {
        return $this->strrole;
    }

    public function getRoleId() {
        return $this->role;
    }
    /**
     * Get the value of employeeId
     */
    public function getEmployeeId() {
        return $this->employeeId;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName() {
        return $this->lastName;
    }

    public function getFullName() {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getFormattedRole() {
        return $this->getRole();
    }

    /**
     * Get the value of telephone
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Get the value of email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Get the value of nic
     */
    public function getNic() {
        return $this->nic;
    }

    /**
     * Get the value of role
     */
    public function getRole() {
        return $this->strrole[$this->role];
    }

    /**
     * Get the value of dataJoined
     */
    public function getDateJoined() {
        return $this->dateJoined;
    }

    /**
     * Get the value of Shift start
     */
    public function getShiftStart() {
        return $this->schedule->getShiftStartTime();
    }

    /**
     * Get the value of Shift end
     */
    public function getShiftEnd() {
        return $this->schedule->getShiftEndTime();
    }

    public function setBirthDate(string $nic) {
        $year = '0000';
        $days = 000;
        if(strlen($nic) === 10) {
          $year = '19' . \substr($nic, 0, 2);
          $days = (int) \substr($nic, 2, 3);
        } else if (strlen($nic) === 12) {
          $year = substr($nic, 0, 4);
          $days = (int) \substr($nic, 4, 3);
        } else {
            return '0000-00-00';
        }
        $days = ($days > 500) ? ($days - 500) : $days;
        $year = new DateTime($year . '-01-00');
        $year->add((new DateInterval('P' . $days . 'D')));
        $birthDate = $year->format('Y-m-d');
        return $birthDate;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * Set the value of shift
     *
     * @return  self
     */
    public function setShift($shift) {
        $this->shift = $shift;
        return $this;
    }

    public function getAvailability(ServiceType $s, DateTimeInterface $date) {
        $schedule = $this->schedule->getAvailableTimes($s, $date);
        return $schedule;
    }


    public function getServiceTypes() {
        return $this->serviceTypes;
    }

    public function setServiceTypes(array $st) {
        if ($this->role === '104') {
            // var_dump($st);
            $this->serviceTypes = $st;
        } else {
            $this->serviceTypes = [];
        }
    }

    public function setSchedule(Schedule $s) {
        if ($this->role === '104') {
            $this->schedule = $s;
        } else {
            $this->schedule = null;
        }
    }

    public function getServiceTypeIds() {
        $ids = [];
        foreach ($this->serviceTypes as $st) {
            $ids[] = $st->getId();
        }
        return $ids;
    }

    public function getBookingAvailability() {
        return $this->bookingAvailability;
    }

    public function getJobCount() {
        return $this->jobCount;
    }
}
