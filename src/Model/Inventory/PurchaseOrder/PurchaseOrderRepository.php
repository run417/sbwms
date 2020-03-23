<?php

namespace sbwms\Model\Inventory\PurchaseOrder;

use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderMapper;

class PurchaseOrderRepository {
    private $purchaseOrderMapper;

    public function __construct(PurchaseOrderMapper $_pm) {
        $this->purchaseOrderMapper = $_pm;
    }

    public function findAll() {
        $sql = "SELECT * FROM purchase_order";
        $bindings = [];
        $purchaseOrders = $this->purchaseOrderMapper->find($bindings, $sql);
        return $purchaseOrders;
    }

    public function findAllActive() {
        $sql = "SELECT * FROM purchase_order WHERE state=:state";
        $detailSql = "SELECT * FROM purchase_order_detail WHERE purchase_order_id = :purchase_order_id";
        $bindings = ['state' => 1];
        $purchaseOrders = $this->purchaseOrderMapper->find($bindings, $sql, $detailSql);
        return $purchaseOrders;
    }

    public function findAllSansDetails() {
        $sql = "SELECT * FROM purchase_order WHERE state=:state";
        $bindings = ['state' => 1];
        $purchaseOrders = $this->purchaseOrderMapper->find($bindings, $sql);
        return $purchaseOrders;
    }

    public function findByIdSansDetails(string $id) {
        $sql = "SELECT * FROM purchase_order WHERE purchase_order_id=:purchase_order_id AND state=:state";
        $bindings = ['purchase_order_id' => $id, 'state' => 1];
        $purchaseOrders = $this->purchaseOrderMapper->find($bindings, $sql);
        return array_shift($purchaseOrders);
    }

    public function findById(string $id) {
        $sql = "SELECT * FROM purchase_order WHERE purchase_order_id=:purchase_order_id AND state=:state";
        $detailSql = "SELECT * FROM purchase_order_detail WHERE purchase_order_id=:purchase_order_id";
        $bindings = ['purchase_order_id' => $id, 'state' => 1];
        $purchaseOrders = $this->purchaseOrderMapper->find($bindings, $sql, $detailSql);
        return array_shift($purchaseOrders);
    }

    public function save(PurchaseOrder $purchaseOrder) {
        if ($purchaseOrder->getPurchaseOrderId() === null) {
            return $this->purchaseOrderMapper->insert($purchaseOrder);
        }
        return $this->purchaseOrderMapper->update($purchaseOrder);
    }
}