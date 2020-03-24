<?php

namespace sbwms\Model\Employee;

class Entry {
    private $start;
    private $end;
    private $date;
    private $type; // not persisted
    // private $employee

    public function __construct(array $args) {
        $this->type = $args['type'];
        $this->start = $args['start'];
        $this->end = ($args['type'] === 'shift') ? null : $args['end'];
        $this->date = $args['date'];
    }



    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of end
     */
    public function getEnd()
    {
        if ($this->getType() === 'shift') { return $this->getStart(); }
        return $this->end;
    }

    /**
     * Get the value of start
     */
    public function getStart()
    {
        return $this->start;
    }
}