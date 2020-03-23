<?php

namespace sbwms\Controller;

use sbwms\Model\Vehicle\Vehicle;
use sbwms\Model\Vehicle\VehicleRepository;
use sbwms\Model\Vehicle\VehicleMapper;
use sbwms\Model\CustomerMapper;
use sbwms\Model\CustomerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CustomerController {
    private $mapper;
    private $request;
    private $repository;
    private $vehicleRepository;
    private $vehicleMapper;

    public function __construct(
        Request $_request,
        CustomerMapper $_mapper,
        CustomerRepository $_repository,
        VehicleRepository $_vehicleRepo,
        VehicleMapper $_vehicleMapper
    ) {
        $this->mapper = $_mapper;
        $this->request = $_request;
        $this->repository = $_repository;
        $this->vehicleRepository = $_vehicleRepo;
        $this->vehicleMapper = $_vehicleMapper;
    }

    public function list() {
        /** @var array|null An array of Customer instances or null */
        $customers = $this->repository->findAllCustomers();
        $html = $this->render_view(VIEWS . 'customer/listCustomer.view.php', compact('customers'));
        return new Response($html);
    }

    public function show() {
        $id = $this->request->query->get('id');

        if ($id !== null && $id !== '') {
            $customer = $this->repository->findById($id);
            if ($customer === null) { return $this->list(); }
            $html = $this->render_view(VIEWS . 'customer/viewCustomer.view.php', compact('customer'));
            return new Response($html);
        }
    }

    public function new() {
        if ($this->request->getMethod() === 'POST') {

            /** @var array */
            $formData = $this->request->request->getIterator()->getArrayCopy();

            /** @var Customer */
            $customer = $this->mapper->createEntity($formData);

            /** @var true|null */
            $result = $this->repository->save($customer);


            /*
                0 = success
                1 = failure (expect error list)
            */

            /** @var int */
            $successStatus = 1;
            if ($result === true) { $successStatus = 0; }
            return new Response($successStatus);
        }
        // if request is GET
        $html = $this->render_view(VIEWS . 'customer/createCustomer.view.php');
        return new Response($html);
    }

    public function newVehicle() {
        if ($this->request->getMethod() === 'POST') {
            /** @var array */
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $customerId = $formData['customerId'];
            $customer = $this->repository->findById($customerId);
            $vehicle = new Vehicle($formData);
            $vehicle->setOwner($customer);
            $result = $this->vehicleRepository->save($vehicle);
            return new Response($this->render_result($result));
        }
    }

    public function listVehicle() {
        $id = $this->request->query->get('customerId');


        if ($id !== null && $id !== '') {
            $customer = $this->repository->findById($id); // null check in view files. could be done in controller
            $html = $this->render_view(VIEWS . 'customer/listVehicle.view.partial.php', compact('customer'));
            return new Response($html);
        }
    }

    public function edit() {
        $id = $this->request->query->get('id');

        if ($id !== null && $id !== '') {
            $customer = $this->repository->findById($id);
            $serializer = new \sbwms\Model\CustomerSerializerService();
            $customerJson = $serializer->json($customer);
            // $customerJson = $this->mapper->toJson($customer);
            return new Response($customerJson);
        }

        if ($this->request->getMethod() === 'POST') {
            // data can be manipulated if id is wrong
            /** @var array */
            // $formData = $this->request->request->getIterator()->getArrayCopy();

            /** @var Customer */
            // $customer = $this->mapper->create($formData);

            /** @var true|null */
            // $result = $this->repository->save($customer);
            $result = true;

            /*
                0 = success
                1 = failure (expect error list)
            */

            /** @var int */
            $successStatus = 1;

            if ($result === true) { $successStatus = 0; }
            $resultArray = [
                'result' => $result,
                'success' => $successStatus,
            ];

            return new Response(json_encode($resultArray)); // buffered
        }

        // return new RedirectResponse('/sbwms/public/customer');
        $this->list(); // if no id and request is GET
    }

    public function editVehicle() {
        $id = $this->request->query->get('vehicleId');

        if ($id !== null && $id !== '') {
            // problem if vehicle has no owner
            $vehicle = $this->vehicleRepository->findById($id);
            // handle if vehicle not found
            $serializer = new \sbwms\Model\Vehicle\VehicleSerializerService();
            $vehicleJson = $serializer->json($vehicle);
            // $customerJson = $this->mapper->toJson($customer);
            return new Response($vehicleJson);
        }

        if ($this->request->getMethod() === 'POST') {
            // data can be manipulated if id is wrong
            /** @var array */
            $formData = $this->request->request->getIterator()->getArrayCopy();

            /** @var Vehicle */
            $vehicle = $this->vehicleMapper->createEntity($formData);

            /** @var true|null */
            $result = $this->vehicleRepository->save($vehicle);
            return new Response($this->render_result($result));
        }

        // return new RedirectResponse('/sbwms/public/customer');
        // $this->list(); // if no id and request is GET
    }

    private function render_view(string $viewPath, array $data=[]) :string {
        extract($data, EXTR_SKIP);
        ob_start();
        include_once $viewPath;
        $html = ob_get_clean();
        return $html;
    }

    private function render_result($result) {
        if (!(\is_array($result) || \is_numeric($result))) {
            exit('dev error - unknown error code type');
        }

        $error_list = [
            '23000' => 'Possible Concurrency Error'
        ];

        $status = '';
        $message = '';
        $output = [];

        // if no 'result' key
        if (!isset($result['result'])) { // validation error
            $status = 1;
            $message = 'Validation Error';
            $output['error'] = $result;
        }

        if (is_array($result) && isset($result['result'])) {
            if ($result['result'] === true) {
                $status = 0;
                $message = 'success';
            } elseif ($result['result'] === false) { exit('Dev ErrorResult False'); }

            $data = $result['data'] ?? [];
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $output[$key] = $value;
                }
            }
        }

        if (\is_numeric($result)) {
            $status = $result;
            $message = 'Error';
        }

        $output['status'] = $status;
        $output['message'] = $message;

        return \json_encode($output);
    }
}