<?php

namespace sbwms;
use PDO;
use PDOException;

class PDOAdapter {
    private $connection;

    public function __construct(PDO $_connection) {
        $this->connection = $_connection;
    }

    /**
     * Query the database to return all records of a database table
     * 
     * @param string $table Table name
     * @return array|null An array of arrays or null if no records
     */
    public function findAll(string $tableName) {
        $sql = "SELECT * FROM $tableName";
        $stmt = $this->connection->prepare($sql); // returns a statement object
        $stmt->execute();
        $result_set = $stmt->fetchAll();
        if (is_array($result_set) && count($result_set) === 0) {
            return null; 
        }
        /* If result_set is false then its a failure somewhere */
        if (is_bool($result_set) && $result_set === FALSE) {
            // /* TODO */ handle this conveniently
            exit('FetchAll Failure');
        }
        return $result_set;
    }

    /**
     * Find a specific record in the specified table
     * 
     * @param array $binding An assoc. array containing the table column name
     *  and value. E.g.
     *  * $binding = ['customer_id' => 'C0001']
     * 
     * @param string $tableName 
     * @return array|null Returns a single record or null if 
     * a record is not found.
     */
    public function findByField(array $binding, string $tableName) {
        $column = key($binding); // column name i.e customer_id
        $value = $binding[$column]; // attribute value 'C0001'                                                                      
        $sql = "SELECT * FROM $tableName WHERE $column = :field";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['field' => $value]);
        $result_set = $stmt->fetchAll();

        /* If result_set is false then its a failure somewhere */
        if (is_bool($result_set) && $result_set === FALSE) {
            // /* TODO */ handle this conveniently
            exit('FetchAll Failure');
        }

        /* check if no matching records are found */
        if (is_array($result_set) && count($result_set) === 0) {
            return null; 
        }
        return ($result_set);
    }

    /**
     * Insert a record into database
     * 
     * @param array $binding Contains the columns and their 
     * corresponding values.
     *  * $binding = ['customer_id' => 'C0001', 'first_name' => 'Anne']
     * @param string $tableName
     * @return 
     */
    public function insert(array $bindings, string $tableName) {
        $keys = array_keys($bindings); // the keys are the table columns
        $columns = implode(", ", $keys); // becomes 'customer_id, first_name'
        $placeholders = ":" . implode(", :", $keys); // becomes ':customer_id, :first_name'
    
        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);
        foreach ($bindings as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        try {
            $result = $stmt->execute();
        } catch (PDOException $ex) {
            $result = $ex->getMessage();
        }
        return $result;
    }

    /**
     * Update a record in the database
     * 
     * @param array $binding An assoc. array with column and and updated values
     * The first element should be the id or condition to identify the record.
     *  * $binding = ['customer_id' = 'C0001', 'first_name' => 'Dirun']
     * @param string $tableName
     */
    public function update(array $bindings, string $tableName) {
        $keys = array_keys($bindings); // the keys are the table columns
        
        // get the identifier into two variables
        $idName = array_shift($keys);
        $idValue = array_shift($bindings);
        
        // Prepare the SET portion of the update sql query
        // e.g. "first_name = :first_name"
        $setString = "";
        foreach ($bindings as $key => $value) {
            $setString .= "$key = :$key, ";
        }
        $setString = rtrim($setString, ', ');
        
        // push identifier back into $bindings
        $bindings[$idName] = $idValue;

        $sql = "UPDATE $tableName SET $setString WHERE $idName = :$idName";
        $stmt = $this->connection->prepare($sql);
        foreach ($bindings as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        try {
            $result = $stmt->execute();
        } catch (PDOException $ex) {
            $result = $ex->getMessage();
        }
        return $result;
    }

    /**
     * Get the row count of a table
     * 
     * @param string The table name
     * @return int The number of rows
     */
    public function getRowCount(string $tableName) {
        $count = $this->connection->query("SELECT COUNT(*) FROM $tableName")->fetchColumn();
        return $count;

    }
}