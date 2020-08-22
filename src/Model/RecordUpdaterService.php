<?php

namespace sbwms\Model;

use DateTimeImmutable;
use PDO;
use sbwms\Model\BaseMapper;
use sbwms\Model\Service\ServiceOrder\ServiceOrder;

class RecordUpdaterService extends BaseMapper {
    protected $pdo;

    public function __construct(PDO $_p) {
        $this->pdo = $_p;
    }

    public function insertItemToJobCard(array $data) {
        try {
            $this->pdo->beginTransaction();
            $sql = "INSERT INTO `job_card_item` (job_card_id, item_id, `quantity`) VALUES ((SELECT job_card_id FROM job_card WHERE job_card_id=:id), (SELECT item_id FROM item WHERE item_id=:itemId), :quantity)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $data['id'], 'itemId' => $data['itemId'], 'quantity' => $data['quantity']]);
            $sql = "UPDATE item SET quantity = quantity - :quantity WHERE item_id=:itemId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['quantity' => $data['quantity'], 'itemId' => $data['itemId']]);
            $result = $this->pdo->commit();
            return $result;
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            exit(var_dump($ex));
        }
    }

    public function removeItemFromJobCard(array $data) {
        try {
            $this->pdo->beginTransaction();
            $sql = "DELETE FROM `job_card_item` WHERE item_id=:itemId AND job_card_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $data['id'], 'itemId' => $data['itemId']]);
            $sql = "UPDATE item SET quantity = quantity + :quantity WHERE item_id=:itemId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['quantity' => $data['quantity'], 'itemId' => $data['itemId']]);
            $result = $this->pdo->commit();
            if ($result) {
                $result = [
                    'result' => $result,
                    'data' => ['id' => $data['itemId']],
                ];
            }
            return $result;
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            exit(var_dump($ex));
        }
    }

    public function saveJobCard(array $data) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE job_card SET diagnosis = :diagnosis, notes = :notes WHERE job_card_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['diagnosis' => $data['diagnosis'], 'notes' => $data['notes'], 'id' => $data['id']]);
            $result = $this->pdo->commit();
            if ($result) {
                $result = [
                    'result' => $result,
                    'data' => ['id' => $data['id']],
                ];
            }
            return $result;
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            exit(var_dump($ex));
        }
    }

    public function holdServiceOrder(ServiceOrder $serviceOrder) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE service_order SET service_status = :service_status WHERE service_order_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['service_status' => 'on-hold', 'id' => $serviceOrder->getId()]);
            $sql = "UPDATE service_time SET service_time = :service_time, last_onhold_start_datetime = :onhold_start WHERE service_order_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'service_time' => $serviceOrder->getServiceTime()->format('P%dDT%hH%iM%SS'),
                'onhold_start' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
                'id' => $serviceOrder->getId()
            ]);
            $result = $this->pdo->commit();
            if ($result) {
                $result = [
                    'result' => $result,
                    'data' => ['id' => $serviceOrder->getId()],
                ];
            }
            return $result;
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            exit(var_dump($ex));
        }
    }

    public function restartService(ServiceOrder $serviceOrder) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE service_order SET service_status = :service_status WHERE service_order_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['service_status' => 'ongoing', 'id' => $serviceOrder->getId()]);

            $sql = "UPDATE service_time SET last_onhold_end_datetime = :onhold_end, onhold_time = :onhold_time WHERE service_order_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'onhold_end' => $serviceOrder->getRestartDateTime()->format('Y-m-d H:i:s'),
                'onhold_time' => $serviceOrder->getServiceOnHoldtime()->format('P%dDT%hH%iM%SS'),
                'id' => $serviceOrder->getId()
            ]);
            $result = $this->pdo->commit();
            if ($result) {
                $result = [
                    'result' => $result,
                    'data' => ['id' => $serviceOrder->getId()],
                ];
            }
            return $result;
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            exit(var_dump($ex));
        }
    }

    public function completeService(ServiceOrder $serviceOrder) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE service_order SET service_status = :service_status WHERE service_order_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['service_status' => 'completed', 'id' => $serviceOrder->getId()]);

            $sql = "UPDATE service_time SET completed_at_datetime = :finish_time WHERE service_order_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'finish_time' => $serviceOrder->getServiceFinishTime()->format('Y-m-d H:i:s'),
                'id' => $serviceOrder->getId()
            ]);
            $result = $this->pdo->commit();
            if ($result) {
                $result = [
                    'result' => $result,
                    'data' => ['id' => $serviceOrder->getId()],
                ];
            }
            return $result;
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            exit(var_dump($ex));
        }
    }

    public function terminateService(ServiceOrder $serviceOrder) {
        try {
            $this->pdo->beginTransaction();
            $sql = "UPDATE service_order SET service_status = :service_status WHERE service_order_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['service_status' => 'terminated', 'id' => $serviceOrder->getId()]);

            $sql = "UPDATE service_time SET completed_at_datetime = :finish_time WHERE service_order_id=:id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'finish_time' => $serviceOrder->getServiceFinishTime()->format('Y-m-d H:i:s'),
                'id' => $serviceOrder->getId()
            ]);
            $result = $this->pdo->commit();
            if ($result) {
                $result = [
                    'result' => $result,
                    'data' => ['id' => $serviceOrder->getId()],
                ];
            }
            return $result;
        } catch (\Exception $ex) {
            $this->pdo->rollBack();
            exit(var_dump($ex));
        }
    }


    public function setDefaultCentreTime(string $start, string $end) {
        $sql = "UPDATE working_time SET shift_start = :start, shift_end = :end WHERE employee_id=:id AND date=:date";
        $bindings = ['start' => $start, 'end' => $end, 'id' => 'centre', 'date' => 'default'];
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($bindings);
        if ($result) {
            $result = [
                'result' => $result,
                'data' => ['id' => $data['id']],
            ];
        }
        return $result;
    }

    public function setCentreTime(string $start, string $end, string $date) {
        $sql = "INSERT INTO working_time (shift_start, shift_end, employee_id, date) VALUES (:start, :end :id, :date)";
        $bindings = ['start' => $start, 'end' => $end, 'id' => 'centre', 'date' => $date];
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($bindings);
        if ($result) {
            $result = [
                'result' => $result,
                'data' => ['id' => $data['id']],
            ];
        }
        return $result;
    }

    public function makeItemSale() {
        // $insert
    }
}
