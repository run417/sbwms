<?php

namespace sbwms\Model\Centre\BusinessHours;

use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Centre\BusinessHours\BusinessHoursEntityManager;
use sbwms\Model\Centre\BusinessHours\BusinessHours;

class BusinessHoursMapper extends BaseMapper {

    protected $pdo;
    private $entityManager;
    private $tableName = 'operating_period';

    public function __construct(PDO $_pdo, BusinessHoursEntityManager $_eem) {
        $this->pdo = $_pdo;
        $this->entityManager = $_eem;
    }

    public function createEntity(array $data) {
        $businessHours = $this->entityManager->createEntity($data);
        return $businessHours;
    }

    /**
     * Find by id, Find by field, Find all
     */
    public function find(array $bindings = [], string $query = '', array $detailQueries = []) {
        $stmt = $this->executeQuery($bindings, $query);
        $result_set = $stmt->fetchAll();
        /* If result_set is false then its a failure somewhere */
        if (is_bool($result_set) && $result_set === FALSE) {
            // /* TODO */ handle this conveniently
            exit('FetchAll Failure');
        }

        $businessHours;
        $result_set['_origin'] = 'database';
        $businessHours = $this->createEntity($result_set);
        // $employees[] = ($r);
        // var_dump($employees);

        return $businessHours;
    }

    public function update(BusinessHours $op) {
        // insert employee record
        // todo: multiple inserts.
        // for each table prepare the bindings array in a different method.
        // begin the transaction inside try statement
        // make the sql string
        // prepare the string
        // bind the values from the relevant array
        // execute the statement
        // do the same for the other table
        // commit
        // catch if error and rollback
        // note: if all values are strings then you don't need to bind
        // todo: a method to get an sql insert string based on a array.

        $bindings = $this->getBusinessHoursBindings($op);

        try {
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM operating_period";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $sql = "INSERT INTO operating_period (day, opening, closing) VALUES (:day, :opening, :closing)";
            $stmt = $this->pdo->prepare($sql);
            foreach ($bindings as $b) {
                $stmt->execute($b);
            }

            $result = $this->pdo->commit();

            if ($result) {
                return ['result' => $result];
            } else {
                exit('Dev error - Result not true');;
            }
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            \var_dump($ex->getMessage());
        }
    }

    private function getBusinessHoursBindings(BusinessHours $op) {
        $days = $op->getWorkingDays();
        $bindings = [];
        foreach ($days as $day) {
            $b = [
                'day' => $day,
                'opening' => $op->getOpen($day),
                'closing' => $op->getClose($day),
            ];
            $bindings[] = $b;
        }

        return $bindings;
    }
}
