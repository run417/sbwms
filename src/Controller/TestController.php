<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use sbwms\Model\Booking\ScheduleService;
use sbwms\Model\Employee;
use sbwms\Model\Employee\EmployeeMapper;
use sbwms\Model\Vehicle\VehicleMapper;
use PDO;

class TestController {
    private $pdo;
    private $request;
    private $scheduleService;
    private $mapper;
    private $vehicleMapper;


    public function __construct(
        PDO $_pdo,
        Request $_request,
        ScheduleService $_scheduleService,
        EmployeeMapper $_mapper,
        VehicleMapper $_vehicleMapper
    ) {
        $this->pdo = $_pdo;
        $this->request = $_request;
        $this->scheduleService = $_scheduleService;
        $this->mapper = $_mapper;
        $this->vehicleMapper = $_vehicleMapper;
    }

    public function test() {
        $serviceType = 'ST0005';
        $customer = 'C0002';

        $timeSlots = $this->scheduleService->getTimeSlotSelectHTMLPartial($serviceType);

        $string = "<select>";
        foreach ($timeSlots as $day => $slot) {
            $string .= "<optgroup label=\"$day\">";
            foreach ($slot as $s) {
                $string .= "<option value=\"$s[1]\">$s[0]</option>";
            }
            $string .= "</optgroup>";
        }
        $string .= "</select>";

        echo($string);

        exit();

        return new Response($message);
    }

    public function testnewmapper() {
        $employeeData = [
            // 'employeeId' => 'E0007',
            'firstName' => 'Vinura',
            'lastName' => 'W',
            'telephone' => 'Vinura',
            'email' => 'e@v.com',
            'nic' => '111111111V',
            'role' => '104',
            'dateJoined' => '10-10-2019',
            'shiftStart' => '09:00:00',
            'shiftEnd' => '17:00:00',
        ];
        // $employee = $this->mapper->createEntity($employeeData);
        // $this->mapper->update($employee);
        // \var_dump($this->mapper->createEntity($this->mapper->find(['employee_position_id' => '104'])));
        \var_dump($this->mapper->createEntity($employeeData));
        // $this->mapper->insert();
        return new Response('hi');
    }

    public function testInterface() {
        return new Response('new interface');
    }

    public function testMethod() {
        // $vehicleMapper = $this->vehicleMapper;
        // $data = [
        //     'customer_id' => 'C0001',
        //     'customerId' => 'C0001',
        //     'customer_title' => 'Mr.',
        //     'first_name' => 'Chathuranga',
        //     'last_name' => 'Gunasekara',
        //     'telephone' => '077123456',
        //     'email' => 'c@gmail.com',
        //     'registration_date' => '2019-11-03',
        //     'vehicleId' => 'V0001',
        //     'make' => 'Toyota',
        //     'model' => 'Allion',
        //     'year' => '2014',
        //     'type' => 'Sedan',
        //     'regNo' => 'GAW 1243',
        //     'vin' => '12345678912345678',
        // ];
        // // $output = $vehicleMapper->convertKeys($data);
        // // $output = $vehicleMapper->find();
        // $form = [
        //     'serviceType' => 'ST0001',
        //     'vehicle' => 'V0001',
        //     'timeSlot' => '201911030900',
        // ];
        $validator = new \sbwms\Model\Validator($this->pdo);
        \var_dump($validator->isUsernameUnique('danu'));
        exit();
    }
}
