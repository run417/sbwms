<?php

namespace sbwms\Model\Service\Bay;

class Bay {
    private $bayId;
    private $type;
    private $status;

    public function __construct(array $args) {
        $this->bayId = $args['bayId'] ?? null;
        $this->type = $args['bayType'];
        $this->status = $args['bayStatus'];
    }

    /**
     * Get the value of bayId
     */
    public function getBayId()
    {
        return $this->bayId;
    }

    /**
     * Get the value of bay type
     */
    public function getBayType()
    {
        return $this->type;
    }

    /**
     * Get the value of bay status
     */
    public function getBayStatus()
    {
        return $this->status;
    }
}