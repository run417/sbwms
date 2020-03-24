<?php

namespace sbwms\Model;

use PDO;

class Validator {
    private $pdo;

    public function __construct(PDO $_pdo) {
        $this->pdo = $_pdo;
    }

    public function isUsernameUnique(string $username) {
        $sql = "SELECT COUNT(*) FROM user WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetchColumn() === 0;
    }

    public function isServiceTypeNameUnique(string $name, $currentId) {
        $currentName = false;
        if ($this->checkId($currentId)) {
            $sql = "SELECT name FROM service_type WHERE service_type_id = :service_type_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['service_type_id' => $currentId]);
            $currentName = $stmt->fetchColumn() === $name;
        }
        $sql = "SELECT COUNT(*) FROM service_type WHERE name = :name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['name' => $name]);
        $duplicate = $stmt->fetchColumn() === 0;
        return $duplicate || $currentName;
    }

    public function isServiceTypeValid(string $st) {
        $sql = "SELECT * FROM service_type WHERE service_type_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$st]);
        return ($stmt->rowCount() === 1);
    }

    public function isUserRoleValid(string $userRole) {
        $roles = ['customer', 'technician', 'supervisor', 'sales', 'admin'];
        return in_array($userRole, $roles);
    }

    /**
     * Check if id is an empty string or null
     * @param mixed The value of the id
     * @return bool Returns true if NOT empty string or null
     */
    private function checkId($id) {
        if ($id === null || $id === '') {
            return false;
        }
        return true;
    }
}