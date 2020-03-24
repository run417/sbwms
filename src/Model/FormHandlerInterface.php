<?php

namespace sbwms\Model;

interface FormHandlerInterface {

    public function validate(array $data);
    public function createEntity(array $data);

}