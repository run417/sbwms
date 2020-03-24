<?php

namespace sbwms\Model\Service\Bay;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Service\Bay\Bay;
use sbwms\Model\Service\Bay\BayEntityManager;

class BayMapper extends BaseMapper{
    /** @var PDO */
    protected $pdo;
    private $entityManager;
    private $tableName = 'bay';

    public function __construct(PDO $_pdo, BayEntityManager $_bayem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_bayem;
    }

    /**
     * @param array
     * @return Bay
     */
    private function createEntity(array $attributes) {
        return $this->entityManager->createEntity($attributes);
    }

    /**
     * @param array bindings
     * @param string sql query
     * @return array an array of Bay instances or an empty array
     */
    public function find(array $binding, string $query) {

        $stmt = $this->executeQuery($binding, $query);
        $resultSet = $stmt->fetchAll();

        /* check if no matching records are found */
        if (!is_array($resultSet)) {
            exit('Failure');
        }

        $bays = [];
        foreach ($resultSet as $record) {
            $record['dataSource'] = 'database';
            $bays[] = $this->createEntity($record);
        }
        return $bays;
    }

    /**
     * @param Bay
     * @return array
     */
    public function insert(Bay $bay) {
        $bindings = $this->getBindings($bay);

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO bay (bay_id, bay_type, bay_status) VALUES (:bay_id, :bay_type, :bay_status)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) {// explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['bay_id'], 'name' => $bindings['bay_type']];

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
     * @param Bay
     * @return array
     */
    public function update(Bay $bay) {
        $bindings = $this->getBindings($bay);

        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE bay SET bay_type = :bay_type, bay_status = :bay_status WHERE bay_id=:bay_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($bindings);
            $result = $this->pdo->commit();

            if ($result === true) {// explicit checking (don't trust pdo commit)
                $data = ['id' => $bindings['bay_id'], 'name' => $bindings['bay_type']];

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

    private function getBindings(Bay $bay) {

        $bindings = [
            'bay_id' => $bay->getBayId() ?? $this->generateBayId(),
            'bay_type' => $bay->getBayType(),
            'bay_status' => $bay->getBayStatus(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key for the Bay table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    protected function generateBayId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "BAY" . str_pad($count, 4, '0', STR_PAD_LEFT) ;
        return $id;
    }
}