<?php

namespace sbwms\Model\Employee;

class Shift {
    private $shiftStart;
    private $shiftEnd;
    private $breakStart;
    private $breakEnd;


    public function __construct(array $args) {
        $this->shiftStart = $args['shiftStart'];
        $this->shiftEnd = $args['shiftEnd'];
        $this->breakStart = $args['breakStart'];
        $this->breakEnd = $args['breakEnd'];
    }

    /**
     * Get the value of start
     */
    public function getShiftStart()
    {
        return $this->shiftStart;
    }

    /**
     * Get the value of end
     */
    public function getShiftEnd()
    {
        return $this->shiftEnd;
    }

    /**
     * Get the value of breakStart
     */
    public function getBreakStart()
    {
        return $this->breakStart;
    }

    /**
     * Get the value of breakEnd
     */
    public function getBreakEnd()
    {
        return $this->breakEnd;
    }
}
