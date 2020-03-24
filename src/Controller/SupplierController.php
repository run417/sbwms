<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Inventory\Supplier\SupplierFormHandler;
use sbwms\Model\Inventory\Supplier\SupplierRepository;
use sbwms\Controller\BaseController;


class SupplierController extends BaseController {
    private $request;
    private $formHandler;
    private $supplierRepository;

    public function __construct(
        Request $_request,
        SupplierFormHandler $_formHandler,
        SupplierRepository $_supplierRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_formHandler;
        $this->supplierRepository = $_supplierRepository;
    }

    public function list() {
        $suppliers = $this->supplierRepository->findAll();
        // $suppliers = [];
        $data = compact('suppliers');
        $html = $this->render_view(VIEWS . '/supplier/listSupplier.view.php', $data);
        return new Response($html);
    }

    public function show() {
        $returnType = $this->request->query->get('type') ?? null;
        $id = $this->request->query->get('id');
        if ($id === '' || $id === null) {
            $message = 'Bad Request! No Supplier Id!';
            return new Response($message, 400);
        }
        $supplier = $this->supplierRepository->findById($id);
        $data = compact('supplier');
        if ($returnType) { // assumed row partial type
            $html = $this->render_view(VIEWS . '/supplier/viewSupplierTableRow.partial.view.php', $data);
            return new Response($html);
        }
        return new Response('no return type set!');
    }

    public function new() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['dataSource'] = 'user';
            $supplier = $this->formHandler->createEntity($formData);
            $result = $this->supplierRepository->save($supplier);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
        return new Response('get method');
    }

    public function edit() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $id = $this->request->query->get('id');
            if ($id === '' || $id === null) {
                $message = 'Bad Request! No Supplier Id!';
                return new Response($message, 400);
            }
            $supplier = $this->supplierRepository->findById($id);
            return new Response($this->formHandler->serialize($supplier));
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }
            $formData['dataSource'] = 'user';
            $supplier = $this->formHandler->createEntity($formData);
            $result = $this->supplierRepository->save($supplier);
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'CAT001', 'name' => 'Engine Oils'],
            // ];
            return new Response($this->render_result($result));
        }
    }
}