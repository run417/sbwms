<?php

namespace sbwms\Model\User;

use sbwms\Model\BaseMapper;
use sbwms\Model\User\User;
use sbwms\Model\User\UserEntityManager;
use PDO;

class UserMapper extends BaseMapper {
    /** @var PDO */
    protected $pdo;
    private $tableName = 'user';
    private $userEntityManager;

    public function __construct(PDO $_pdo, UserEntityManager $_userEntityManager) {
        $this->pdo = $_pdo;
        $this->userEntityManager = $_userEntityManager;
    }

    public function createEntity(array $data) {
        return $this->userEntityManager->createEntity($data);
    }


    public function find(array $bindings = [], string $query = '') {

        $stmt = $this->executeQuery($bindings, $query);

        $result_set = $stmt->fetchAll();
        /* If result_set is false then its a failure somewhere */
        if (is_bool($result_set) && $result_set === FALSE) {
            // /* TODO */ handle this conveniently
            exit('FetchAll Failure');
        }

        /* check if no matching records are found */
        // if (is_array($result_set) && count($result_set) === 0) {
        //     return null;
        // }

        $users = [];
        if ($stmt->rowCount() >= 1) {
            foreach ($result_set as $record) {
                $record['_origin'] = 'database';
                $users[] = $this->createEntity($record);
            }
            // if (\count($users) === 1) { return \array_shift($users); }

            return $users;
        }
    }

    public function insert(User $user) {
        $userBindings = $this->getUserBindings($user);

        $sql = "INSERT INTO `user` (`user_id`, `username`, `hashed_password`, `user_account_type`, `user_role`, `user_status`, `profile_id`) VALUES (:user_id, :username, :hashed_password, :user_account_type, :user_role, :user_status, :profile_id)";

        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($userBindings);
            $result = $this->pdo->commit();
            if ($result) {
                $data = ['userId' => $userBindings['user_id']];
                return [
                    'result' => $result,
                    'data' => $data,
                ];
            }
        } catch (\Exception $ex) {
            exit(\var_dump($ex));
        }
    }

    public function update() {
    }

    /**
     * Extract properties of an User object to an php array
     *
     *
     * @param User An instance of the User object
     * @return array An array that contain key-value pairs of
     * database table fields and values.
     */
    private function getUserBindings(User $user) {
        $bindings = [
            'user_id' => $user->getUserId ?? $this->generateUserId(),
            'username' => $user->getUsername(),
            'hashed_password' => $user->getPassword(),
            'user_account_type' => $user->getAccountType(),
            'user_role' => $user->getUserRole(),
            'user_status' => $user->getStatus(),
            'profile_id' => $user->getProfile()->getId(),
        ];
        return $bindings;
    }

    /**
     * Generate a unique key for the Booking table
     *
     * This is generated using the row count of a table
     *
     * @return string The id
     */
    private function generateUserId() {
        $count = $this->getRowCount($this->tableName) + 1;
        $id = "U" . str_pad($count, 4, '0', STR_PAD_LEFT);
        return $id;
    }
}
