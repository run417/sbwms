<?php

namespace sbwms\Model;

use PDO;
use sbwms\Model\BaseMapper;

class RecordFinderService extends BaseMapper {
    protected $pdo;

    public function __construct(PDO $_p) {
        $this->pdo = $_p;
    }

    /**
     * @return array
     */
    public function findAllServiceCrew() {
        $sql = "SELECT * FROM employee WHERE employee_position_id=:pid";
        $bindings = ['pid' => 104];
        $stmt = $this->executeQuery($bindings, $sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function findJobCardItems(string $id) {
        $sql = "SELECT job_card_item.item_id, item.item_name, item.selling_price, job_card_item.quantity  FROM job_card_item LEFT JOIN item ON job_card_item.item_id=item.item_id WHERE job_card_item.job_card_id=:id";
        $bindings = ['id' => $id];
        $stmt = $this->executeQuery($bindings, $sql);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getAllCentreTime() {
        $sql = "SELECT * FROM working_time WHERE employee_id=:id";
        $bindings = ['id' => 'centre'];
        $stmt = $this->executeQuery($bindings, $sql);
        $result = $stmt->fetchAll();
        return $result;
    }
}