<?php

namespace sbwms\Model\Service\ServiceOrder;

use DateTimeImmutable;
use sbwms\Model\Service\JobCard\JobCard;
use sbwms\Model\Booking\BookingEntityManager;
use sbwms\Model\Inventory\Item\ItemRepository;

/**
 * Creates Booking Entity object
 */
class ServiceOrderEntityManager {

    private $bookingEntityManager;
    private $itemRepository;

    public function __construct(
        BookingEntityManager $_bem,
        ItemRepository $_ir
    ) {
        $this->bookingEntityManager = $_bem;
        $this->itemRepository = $_ir;
    }

    public function getBookingEntityManager() {
        return $this->bookingEntityManager;
    }

    /**
     * Create Service Order instance
     */
    public function createEntity(array $data) {
        if (!isset($data['dataSource'])) exit('data source not set');

        $serviceOrder = null;

        if ($data['dataSource'] === 'user') {
            $serviceOrder = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $serviceOrder = $this->createFromDbRecord($data);
        }

        return $serviceOrder;
    }

    private function createFromUserData(array $data) {
        $booking = $this->bookingEntityManager->createEntity($data);

        $jobCardArguments = [
            'jobCardId' => null,
            'diagnosis' => null,
            'notes' => null,
        ];

        $jobCard = new JobCard($jobCardArguments);
        $arguments = [
            'serviceOrderId' => null,
            'status' => 'upcoming',
        ];

        $serviceOrder = new ServiceOrder($arguments, $booking, $jobCard);
        return $serviceOrder;
    }

    private function createFromDbRecord(array $data) {
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

        $serviceOrder = new ServiceOrder($arguments, $booking, $jobCard);
        return $serviceOrder;
    }
}
