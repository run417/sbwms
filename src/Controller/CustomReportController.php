<?php

namespace sbwms\Controller;

use PDO;
use DateTimeImmutable;
use DateInterval;
use sbwms\Controller\BaseController;
use sbwms\Model\Employee\EmployeeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomReportController extends BaseController {
    private $request;
    protected $pdo;

    public function __construct(Request $_r, PDO $_p) {
        $this->request = $_r;
        $this->pdo = $_p;
    }

    public function customerList() {
        $sql = "SELECT * FROM r_customer";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $customers = $result;
        $data = compact('customers');
        $html = $this->render_view(VIEWS . 'report/creportCustomer.view.php', $data);
        return new Response($html);
        // var_dump($result);
        // exit();
    }

    public function emloyeeServiceCount() {
        $sql = "SELECT * FROM r_employee";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $employees = $result;
        $data = compact('employees');
        $html = $this->render_view(VIEWS . 'report/creportEmployeeServiceCount.view.php', $data);
        return new Response($html);
    }

    public function serviceAverage() {
        $sql = "SELECT * FROM r_service";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $services = $result;
        $data = compact('services');
        $html = $this->render_view(VIEWS . 'report/creportAverageServiceLength.view.php', $data);
        return new Response($html);
    }

    public function serviceTypesList() {
        $sql = "SELECT * FROM service_type";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $services = $result;
        $data = compact('services');
        $html = $this->render_view(VIEWS . 'report/creportOperationalServices.view.php', $data);
        return new Response($html);
    }
}