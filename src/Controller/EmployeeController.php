<?php

namespace sbwms\Controller;

use sbwms\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use sbwms\Model\Employee\EmployeeFormHandler;
use sbwms\Model\Employee\EmployeeRepository;
use sbwms\Model\Service\Type\ServiceTypeRepository;

class EmployeeController extends BaseController{
    private $request;
    private $formhandler;
    private $employeeRepository;
    private $serviceTypeRepository;

    public function __construct(
        Request $_request,
        EmployeeFormHandler $_efh,
        EmployeeRepository $_empRepo,
        ServiceTypeRepository $_serviceTypeRepo
    ) {
        $this->request = $_request;
        $this->formhandler = $_efh;
        $this->employeeRepository = $_empRepo;
        $this->serviceTypeRepository = $_serviceTypeRepo;
    }

    public function list() {
        /** @var array|null An array of Employee instances or null */
        // $employees = $this->employeeRepository->findAllByServiceId('ST0007');
        $employees = $this->employeeRepository->findAll();
        $data = compact('employees');
        $html = $this->render_view(VIEWS . 'employee/listEmployee.view.php', $data);
        return new Response($html);
    }

    public function show() {
        $id = $this->request->query->get('id');

        if ($id !== null && $id !== '') {
            $employee = $this->employeeRepository->findById($id);
            var_dump($employee);
            exit();

            if ($employee === null) { return $this->list(); }

            $data = ['employee' => $employee];
            $html = $this->render_view(VIEWS . 'employee/viewEmployee.view.php', $data);
            return new Response($html);
        }
    }

    public function new() {
        if ($this->request->getMethod() === 'POST') {
            /** @var array */
            $formData = $this->request->request->getIterator()->getArrayCopy();
            /*
                serviceType values should be verified. The records ideally should be loaded from the database
            */

            $errors = $this->formhandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }

            $formData['dataSource'] = 'user';
            $employee = $this->formhandler->createEntity($formData);

            /** @var array */
            $result = $this->employeeRepository->save($employee);
            return new Response($this->render_result($result));
        }
        // if request is GET
        $serviceTypes = $this->serviceTypeRepository->findAll();
        $data = compact('serviceTypes');
        $html = $this->render_view(VIEWS . 'employee/createEmployee.view.php', $data);
        return new Response($html);
    }

    public function edit() {
        $id = $this->request->query->get('id');
        if ($this->request->getMethod() === 'GET') {

            if ($id !== null && $id !== '') {
                $employee = $this->employeeRepository->findById($id);
                $serviceTypes = $this->serviceTypeRepository->findAll();
                $data = compact('employee', 'serviceTypes');
                $html = $this->render_view(VIEWS . 'employee/editEmployee.view.php', $data);
                return new Response($html);
                // $employeeJson = $this->mapper->toJson($employee);
                // return new Response($employeeJson);
            }
        }

        if ($this->request->getMethod() === 'POST') {
            /** @var array */
            $formData = $this->request->request->getIterator()->getArrayCopy();


            $errors = $this->formhandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }

            $formData['dataSource'] = 'user';
            $employee = $this->formhandler->createEntity($formData);
            $result = $this->employeeRepository->save($employee);
            return new Response($this->render_result($result));
        }

        // return new RedirectResponse('/sbwms/public/employee');
        $this->list(); // if no id and request is GET
    }

    public function isNicUnique() {
        $nic = $this->request->query->get('nic');
        if ($nic === '' || $nic === null) {
            return new Response('Bad Request! NIC not set!', 400);
        }
        $message = $this->formHandler->isNicUnique($nic);
        if (!$message) $message = "Warining this NIC No. is already use!";
        return new Response(json_encode($message));
    }
}