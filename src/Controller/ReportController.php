<?php

namespace sbwms\Controller;

use PDO;
use DateTimeImmutable;
use DateInterval;
use sbwms\Controller\BaseController;
use sbwms\Model\Employee\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends BaseController {
    private $request;
    protected $pdo;
    private $employeeRepository;

    public function __construct(Request $_r, PDO $_p, EmployeeRepository $_er) {
        $this->request = $_r;
        $this->pdo = $_p;
        $this->employeeRepository = $_er;
        // $this->customerRepository = $_er;
        // $this->serviceTypeRepository = $_er;
    }

    public function employeelist() {
        $employees = $this->employeeRepository->findAll();
        $data = compact('employees');
        $html = $this->render_view(VIEWS . 'report/reportListEmployee.view.php', $data);
        return new Response($html);
    }

    public function findWithJobCount() {
        $employees = $this->employeeRepository->findAllEmployeesWithJobCount();
        $data = compact('employees');
        $html = $this->render_view(VIEWS . 'report/listEmployeeJobCount.view.php', $data);
        return new Response($html);
    }
}