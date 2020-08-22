<?php

namespace sbwms\Model\Service\Job;

class JobRepository {

    private $mapper;

    public function __construct(JobMapper $_jm) {
        $this->mapper = $_jm;
    }

    public function save(Job $j) {
        if ($j->getId() === null) {
            return $this->mapper->insert($j);
        }
        exit('no job id - jobrepository - no job updates');
    }
}