<?php

namespace sbwms\Model\Inventory\Item;

use sbwms\Model\Inventory\Category\Subcategory;
use sbwms\Model\Inventory\Supplier\Supplier;

class Item {
    private $itemId;
    private $name;
    private $description;
    private $make;
    private $model;
    private $brand;

    private $quantity;
    private $reorderLevel;
    private $sellingPrice;

    /** @var Subcategory */
    private $subcategory;
    /** @var Supplier */
    private $supplier;
    // private unitPrice

    public function __construct(array $args, Subcategory $_sub, Supplier $_sup) {
        $this->itemId = $args['itemId'] ?? null;
        $this->name = $args['name'];
        $this->description = $args['description'];
        $this->brand = $args['brand'];
        $this->model = $args['model'] ?? '';
        $this->make = $args['make'] ?? '';

        $this->quantity = $args['quantity'] ?? 0;
        $this->reorderLevel = $args['reorderLevel'] ?? 0;
        $this->sellingPrice = sprintf('%0.2f', $args['sellingPrice'] ?? 0.00);

        $this->subcategory = $_sub;
        $this->supplier = $_sup;
    }

    /**
     * Get the item id
     * @return string item id
     */
    public function getItemId() {
        return $this->itemId;
    }

    /**
     * Get the item id. Alias of getItemId()
     * @return string item id
     */
    public function getId() {
        return $this->getItemId();
    }


    /**
     * Get the value of name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the value of description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Get the value of make
     */
    public function getMake() {
        return $this->make;
    }

    /**
     * Get the value of model
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Get the value of brand
     */
    public function getBrand() {
        return $this->brand;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Get the value of reorderLevel
     */
    public function getReorderLevel() {
        return $this->reorderLevel;
    }

    /**
     * Set the value of quantity
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    /**
     * Set the value of reorderQuantity
     */
    public function setReorderQuantity($reorderQuantity) {
        $this->reorderQuantity = $reorderQuantity;
    }

    /**
     * Set the value of reorderLevel
     */
    public function setReorderLevel($reorderLevel) {
        $this->reorderLevel = $reorderLevel;
    }

    /**
     * Get the value of category
     */
    public function getCategory() {
        return $this->subcategory->getCategory();
    }

    /**
     * Get the value of subcategory
     */
    public function getSubcategory() {
        return $this->subcategory;
    }

    /**
     * Get the value of supplier
     */
    public function getSupplier() {
        return $this->supplier;
    }

    /**
     * Get the value of sellingPrice
     */
    public function getSellingPrice() {
        return $this->sellingPrice;
    }
}