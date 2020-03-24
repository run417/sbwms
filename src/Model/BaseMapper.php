<?php

namespace sbwms\Model;

// use PDO;

class BaseMapper {
    /**
     * ABSTRACT
     * Get the row count of a table
     *
     * @param string The table name
     * @return int The number of rows
     */
    protected function getRowCount(string $tableName) {
        $count = $this->pdo->query("SELECT COUNT(*) FROM $tableName")->fetchColumn();
        return $count;
    }

    /**
     * @param string The name of the database table
     * @param array The columns of the table in an array as values
     * @param array [Optional] The foreign key table name and its primary key column name
     * @param boolean Defaults to TRUE If the foreign key is in the column list then it is inserted to the table
     */
    protected function generateInsertSql(string $tableName, array $columns, $foreignTable=[], $preserveKey = true) {
        // check if keys are numerical
        $keys = \array_keys($columns);
        if ($keys[0] !== 0) {
            exit('Dev Error - Array does not contain table columns');
        }

        if (!empty($foreignTable)) {
            $tableName = \array_keys($foreignTable);
            $tableName = \array_shift($tableName);
            $idName = $foreignTable[$tableName];
            $position = \array_search($idName, $columns);
            if ($position !== false && !$preserveKey) { unset($columns[$position]); }

            $columnString = implode(", ", $columns); // becomes 'customer_id, first_name'
            $placeholders = ":" . implode(", :", $columns); // becomes ':customer_id, :first_name'

            $foreignSql = "(SELECT $idName FROM $tableName WHERE $idName = :$idName)";
            $sql = "INSERT INTO $tableName ($columnString) VALUES ($placeholders) WHERE $idName = $foreignSql";
            return $sql;
        }

        $columnString = implode(", ", $columns); // becomes 'customer_id, first_name'
        $placeholders = ":" . implode(", :", $columns); // becomes ':customer_id, :first_name'

        $sql = "INSERT INTO $tableName ($columnString) VALUES ($placeholders)";

        return $sql;
    }

    /**
     * @param string The name of the table to be updated
     * @param array An array the table columns as values
     * @param string The column name that is used to select the database row
     */
    protected function generateUpdateSql(string $tableName, array $columns, string $key) {
        // $keys = array_keys($bindings); // the keys are the table columns
        if (\array_search($key, $columns) !== false) {
            $columns = \array_diff($columns, [$key]);
        }

        // Prepare the SET portion of the update sql query
        // e.g. "first_name = :first_name"
        $setString = "";
        foreach ($columns as $column) {
            $setString .= "$column = :$column, ";
        }
        $setString = rtrim($setString, ', ');

        $sql = "UPDATE $tableName SET $setString WHERE $key = :$key";
        return $sql;
    }

    /**
     * @param array
     * @param string
     * @return PDOStatement
     */
    protected function executeQuery(array $binding, string $query) {

        if (empty($binding) && !empty($query)) { // no bindings
            $sql = $query;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($binding);
        }

        // if there both bindings and sql are provided
        if (!empty($binding) && !empty($query)) {
            $sql = $query;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($binding);
        }

        return $stmt;
    }
}