<?php

namespace sbwms\Model\Inventory\Supplier;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Inventory\Supplier\Supplier;
use sbwms\Model\Inventory\Supplier\SupplierEntityManager;

class SupplierMapper extends BaseMapper{
    /** @var PDO */
    protected $pdo;
    private $entityManager;
    private $tableName = 'supplier';

    public function __construct(PDO $_pdo, SupplierEntityManager $_cem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_cem;
    }

    /**
     * @param array
     * @return Supplier
     */
    private function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of Supplier instances or an empty array
     */
    public function find(array $binding, string $query) {

        $stmt = $this->executeQuery($binding, $query);
        $resultSet = $stmt->fetchAll();

        /* check if no matching records are found */
        if (!is_array($resultSet)) {
            exit('Failure');
        }

        $suppliers = [];
        foreach ($resultSet as $record) {
            $record['dataSource'] = 'database';
            $suppliers[] = $this->createEntity($record);
        }
        return $suppliers;
    }

    /**
     * @param Supplier
     * @return array
     */
    public function insert(Supplier $supplier) {
        $bindings = $this->getBindings($supplier);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO supplier (supplier_id, supplier_name, company_name, telephone, email) VALUES (:supplier_id, :supplier_name, :company_name, :telephone, :email)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) {// explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['supplier_id'], 'name' => $bindings['company_name']];

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
     * @param Supplier
     * @return array
     */
    public function update(Supplier $supplier) {
        $bindings = $this->getBindings($supplier);

        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE supplier SET supplier_name = :supplier_name, company_name = :company_name, telephone = :telephone, email = :email WHERE supplier_id=:supplier_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) {// explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['supplier_id'], 'name' => $bindings['company_name']];

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

    private function getBindings(Supplier $supplier) {

        $bindings = [
            'supplier_id' => $supplier->getSupplierId() ?? $this->generateSupplierId(),
            'supplier_name' => $supplier->getSupplierName(),
            'company_name' => $supplier->getCompanyName(),
            'telephone' => $supplier->getTelephone(),
            'email' => $supplier->getEmail(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key for the Supplier table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    protected function generateSupplierId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "SUP" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }
}