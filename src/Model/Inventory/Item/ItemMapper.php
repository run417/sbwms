<?php

namespace sbwms\Model\Inventory\Item;

use sbwms\Model\BaseMapper;
use sbwms\Model\Inventory\Item\Item;
use sbwms\Model\Inventory\Item\ItemEntityManager;
use PDO;

class ItemMapper extends BaseMapper {
    protected $pdo;
    private $entityManager;
    private $tableName = 'item';

    public function __construct(PDO $_pdo, ItemEntityManager $_entityManager) {
        $this->pdo = $_pdo;
        $this->entityManager = $_entityManager;
    }

    /**
     * @param array
     * @return Item
     */
    private function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of Item instances or an empty array
     */
    public function find(array $binding=[], string $query='') {
        $stmt = $this->executeQuery($binding, $query);
        $resultSet = $stmt->fetchAll();

        /* check if no matching records are found */
        if (!is_array($resultSet)) {
            exit('Failure');
        }

        $items = [];
        foreach ($resultSet as $record) {
            $record['dataSource'] = 'database';
            $items[] = $this->createEntity($record);
        }
        return $items;
    }

    /**
     * @param Item
     * @return array
     */
    public function insert(Item $item) {
        $bindings = $this->getBindings($item);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO item (item_id, item_name, description, make, model, brand, quantity, reorder_level, subcategory_id, supplier_id) VALUES (:item_id, :item_name, :description, :make, :model, :brand, :quantity, :reorder_level, (SELECT subcategory_id FROM subcategory WHERE subcategory_id = :subcategory_id), (SELECT supplier_id FROM supplier WHERE supplier_id = :supplier_id))";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) {// explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['item_id'], 'name' => $bindings['item_name']];

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
     * @param Item
     * @return array
     */
    public function update(Item $item) {
        $bindings = $this->getBindings($item);

        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE item SET item_name = :item_name, description = :description, make = :make, model = :model, brand = :brand, quantity = :quantity, reorder_level = :reorder_level, subcategory_id = (SELECT subcategory_id FROM subcategory WHERE subcategory_id = :subcategory_id), supplier_id = (SELECT supplier_id FROM supplier WHERE supplier_id = :supplier_id) WHERE item_id=:item_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) {// explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['item_id'], 'name' => $bindings['item_name']];

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

    private function getBindings(Item $item) {
        $bindings = [
            'item_id' => $item->getItemId() ?? $this->generateItemId(),
            'item_name' => $item->getName(),
            'description' => $item->getDescription(),
            'make' => $item->getMake(),
            'model' => $item->getModel(),
            'brand' => $item->getBrand(),
            'quantity' => $item->getQuantity(),
            'reorder_level' => $item->getReorderLevel(),
            'subcategory_id' => $item->getSubcategory()->getId(),
            'supplier_id' => $item->getSupplier()->getId(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key for the Item table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    protected function generateItemId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "IT" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }
}