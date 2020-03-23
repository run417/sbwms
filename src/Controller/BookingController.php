<?php

namespace sbwms\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use sbwms\Model\Booking\ScheduleService;
use sbwms\Model\Booking\BookingFormHandler;
use sbwms\Model\Booking\BookingRepository;
use sbwms\Model\Service\ServiceOrder\ServiceOrderRepository;
use sbwms\Controller\BaseController;

class BookingController extends BaseController {

    private $request;
    private $scheduleService;
    private $formHandler;
    private $bookingMapper;

    /** @var BookingRepository */
    private $bookingRepository;
    private $serviceOrderRepository;

    public function __construct(
        Request $_request,
        BookingFormHandler $_bookingFormHandler,
        ScheduleService $_scheduleService,
        BookingRepository $_bookingRepository,
        ServiceOrderRepository $_serviceOrderRepository
    ) {
        $this->request = $_request;
        $this->formHandler = $_bookingFormHandler;
        $this->scheduleService = $_scheduleService;
        $this->bookingRepository = $_bookingRepository;
        $this->serviceOrderRepository = $_serviceOrderRepository;
    }

    public function list() {
        $bookings = $this->bookingRepository->findActive();
        $data = compact('bookings');
        $html = $this->render_view(VIEWS . 'booking/listBooking.view.php', $data);
        return new Response($html);
    }

    public function historyList() {
        $bookings = $this->bookingRepository->findActive();
        $data = compact('bookings');
        $html = $this->render_view(VIEWS . 'booking/listBookingHistory.view.php', $data);
        return new Response($html);
    }

    public function show() {
        // GET
        $id = $this->request->query->get('id');
        if ($id === '' || $id === null) {
            $message = 'Bad Request! Please select a service!';
            return new Response($message, 400);
        }

        $booking = $this->bookingRepository->findById($id);
        $data = compact('booking');
        $html = $this->render_view(VIEWS . '/booking/viewBooking.view.php', $data);
        return new Response($html);
    }

    public function new() {
        // GET
        // get timeslots on service type select
        if ($this->request->getMethod() === 'GET') {
            $serviceTypes = $this->formHandler->getServiceTypes();
            $vehicles = $this->formHandler->getVehicles();
            $data = compact('serviceTypes', 'vehicles');
            $html = $this->render_view(
                VIEWS . 'booking/v2CreateBooking.view.php', $data
            );
            return new Response($html);
        }

        // POST
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $errors = $this->formHandler->validate($formData);

            // if form data is not valid
            if (!empty($errors)) {
                return new Response($this->render_result($errors));
            }

            // get an employee from the selected time slot
            $employeeId = $this->scheduleService->getEmployeeFromTimeSlot(
                $formData['timeSlot'], $formData['serviceType']
            );

            $formData['employeeId'] = $employeeId;
            $formData['dataSource'] = 'user';

            $booking = $this->formHandler->createEntity($formData);
            $booking->confirm();
            $result = $this->bookingRepository->save($booking);

            
            // // create service order. The service order contains booking
            // $serviceOrder = $this->formHandler->createEntity($formData);
            // $serviceOrder->getBooking()->confirm();
            // $result = $this->serviceOrderRepository->save($serviceOrder);
            // exit(var_dump($result));
            // $result = [
            //     'result' => true,
            //     'data' => ['id' => 'B0001'],
            // ];
            return new Response($this->render_result($result));
        }
    }

    public function confirmBooking() {

        if ($this->request->getMethod() === 'GET') {
            $bookingId = $this->request->query->get('bookingId');
            if ($bookingId === '' || $bookingId === null) {
                $message = 'Booking Id is not set! Bad Request';
                return new Response($message, 400);
            }
            // get the booking from the database
            $booking = $this->bookingRepository->findById($bookingId);
            $data = \compact('booking');
            $htmlPartial = $this->render_view(VIEWS . 'booking/confirmBooking.partial.view.php', $data);
            return new Response($htmlPartial);
        }

        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            if (!isset($formData['bookingId']) || $formData['bookingId'] === '') {
                $message = 'Booking Id is not set! Bad Request';
                return new Response($message, 400);
            };
            // get the booking from the database
            $booking = $this->bookingRepository->findById($formData['bookingId']);
            $booking->confirm();
            $result = $this->bookingRepository->save($booking);
            // exit(var_dump($result));
            return new Response($this->render_result($result));
        }
    }

    public function getTimeSlots() {
        // GET
        $serviceType = $this->request->query->get('serviceType');
        if ($serviceType === '' || $serviceType === null) {
            $serviceType = 'Bad Request! Please select a service!';
            return new Response($serviceType, 400);
        }
        $timeSlotString = $this->scheduleService->getTimeSlotSelectHTMLPartial($serviceType);
        return new Response($timeSlotString);
    }

    public function getBookingById() {
        // GET

        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $session->set('newName', 'Vinura');
    }

    public function realizeBooking() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $booking = $this->bookingRepository->findById($formData['id']);
            $booking->setStatus('realized');
            $result = $this->bookingRepository->save($booking);
            return new Response($this->render_result($result));
        }
    }

    public function cancelBooking() {
        if ($this->request->getMethod() === 'POST') {
            $formData = $this->request->request->getIterator()->getArrayCopy();
            $booking = $this->bookingRepository->findById($formData['id']);
            $booking->setStatus('cancelled');
            $result = $this->bookingRepository->save($booking);
            return new Response($this->render_result($result));
        }
    }

}
