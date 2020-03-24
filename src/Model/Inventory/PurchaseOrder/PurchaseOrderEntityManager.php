<?php

namespace sbwms\Model\Inventory\PurchaseOrder;

use DateTimeImmutable;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrder;
use sbwms\Model\Inventory\Item\ItemRepository;
use sbwms\Model\Inventory\Supplier\SupplierRepository;

class PurchaseOrderEntityManager {
    private $itemRepository;
    private $supplierRepository;

    public function __construct(ItemRepository $_itr, SupplierRepository $_supr) {
        $this->itemRepository = $_itr;
        $this->supplierRepository = $_supr;
    }

    public function createEntity($data) {
        if (!isset($data['dataSource'])) exit('data source not set');

        $purchaseOrder = null;

        if ($data['dataSource'] === 'user') {
            $purchaseOrder = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $purchaseOrder = $this->createFromDbRecord($data);
        }

        return $purchaseOrder;
    }

    private function createFromUserData($data) {
        $items = [];
        foreach ($data['items'] as $itemStr) {
            $itemArr = json_decode($itemStr, true);
            $item = $this->itemRepository->findById($itemArr['itemId']);
            $item->setQuantity($itemArr['quantity']);
            $items[] = $item;
        }
        $args['purchaseOrderId'] = $data['purchaseOrderId'] ?? null;
        $args['remarks'] = $data['remarks'];
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $data['date']);
        $shippingDate = DateTimeImmutable::createFromFormat('Y-m-d', $data['shippingDate']);
        $supplier = $this->supplierRepository->findById($data['supplier']);
        return new PurchaseOrder(
            $args, $date, $shippingDate, $supplier, $items
        );
    }

    public function createFromDbRecord(array $data) {
        $items = [];
        $itemRecords = $data['items'] ?? [];
        foreach ($itemRecords as $itemArr) {
            $item = $this->itemRepository->findById($itemArr['item_id']);
            $item->setQuantity($itemArr['quantity']);
            $items[] = $item;
        }
        $args['purchaseOrderId'] = $data['purchase_order_id'] ?? null;
        $args['remarks'] = $data['remarks'] ?? null;
        $args['status'] = $data['purchase_order_status'];
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $data['date']);
        $shippingDate = DateTimeImmutable::createFromFormat('Y-m-d', $data['shipping_date']);
        $supplier = $this->supplierRepository->findById($data['supplier_id']);
        return new PurchaseOrder(
            $args, $date, $shippingDate, $supplier, $items
        );
    }
}