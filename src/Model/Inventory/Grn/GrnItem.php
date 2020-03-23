<?php

namespace sbwms\Model\Inventory\Grn;

use sbwms\Model\Inventory\Item\Item;

class GrnItem {
    /** @var Item */
    private $item;

    private $quantity;
    private $sellingPrice;
    private $unitPrice;

    public function __construct(array $args, Item $_item) {
        $this->quantity = $args['quantity'];
        $this->sellingPrice = sprintf('%0.2f', $args['sellingPrice']);
        $this->unitPrice = sprintf('%0.2f', $args['unitPrice']);
        $this->item = $_item;
    }


    /**
     * Get the value of item
     * @return Item
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Get the value of sellingPrice
     */
    public function getSellingPrice() {
        return $this->sellingPrice;
    }

    /**
     * Get the value of unitPrice
     */
    public function getUnitPrice() {
        return $this->unitPrice;
    }
}