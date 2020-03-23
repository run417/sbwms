<?php

namespace sbwms\Model\Employee;

use DateTimeImmutable;
use DateInterval;
use sbwms\Model\Employee\Employee;
use sbwms\Model\Employee\Shift;
use sbwms\Model\Employee\Schedule;
use sbwms\Model\Employee\Entry;
use sbwms\Model\Service\Type\ServiceType;
use sbwms\Model\Service\Type\ServiceTypeEntityManager;
use sbwms\Model\Service\Type\ServiceTypeRepository;

class EmployeeEntityManager {
    private $serviceTypeEntityMangager;
    private $serviceTypeRepository;

    public function __construct(ServiceTypeEntityManager $_stem, ServiceTypeRepository $_str) {
        $this->serviceTypeEntityMangager = $_stem;
        $this->serviceTypeRepository = $_str;
    }

    public function createEntity($data) {
        if (!isset($data['dataSource'])) exit('data source not set');

        $employee = null;

        if ($data['dataSource'] === 'user') {
            $employee = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $employee = $this->createFromDbRecord($data);
        }

        return $employee;
    }

    private function createFromUserData(array $data) {
        $arguments = [
            'employeeId' => $data['employeeId'] ?? null,
            // 'title' => $data['employee_title'],
            'firstName' => $data['firstName'],
            'bookingAvailability' => $data['bookingAvailability'] ?? 'no',
            'lastName' => $data['lastName'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'nic' => $data['nic'],
            'role' => $data['role'],
            'dateJoined' => $data['dateJoined'],
            'serviceTypes' => $data['serviceTypes'] ?? [], // array
            // 'jobs' => $data['jobs'] ?? [], // array
        ];
        $shiftArgs = [
            'shiftStart' => $data['shiftStart'],
            'shiftEnd' => $data['shiftEnd'],
            'breakStart' => $data['breakStart'] ?? '',
            'breakEnd' => $data['breakEnd'] ?? '',
        ];

        $jobs = [];
        foreach ($args['jobs'] ?? [] as $j) {
            // $s['dataSource'] = 'database';
            // $jobs[] = $this->createJobEntries($j);
        }

        $shift = new Shift($shiftArgs);
        $schedule = new Schedule($shift, $jobs);

        $serviceTypes = [];
        foreach ($data['serviceTypes'] ?? [] as $st) {
            $serviceTypes[] = $this->serviceTypeRepository->findById($st);
        }

        $employee = new Employee($arguments, $serviceTypes, $schedule);
        return $employee;
    }

    private function createFromDbRecord(array $data) {
        // $data['jobCount'] = $data['jobCount'] ?? null;
        if (isset($data['jobCount'])) {
            $jobCount = array_shift($data['jobCount']);
            $jobCount = array_shift($jobCount);
        } else {
            $jobCount = null;
        }

        $args = [
            'employeeId' => $data['employee_id'],
            // 'title' => $data['employee_title'],
            'bookingAvailability' => $data['booking_availability'],
            'firstName' => $data['first_name'],
            'lastName' => $data['last_name'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'nic' => $data['nic'],
            'jobCount' => $jobCount ?? null,
            'birthDate' => $data['birth_date'],
            'role' => $data['employee_position_id'],
            'dateJoined' => $data['joined_date'],
            'serviceTypes' => $data['serviceTypes'] ?? [], // array
            'jobs' => $data['jobs'] ?? [], // array
        ];

        $shiftArgs = [
            'shiftStart' => $data['shift_start'],
            'shiftEnd' => $data['shift_end'],
            'breakStart' => $data['break_start'],
            'breakEnd' => $data['break_end'],
        ];
        $jobs = [];
        foreach ($args['jobs'] as $j) {
            $s['dataSource'] = 'database';
            $jobs[] = $this->createJobEntries($j);
        }

        // var_dump(($jobs));
        // var_dump($data['jobs']);
        // exit();

        $serviceTypes = [];
        foreach ($args['serviceTypes'] as $st) {
            $st['dataSource'] = 'database';
            $serviceTypes[] = $this->createServiceTypeEntity($st);
        }

        $shift = new Shift($shiftArgs);
        $schedule = new Schedule($shift, $jobs);
        $employee = new Employee($args, $serviceTypes, $schedule);
        return $employee;
    }

    private function createServiceTypeEntity(array $data) {
        return $this->serviceTypeEntityMangager->createEntity($data);
    }

    private function createJobEntries(array $data) {
        // $jobs = [];
        $start = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $data['date_reserved'] . ' ' . $data['start_time']
        );
        $end = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $data['date_reserved'] . ' ' . $data['end_time']
        );
        $args = [
            'start' => $start,
            'end' => $end,
            'date' => $data['date_reserved'],
            'type' => 'service',
        ];
        // $jobs[] = (new Entry($args));
        return (new Entry($args));
        // return $jobs;
    }
}