<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Controller\BaseController;
use sbwms\Model\Booking\BookingRepository;
use sbwms\Model\RecordFinderService;
use sbwms\Model\Service\ServiceOrder\ServiceOrderRepository;


class ScheduleController extends BaseController {
    private $request;
    private $serviceOrderRepository;
    private $bookingRepository;
    private $recordFinderService;

    public function __construct(
        Request $_request,
        ServiceOrderRepository $_sor,
        BookingRepository $_br,
        RecordFinderService $_rfs
    ) {
        $this->request = $_request;
        $this->serviceOrderRepository = $_sor;
        $this->bookingRepository = $_br;
        $this->recordFinderService = $_rfs;
    }

    public function list() {
        $bookings = $this->bookingRepository->findConfirmedAndRealized();
        $employees = $this->recordFinderService->findAllServiceCrew();
        $data = compact('bookings', 'employees');
        $html = $this->render_view(VIEWS . '/schedule/listSchedule.view.php', $data);
        return new Response($html);
    }

    public function listByDateAndEmployee() {
        $id = $this->request->query->get('id');
        $date = $this->request->query->get('date');
        if ($id && $date) {
            $bookings = $this->bookingRepository->findByDateAndEmployee($date, $id);
            $data = compact('bookings');
            $html = $this->render_view(VIEWS . '/schedule/listScheduleTable.partial.view.php', $data);
            return new Response($html);
        }
    }
}
