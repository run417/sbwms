<?php

namespace sbwms\Model\User;

use sbwms\Model\User\User;
use sbwms\Model\User\UserMapper;

class UserRepository {
    private $userMapper;

    public function __construct(UserMapper $_userMapper) {
        $this->userMapper = $_userMapper;
    }

    public function findById(string $id) {
    }

    public function findByUsername(string $username) {
        $sql = "SELECT * FROM system_user WHERE username=:u";
        $bindings = ['u' => $username];
        $user = $this->userMapper->find($bindings, $sql);
        return ($user);
    }

    public function findAll() {
        $sql = "SELECT * FROM system_user";
        $bindings = [];
        return $this->userMapper->find([], $sql);
    }

    public function save(User $user) {
        if ($user->getUserId() === null) {
            return $this->userMapper->insert($user);
        }
        return $this->userMapper->update($user);
    }
}
