<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderFormHandler;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderRepository;
use sbwms\Model\Inventory\Supplier\SupplierRepository;
use sbwms\Model\Inventory\Item\ItemRepository;
use sbwms\Controller\BaseController;

class PurchaseOrderController extends BaseController {
    private $request;
    private $formHandler;
    private $purchaseOrderRepository;
    private $supplierRepository;

    public function __construct(
        Request $_request,
        PurchaseOrderFormHandler $_formHandler,
        PurchaseOrderRepository $_purchaseOrderRepository,
        SupplierRepository $_supplierRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_formHandler;
        $this->purchaseOrderRepository = $_purchaseOrderRepository;
        $this->supplierRepository = $_supplierRepository;
    }

    public function list() {
        $purchaseOrders = $this->purchaseOrderRepository->findAllSansDetails();
        // $purchaseOrders = [];
        $data = compact('purchaseOrders');
        $html = $this->render_view(VIEWS . '/purchase-order/listPurchaseOrder.view.php', $data);
        return new Response($html);
    }

    public function show() {
        // GET
        $id = $this->request->query->get('id') ?? '';
        $purchaseOrder = $this->purchaseOrderRepository->findById($id);
        if ($purchaseOrder) {
            $data = compact('purchaseOrder');
            $html = $this->render_view(VIEWS . '/purchase-order/viewPurchaseOrder.view.php', $data);
            return new Response($html);
        }
        $message = 'Bad Request! Invalid Purchase Order Id!';
        return new Response($message, 400);
    }

    public function new() {
        // GET
        if ($this->request->getMethod() === 'GET') {
            $suppliers = $this->supplierRepository->findAllActive();
            $data = compact('suppliers');
            $html = $this->render_view(VIEWS . 'purchase-order/createPurchaseOrder.view.php', $data);
            return new Response($html);
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $formData['_origin'] = 'user';
            // if ($this->formHandler->validate($formData)) {
            //     return new Response($this->render_result($errors));
            // }
            $purchaseOrder = $this->formHandler->createEntity($formData);
            $result = $this->purchaseOrderRepository->save($purchaseOrder);
            return new Response($this->render_result($result));
        }
    }

    public function edit() {
    }

    public function delete() {
    }

    public function addItem() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            // validate and redirect
            $user = $this->formHandler->createEntity($formData);
            $result = $this->userRepository->save($user);
            return new Response($this->render_result($result));
        }
    }
}
