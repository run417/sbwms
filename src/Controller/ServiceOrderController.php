<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\Service\ServiceOrder\ServiceOrderRepository;


class ServiceOrderController extends BaseController {
    private $request;
    private $serviceOrderRepository;

    public function __construct(
        Request $_request,
        ServiceOrderRepository $_sor
    ) {
        $this->request = $_request;
        $this->serviceOrderRepository = $_sor;

    }

    public function list() {
        $status = $this->request->query->get('status');
        if ($status === 'ongoing') {
            $serviceOrders = $this->serviceOrderRepository->findByStatus($status);
            $data = compact('serviceOrders');
            $html = $this->render_view(VIEWS . '/service/listOngoingServiceOrder.view.php', $data);
        } else if ($status === 'on-hold') { // includes services on-hold
            $serviceOrders = $this->serviceOrderRepository->findByStatus($status);
            $data = compact('serviceOrders');
            $html = $this->render_view(VIEWS . '/service/listOnHoldServiceOrder.view.php', $data);
        }
        return new Response($html);
    }

    public function show() {
        $id = $this->request->query->get('id');
        $serviceOrder = $this->serviceOrderRepository->findById($id);
        if ($serviceOrder) {
            $data = compact('serviceOrder');
            $html = $this->render_view(VIEWS . '/service/viewServiceOrder.view.php', $data);
            return new Response($html);
        }
    }

    public function hold() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $result = $this->serviceOrderRepository->holdService($formData);
            return new Response($this->render_result($result));
        }
    }

    public function start() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $result = $this->serviceOrderRepository->startService($formData);
            return new Response($this->render_result($result));
        }
    }
}
