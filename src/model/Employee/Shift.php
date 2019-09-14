<?php

namespace sbwms\Employee;

class Shift {
    private $start;
    private $end;
    private $name;

    public function __construct(array $args) {
        $this->start = $args['start'];
        $this->end = $args['end'];
        $this->name = $args['name'];
    }

    /**
     * Get the value of start
     */ 
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the value of end
     */ 
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }
}