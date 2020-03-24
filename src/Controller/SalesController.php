<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\CustomerRepository;
use sbwms\Controller\BaseController;

class SalesController extends BaseController {
    private $request;
    // private $formHandler;
    private $customerRepository;

    public function __construct(
        Request $_request,
        // PurchaseOrderFormHandler $_formHandler,
        CustomerRepository $_customerRepository
    ) {
        $this->request = $_request;
        // $this->formHandler = $_formHandler;
        $this->customerRepository = $_customerRepository;
    }

    public function sellItem() {
        // GET
        $html = $this->render_view(VIEWS . '/sale/newItemSale.view.php');
        return new Response($html);
    }

    public function getCustomers() {
        $customers = $this->customerRepository->findAllCustomers();
        $data = compact('customers');
        $html = $this->render_view(VIEWS . '/customer/listCustomerTable.partial.view.php', $data);
        return new Response($html);
    }
}