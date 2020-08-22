<?php

namespace sbwms\Model\Inventory\PurchaseOrder;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Inventory\PurchaseOrder\PurchaseOrder;

class PurchaseOrderMapper extends BaseMapper {
    /** @var PDO */
    protected $pdo;
    private $entityManager;
    private $tableName = 'purchase_order';

    public function __construct(PDO $_pdo, PurchaseOrderEntityManager $_pem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_pem;
    }

    /**
     * @param array
     * @return PurchaseOrder
     */
    private function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of PurchaseOrder instances or an empty array
     */
    public function find(array $binding, string $query, string $detailQuery = '') {

        $stmt = $this->executeQuery($binding, $query);
        $resultSet = $stmt->fetchAll();

        /* check if no matching records are found */
        if (!is_array($resultSet)) {
            exit('Failure');
        }


        // find purchase order details
        if ($detailQuery) {
            foreach ($resultSet as &$r) { // assigned by reference
                // append to resultset or a new one
                // the result set will have a items key containing the details
                $details = $this->findDetails(['purchase_order_id' => $r['purchase_order_id']], $detailQuery);
                $r['items'] = $details;
            }
        }

        $purchaseOrders = [];
        foreach ($resultSet as $record) {
            $record['_origin'] = 'database';
            $purchaseOrders[] = $this->createEntity($record);
        }
        return $purchaseOrders;
    }

    private function findDetails(array $bindings, $query) {
        $stmt = $this->executeQuery($bindings, $query);
        $resultSet = $stmt->fetchAll();
        return $resultSet;
    }

    /**
     * @param PurchaseOrder
     * @return array
     */
    public function insert(PurchaseOrder $purchaseOrder) {

        try {
            $this->pdo->beginTransaction();

            $purchaseOrderBindings = $this->getPurchaseOrderBindings($purchaseOrder);

            $detailBindings = $purchaseOrderBindings['details'];
            unset($purchaseOrderBindings['details']);

            $sql = "INSERT INTO purchase_order (purchase_order_id, date, shipping_date, supplier_id, remarks) VALUES (:purchase_order_id, :date, :shipping_date, (SELECT supplier_id FROM supplier WHERE supplier_id = :supplier_id), :remarks)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($purchaseOrderBindings);

            $sql = "INSERT INTO purchase_order_detail (purchase_order_id, item_id, quantity) VALUES ((SELECT purchase_order_id FROM purchase_order WHERE purchase_order_id = :purchase_order_id), (SELECT item_id FROM item WHERE item_id = :item_id), :quantity)";

            $stmt = $this->pdo->prepare($sql);

            foreach ($detailBindings as $d) {
                $stmt->execute($d);
            }

            $result = $this->pdo->commit();

            if ($result === true) { // explicit checking (don't trust pdo commit)
                $data = ['id' => $purchaseOrderBindings['purchase_order_id'], 'name' => $purchaseOrderBindings['date']];

                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\Exception $ex) {
            exit(var_dump($ex));
            $this->pdo->rollBack();
            // you can handle possible concurrency issue
            // (same primary key here too)
            // var_dump($ex->getMessage());
            return (int) $ex->getCode();
        }
    }

    /**
     * @param PurchaseOrder
     * @return array
     */
    public function update(PurchaseOrder $purchaseOrder) {
        exit('under construction');
        $bindings = $this->getBindings($purchaseOrder);

        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE purchase_order SET subcategory_name = :subcategory_name, category_id = (SELECT category_id FROM category WHERE category_id = :category_id) WHERE purchase_order_id=:purchase_order_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) { // explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['subcategory_id'], 'name' => $bindings['subcategory_name']];

                return [
                    'result' => $result,
                    'data' => $data,
                ];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\Exception $ex) {
            exit(var_dump($ex));
            $this->pdo->rollBack();
            // you can handle possible concurrency issue
            // (same primary key here too)
            // var_dump($ex->getMessage());
            return (int) $ex->getCode();
        }
    }

    private function getPurchaseOrderBindings(PurchaseOrder $purchaseOrder) {

        $bindings = [
            'purchase_order_id' => $purchaseOrder->getPurchaseOrderId() ?? $this->generatePurchaseOrderId(),
            'remarks' => $purchaseOrder->getRemarks(),
            'date' => $purchaseOrder->getDate()->format('Y-m-d H:i:s'),
            'shipping_date' => $purchaseOrder->getShippingDate()->format('Y-m-d H:i:s'),
            'supplier_id' => $purchaseOrder->getSupplier()->getId(),
        ];
        $bindings['details'] = $this->getPurhaseOrderDetailBindings($bindings['purchase_order_id'], $purchaseOrder);
        return $bindings;
    }

    private function getPurhaseOrderDetailBindings(string $id, PurchaseOrder $purchaseOrder) {
        $bindings = [];
        $items = $purchaseOrder->getItems();
        foreach ($items as $item) {
            $itemBinding = [
                'purchase_order_id' => $id,
                'item_id' => $item->getId(),
                'quantity' => $item->getQuantity(),
            ];
            $bindings[] = $itemBinding;
        }
        return $bindings;
    }

    /**
     * Generate a unique key for the PurchaseOrder table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    protected function generatePurchaseOrderId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "PUR-ORD" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
