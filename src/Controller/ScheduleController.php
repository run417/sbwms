<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\RecordFinderService;
use sbwms\Model\Service\ServiceOrder\ServiceOrderRepository;


class ScheduleController extends BaseController {
    private $request;
    private $serviceOrderRepository;
    private $recordFinderService;

    public function __construct(
        Request $_request,
        ServiceOrderRepository $_sor,
        RecordFinderService $_rfs
    ) {
        $this->request = $_request;
        $this->serviceOrderRepository = $_sor;
        $this->recordFinderService = $_rfs;

    }

    public function list() {
        $serviceOrders = $this->serviceOrderRepository->findByStatus('upcoming');
        $employees = $this->recordFinderService->findAllServiceCrew();
        $data = compact('serviceOrders', 'employees');
        $html = $this->render_view(VIEWS . '/schedule/listSchedule.view.php', $data);
        return new Response($html);
    }

    public function listByDateAndEmployee() {
        $id = $this->request->query->get('id');
        $date = $this->request->query->get('date');
        if ($id && $date) {
            $serviceOrders = $this->serviceOrderRepository->findByDateAndEmployee($date, $id);
            $data = compact('serviceOrders');
            $html = $this->render_view(VIEWS . '/schedule/listScheduleTable.partial.view.php', $data);
            return new Response($html);
        }
    }
}