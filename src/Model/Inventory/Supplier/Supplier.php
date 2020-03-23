<?php

namespace sbwms\Model\Inventory\Supplier;

class Supplier {
    private $supplierId;
    private $supplierName;
    private $companyName;
    private $telephone;
    private $email;

    public function __construct(array $args) {
        $this->supplierId = $args['supplierId'] ?? null;
        $this->supplierName = $args['supplierName'];
        $this->companyName = $args['companyName'];
        $this->telephone = $args['telephone'];
        $this->email = $args['email'];
    }

    /**
     * Get the value of supplierId
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * Get the value of supplierId, Alias of supplier id
     */
    public function getId() {
        return $this->getSupplierId();
    }

    /**
     * Get the value of supplierName
     */
    public function getSupplierName()
    {
        return $this->supplierName;
    }

    /**
     * Get the value of companyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Get the value of telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }
}