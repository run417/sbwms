<?php

namespace sbwms\Controller;

use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\Service\ServiceOrder\ServiceOrderEntityManager;
use sbwms\Model\Service\ServiceOrder\ServiceOrderRepository;


class ServiceOrderController extends BaseController {
    private $request;
    private $serviceOrderRepository;
    private $serviceOrderEntityManager;

    public function __construct(
        Request $_request,
        ServiceOrderRepository $_sor,
        ServiceOrderEntityManager $_sem
    ) {
        $this->request = $_request;
        $this->serviceOrderRepository = $_sor;
        $this->serviceOrderEntityManager = $_sem;
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

    public function history() {
        $serviceOrders = $this->serviceOrderRepository->getFinishedServiceOrders();
        $data = compact('serviceOrders');
        $html = $this->render_view(VIEWS . '/service/listFinishedServiceOrders.view.php', $data);
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
            $serviceOrder = $this->serviceOrderRepository->findById($formData['id']);
            $serviceOrder->hold();
            // exit(var_dump($serviceOrder));
            $result = $this->serviceOrderRepository->holdService($serviceOrder);
            return new Response($this->render_result($result));
        }
    }

    public function restart() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $serviceOrder = $this->serviceOrderRepository->findById($formData['id']);
            $serviceOrder->restart();
            // exit(var_dump($serviceOrder));
            $result = $this->serviceOrderRepository->restartService($serviceOrder);
            return new Response($this->render_result($result));
        }
    }

    public function start() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $formData['_origin'] = 'user';
            $serviceOrder = $this->serviceOrderEntityManager->createEntity($formData);
            $serviceOrder->getBooking()->realize();
            $serviceOrder->startTimer(new DateTimeImmutable());
            $result = $this->serviceOrderRepository->save($serviceOrder);
            // exit((var_dump($this->render_result($result))));
            return new Response($this->render_result($result));
        }
    }

    public function complete() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $serviceOrder = $this->serviceOrderRepository->findById($formData['id']);
            $serviceOrder->complete();
            // exit(var_dump($serviceOrder));
            $result = $this->serviceOrderRepository->completeService($serviceOrder);
            return new Response($this->render_result($result));
        }
    }

    public function terminate() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $serviceOrder = $this->serviceOrderRepository->findById($formData['id']);
            $serviceOrder->terminate();
            // exit(var_dump($serviceOrder));
            $result = $this->serviceOrderRepository->terminateService($serviceOrder);
            return new Response($this->render_result($result));
        }
    }
}
