<?php

namespace sbwms\Model\Inventory\Category;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Inventory\Category\Subcategory;
use sbwms\Model\Inventory\Category\SubcategoryEntityManager;

class SubcategoryMapper extends BaseMapper {
    /** @var PDO */
    protected $pdo;
    private $entityManager;
    private $tableName = 'subcategory';

    public function __construct(PDO $_pdo, SubcategoryEntityManager $_scem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_scem;
    }

    /**
     * @param array
     * @return Subcategory
     */
    private function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of Subcategory instances or an empty array
     */
    public function find(array $binding, string $query) {

        $stmt = $this->executeQuery($binding, $query);
        $resultSet = $stmt->fetchAll();

        /* check if no matching records are found */
        if (!is_array($resultSet)) {
            exit('Failure');
        }

        $subcategories = [];
        foreach ($resultSet as $record) {
            $record['_origin'] = 'database';
            $subcategories[] = $this->createEntity($record);
        }
        return $subcategories;
    }

    /**
     * @param Subcategory
     * @return array
     */
    public function insert(Subcategory $subcategory) {
        $bindings = $this->getBindings($subcategory);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO subcategory (subcategory_id, subcategory_name, category_id) VALUES (:subcategory_id, :subcategory_name, (SELECT category_id FROM category WHERE category_id = :category_id))";

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

    /**
     * @param Subcategory
     * @return array
     */
    public function update(Subcategory $subcategory) {
        $bindings = $this->getBindings($subcategory);

        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE subcategory SET subcategory_name = :subcategory_name, category_id = (SELECT category_id FROM category WHERE category_id = :category_id) WHERE subcategory_id=:subcategory_id";

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

    private function getBindings(Subcategory $subcategory) {

        $bindings = [
            'subcategory_id' => $subcategory->getSubcategoryId() ?? $this->generateSubcategoryId(),
            'subcategory_name' => $subcategory->getSubcategoryName(),
            'category_id' => $subcategory->getCategory()->getId(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key for the Subcategory table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    protected function generateSubcategoryId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "SCAT" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
