<?php

namespace sbwms\Model\Service\Bay;

use sbwms\Model\Service\Bay\Bay;
use sbwms\Model\Service\Bay\BayMapper;

class BayRepository {
    private $bayMapper;

    public function __construct(BayMapper $_baym) {
        $this->bayMapper = $_baym;
    }

    public function findAll() {
        $sql = "SELECT * FROM bay";
        $bays = $this->bayMapper->find([], $sql);
        return $bays;
    }

    public function findById($id) {
        $sql = "SELECT * FROM bay WHERE bay_id=:bay_id";
        $bindings = ['bay_id' => $id];
        $bay = $this->bayMapper->find($bindings, $sql);
        return array_shift($bay);
    }

    public function save(Bay $bay) {
        if ($bay->getBayId() === null) {
            return $this->bayMapper->insert($bay);
        }
        return $this->bayMapper->update($bay);
    }
}