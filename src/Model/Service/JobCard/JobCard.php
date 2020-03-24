<?php

namespace sbwms\Model\Service\JobCard;

class JobCard {
    private $jobCardId;
    private $diagnosis;
    private $notes;

    /** @var array */
    private $items = [];
    private $tasks;

    public function __construct(array $args, array $_items=[] ) {
        $this->jobCardId = $args['jobCardId'] ?? null;
        $this->diagnosis = $args['diagnosis'];
        $this->notes = $args['notes'];
        // $this->mileage = $args['mileage'];
        $this->items = $_items;
    }

    /**
     * Get the value of serviceOrderId
     */
    public function getId() {
        return $this->jobCardId;
    }

    /**
     * Get the value of diagnosis
     */
    public function getDiagnosis() {
        return $this->diagnosis;
    }

    /**
     * Get the value of notes
     */
    public function getNotes() {
        return $this->notes;
    }

    /**
     * Get the value of items
     * @return array Array of Items used in the job
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getTotalItemCost() {
        $total = 0;
        foreach ($this->items as $i) {
            $total += ((float) $i->getSellingPrice() * (float) $i->getQuantity());
        }
        return \sprintf('%0.2f', $total);
    }
}
