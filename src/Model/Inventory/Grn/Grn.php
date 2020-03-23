<?php

namespace sbwms\Model\Inventory\Grn;

use DateTimeImmutable;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrder;


class Grn {
    private $grnId;

    /** @var DateTimeImmutable */
    private $date;

    /** @var PurchaseOrder */
    private $purchaseOrder;

    /** @var array */
    private $items = [];

    public function __construct(array $args, DateTimeImmutable $_date, PurchaseOrder $_p, array $_grnItems) {
        $this->grnId = $args['grnId'];
        $this->date = $_date;
        $this->purchaseOrder = $_p;
        $this->items = $_grnItems;
    }

    /**
     * Get the value of grnId
     */
    public function getGrnId() {
        return $this->grnId;
    }

    /**
     * Alias of getGrnId()
     */
    public function getId() {
        return $this->getGrnId();
    }

    /**
     * Get the value of date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Get the value of purhcaseOrder
     */
    public function getPurchaseOrder() {
        return $this->purchaseOrder;
    }

    /**
     * Get the value of items
     */
    public function getGrnItems() {
        return $this->items;
    }
}