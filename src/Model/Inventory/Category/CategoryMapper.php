<?php

namespace sbwms\Model\Inventory\Category;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Inventory\Category\Category;
use sbwms\Model\Inventory\Category\CategoryEntityManager;

class CategoryMapper extends BaseMapper {
    /** @var PDO */
    protected $pdo;
    private $entityManager;
    private $tableName = 'category';

    public function __construct(PDO $_pdo, CategoryEntityManager $_cem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_cem;
    }

    /**
     * @param array
     * @return Category
     */
    private function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of Category instances or an empty array
     */
    public function find(array $binding, string $query) {

        $stmt = $this->executeQuery($binding, $query);
        $resultSet = $stmt->fetchAll();

        /* check if no matching records are found */
        if (!is_array($resultSet)) {
            exit('Failure');
        }

        $categories = [];
        foreach ($resultSet as $record) {
            $record['_origin'] = 'database';
            $categories[] = $this->createEntity($record);
        }
        return $categories;
    }

    /**
     * @param Category
     * @return array
     */
    public function insert(Category $category) {
        $bindings = $this->getBindings($category);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO category (category_id, category_name) VALUES (:category_id, :category_name)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) { // explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['category_id'], 'name' => $bindings['category_name']];

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
     * @param Category
     * @return array
     */
    public function update(Category $category) {
        $bindings = $this->getBindings($category);

        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE category SET category_name = :category_name WHERE category_id=:category_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) { // explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['category_id'], 'name' => $bindings['category_name']];

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

    private function getBindings(Category $category) {

        $bindings = [
            'category_id' => $category->getCategoryId() ?? $this->generateCategoryId(),
            'category_name' => $category->getName(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key for the Category table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    protected function generateCategoryId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "CAT" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
