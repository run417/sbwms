<?php

namespace sbwms\Model\Inventory\Supplier;

use sbwms\Model\Inventory\Supplier\Supplier;
use sbwms\Model\Inventory\Supplier\SupplierMapper;

class SupplierRepository {
    private $supplierMapper;

    public function __construct(SupplierMapper $_supm) {
        $this->supplierMapper = $_supm;
    }

    public function findAll() {
        $sql = "SELECT * FROM supplier";
        $suppliers = $this->supplierMapper->find([], $sql);
        return $suppliers;
    }

    public function findAllActive() {
        $sql = "SELECT * FROM supplier WHERE state=:state";
        $bindings = ['state' => 1];
        $suppliers = $this->supplierMapper->find($bindings, $sql);
        return $suppliers;
    }

    public function findById($id) {
        $sql = "SELECT * FROM supplier WHERE supplier_id=:supplier_id AND state=:state";
        $bindings = ['supplier_id' => $id, 'state' => 1];
        $supplier = $this->supplierMapper->find($bindings, $sql);
        return array_shift($supplier);
    }

    public function save(Supplier $supplier) {
        if ($supplier->getSupplierId() === null) {
            return $this->supplierMapper->insert($supplier);
        }
        return $this->supplierMapper->update($supplier);
    }
}