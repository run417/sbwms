<?php

namespace sbwms\Model\Inventory\PurchaseOrder;

use sbwms\Model\Inventory\Supplier\Supplier;
use DateTimeImmutable;

class PurchaseOrder {
    private $purchaseOrderId;
    private $remarks;
    private $status;

    /** @var DateTimeImmutable */
    private $date;

    /** @var DateTimeImmutable */
    private $shippingDate;

    /** @var Supplier */
    private $supplier;

    /** @var array */
    private $items;

    public function __construct(array $args, DateTimeImmutable $_date, DateTimeImmutable $_shipDate, Supplier $_s, array $_i) {
        $this->purchaseOrderId = $args['purchaseOrderId'] ?? null;
        $this->remarks = $args['remarks'] ?? 'No remarks';
        $this->status = $args['status'] ?? 'pending';
        $this->date = $_date;
        $this->shippingDate = $_shipDate;
        $this->supplier = $_s;
        $this->items = $_i;
    }

    /**
     * Get the value of purchaseOrderId
     * @return string Purchase order id
     */
    public function getPurchaseOrderId() {
        return $this->purchaseOrderId;
    }

    /**
     * Alias of getPurchaseOrderId()
     * @return string Purchase order id
     */
    public function getId() {
        return $this->getPurchaseOrderId();
    }

    /**
     * Get the value of date
     * @return DateTimeImmutable Purchase order date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Get the value of shippingDate
     * @return DateTimeImmutable Shipping date
     */
    public function getShippingDate() {
        return $this->shippingDate;
    }

    /**
     * Get the value of supplier
     * @return Supplier
     */
    public function getSupplier() {
        return $this->supplier;
    }

    /**
     * Get the items
     * @return array
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * Get the value of remarks
     * @return string purchase order remarks
     */
    public function getRemarks() {
        return $this->remarks;
    }

    /**
     * Get the value of status
     * @return string purchase order status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param string purchase order status
     */
    public function setStatus(string $status) {
        $this->status = $status;
    }
}