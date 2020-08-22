<?php

namespace sbwms\Model\Inventory\Grn;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Inventory\Grn\Grn;

class GrnMapper extends BaseMapper {
    /** @var PDO */
    protected $pdo;
    private $entityManager;
    private $tableName = 'grn';

    public function __construct(PDO $_pdo, GrnEntityManager $_gem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_gem;
    }

    /**
     * @param array
     * @return Grn
     */
    private function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of Grn instances or an empty array
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
                $details = $this->findDetails(['grn_id' => $r['grn_id']], $detailQuery);
                $r['details'] = $details;
            }
        }

        $grns = [];
        foreach ($resultSet as $record) {
            $record['_origin'] = 'database';
            $grns[] = $this->createEntity($record);
        }
        return $grns;
    }

    private function findDetails(array $bindings, $query) {
        $stmt = $this->executeQuery($bindings, $query);
        $resultSet = $stmt->fetchAll();
        return $resultSet;
    }

    /**
     * @param Grn
     * @return array
     */
    public function insert(Grn $grn) {

        try {
            $this->pdo->beginTransaction();

            $grnBindings = $this->getGrnBindings($grn);

            $detailBindings = $grnBindings['details'];
            unset($grnBindings['details']);

            $itemUpdateBindings = $grnBindings['item_update_bindings'];
            unset($grnBindings['item_update_bindings']);

            $sql = "INSERT INTO grn (grn_id, grn_date, purchase_order_id, supplier_id) VALUES (:grn_id, :grn_date, (SELECT purchase_order_id FROM purchase_order WHERE purchase_order_id = :purchase_order_id), (SELECT supplier_id FROM supplier WHERE supplier_id = :supplier_id))";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($grnBindings);

            $sql = "INSERT INTO grn_detail (grn_id, item_id, quantity, unit_price, selling_price) VALUES ((SELECT grn_id FROM grn WHERE grn_id = :grn_id), (SELECT item_id FROM item WHERE item_id = :item_id), :quantity, :unit_price, :selling_price)";

            $stmt = $this->pdo->prepare($sql);

            foreach ($detailBindings as $d) {
                $stmt->execute($d);
            }

            $sql = "UPDATE item SET quantity = quantity + :quantity, selling_price = :selling_price WHERE item_id = :item_id";

            $stmt = $this->pdo->prepare($sql);

            foreach ($itemUpdateBindings as $i) {
                $stmt->execute($i);
            }

            $result = $this->pdo->commit();

            if ($result === true) { // explicit checking (don't trust pdo commit)
                $data = ['id' => $grnBindings['grn_id'], 'name' => $grnBindings['grn_date']];

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
     * @param Grn
     * @return array
     */
    public function update(Grn $grn) {
        exit('under construction');
        $bindings = $this->getBindings($grn);

        try {
            $this->pdo->beginTransaction();

            $sql = "";

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

    private function getGrnBindings(Grn $grn) {
        $bindings = [
            'grn_id' => $grn->getGrnId() ?? $this->generateGrnId(),
            'grn_date' => $grn->getDate()->format('Y-m-d H:i:s'),
            'purchase_order_id' => $grn->getPurchaseOrder()->getId(),
            'supplier_id' => $grn->getPurchaseOrder()->getSupplier()->getId(),
        ];
        $bindings['details'] = $this->getGrnDetailBindings($bindings['grn_id'], $grn);
        $bindings['item_update_bindings'] = $this->getItemUpdateBindings($grn);
        return $bindings;
    }

    private function getGrnDetailBindings(string $id, Grn $grn) {
        $bindings = [];
        $grnItems = $grn->getGrnItems();
        foreach ($grnItems as $grnItem) {
            $detailBinding = [
                'grn_id' => $id,
                'item_id' => $grnItem->getItem()->getId(),
                'quantity' => $grnItem->getQuantity(),
                'unit_price' => $grnItem->getUnitPrice(),
                'selling_price' => $grnItem->getSellingPrice(),
            ];
            $bindings[] = $detailBinding;
        }
        return $bindings;
    }

    private function getItemUpdateBindings(Grn $grn) {
        $bindings = [];
        $grnItems = $grn->getGrnItems();
        foreach ($grnItems as $grnItem) {
            $detailBinding = [
                'item_id' => $grnItem->getItem()->getId(),
                'quantity' => $grnItem->getQuantity(),
                'selling_price' => $grnItem->getSellingPrice(),
            ];
            $bindings[] = $detailBinding;
        }
        return $bindings;
    }

    /**
     * Generate a unique key for the Grn table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    protected function generateGrnId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "GRN" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
