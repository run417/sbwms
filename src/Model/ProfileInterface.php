<?php

namespace sbwms\Model;

interface ProfileInterface {
    public function getId();
    public function getEmail();
    public function getRole();
}