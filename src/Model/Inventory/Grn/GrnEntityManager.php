<?php

namespace sbwms\Model\Inventory\Grn;

use DateTimeImmutable;
use sbwms\Model\Inventory\Grn\GrnItem;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrder;
use sbwms\Model\Inventory\Item\ItemRepository;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrderRepository;

class GrnEntityManager {
    private $itemRepository;
    private $purchaseOrderRepository;

    public function __construct(ItemRepository $_itr, PurchaseOrderRepository $_por) {
        $this->itemRepository = $_itr;
        $this->purchaseOrderRepository = $_por;
    }

    public function createEntity($data) {
        if (!isset($data['dataSource'])) exit('data source not set');

        $grn = null;

        if ($data['dataSource'] === 'user') {
            $grn = $this->createFromUserData($data);
        }

        if ($data['dataSource'] === 'database') {
            $grn = $this->createFromDbRecord($data);
        }

        return $grn;
    }

    private function createFromUserData($data) {
        $grnItems = [];

        foreach ($data['items'] as $itemStr) {
            $itemArr = json_decode($itemStr, true);
            $item = $this->itemRepository->findById($itemArr['itemId']);
            $args = [
                'quantity' => $itemArr['quantity'],
                'sellingPrice' => $itemArr['sellingPrice'],
                'unitPrice' => $itemArr['unitPrice'],
            ];
            $grnItems[] = (new GrnItem($args, $item));
        }

        $args['grnId'] = $data['grnId'] ?? null;
        $purchaseOrder = $this->purchaseOrderRepository->findByIdSansDetails($data['purchaseOrderId']);
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $data['date']);
        return new Grn(
            $args, $date, $purchaseOrder, $grnItems
        );
    }

    public function createFromDbRecord(array $data) {
        $grnItems = [];
        $details = $data['details'] ?? [];
        foreach ($details as $itemArr) {
            $item = $this->itemRepository->findById($itemArr['item_id']);
            $args = [
                'quantity' => $itemArr['quantity'],
                'sellingPrice' => $itemArr['selling_price'],
                'unitPrice' => $itemArr['unit_price'],
            ];
            $grnItems[] = (new GrnItem($args, $item));
        }

        $args['grnId'] = $data['grn_id'];
        $purchaseOrder = $this->purchaseOrderRepository->findByIdSansDetails($data['purchase_order_id']);
        $date = DateTimeImmutable::createFromFormat('Y-m-d', $data['grn_date']);
        return new Grn(
            $args, $date, $purchaseOrder, $grnItems
        );
    }
}
