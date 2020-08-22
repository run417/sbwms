<?php

namespace sbwms\Model\Service\ServiceOrder;

use DateInterval;
use DateTimeImmutable;
use sbwms\Model\Booking\BookingEntityManager;
use sbwms\Model\Service\JobCard\JobCard;
use sbwms\Model\Booking\BookingRepository;
use sbwms\Model\Inventory\Item\ItemRepository;
use sbwms\Model\Service\ServiceOrder\ServiceTime;

/**
 * Creates Booking Entity object
 */
class ServiceOrderEntityManager {

    private $bookingRepository;
    private $itemRepository;
    private $bookingEntityManager;

    public function __construct(
        BookingRepository $_br,
        ItemRepository $_ir,
        BookingEntityManager $_bem
    ) {
        $this->bookingRepository = $_br;
        $this->itemRepository = $_ir;
        $this->bookingEntityManager = $_bem;
    }

    public function getBookingEntityManager() {
        return $this->bookingEntityManager;
    }

    /**
     * Create Service Order instance
     */
    public function createEntity(array $data) {
        if (!isset($data['_origin'])) exit('data source not set');

        $serviceOrder = null;

        if ($data['_origin'] === 'user') {
            $serviceOrder = $this->createFromUserData($data);
        }

        if ($data['_origin'] === 'database') {
            $serviceOrder = $this->createFromDbRecord($data);
        }

        return $serviceOrder;
    }

    private function createFromUserData(array $data) {
        $booking = $this->bookingRepository->findById($data['bookingId']);

        $jobCardArguments = [
            'jobCardId' => null,
            'diagnosis' => null,
            'notes' => null,
        ];

        $jobCard = new JobCard($jobCardArguments);
        $arguments = [
            'serviceOrderId' => null,
            'status' => 'ongoing',
        ];

        $serviceTime = new ServiceTime();

        $serviceOrder = new ServiceOrder($arguments, $booking, $jobCard, $serviceTime);
        return $serviceOrder;
    }

    private function createFromDbRecord(array $data) {
        // exit(var_dump($data));
        // create service order entity from db record
        $booking = $this->bookingEntityManager->createEntity($data);
        $jobCardArguments = [
            'jobCardId' => $data['job_card_id'],
            'diagnosis' => $data['diagnosis'],
            'notes' => $data['notes'],
        ];
        $jobCardItems = [];
        foreach ($data['jobCardItems'] ?? [] as $itemArr) {
            $item = $this->itemRepository->findById($itemArr['item_id']);
            $item->setQuantity($itemArr['quantity']);
            $jobCardItems[] = $item;
        }

        $jobCard = new JobCard($jobCardArguments, $jobCardItems);
        $arguments = [
            'serviceOrderId' => $data['service_order_id'],
            'status' => $data['service_status'],
        ];

        $startDateTime = $data['service_start_datetime'] ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['service_start_datetime']) : null;
        $finishDateTime = $data['completed_at_datetime'] ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['completed_at_datetime']) : null;
        $serviceTime = $data['service_time'] ? new DateInterval($data['service_time']) : null;
        $onholdStart = $data['last_onhold_start_datetime'] ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['last_onhold_start_datetime']) : null;
        $onholdEnd = $data['last_onhold_end_datetime'] ? DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['last_onhold_end_datetime']) : null;
        $onholdTime = $data['onhold_time'] ? new DateInterval($data['onhold_time']) : null;
        $serviceTime = new ServiceTime(
            $startDateTime,
            $finishDateTime,
            $serviceTime,
            $onholdStart,
            $onholdEnd,
            $onholdTime
        );

        $serviceOrder = new ServiceOrder($arguments, $booking, $jobCard, $serviceTime);
        return $serviceOrder;
    }
}
