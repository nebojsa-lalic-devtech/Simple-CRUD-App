<?php

namespace app\NL\database;

use PDO;
use PDOException;

class Database
{
    private $host = Config::DB_HOST;
    private $dbname = Config::DB_NAME;
    private $user = Config::DB_USER;
    private $pass = Config::DB_PASS;
    private $connection;

    /**
     * @return PDO
     */
    public function getConnectionToDatabase()
    {
        $connection = $this->connection;
        try {
            $dataSourceName = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $connection = new \PDO($dataSourceName, $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'Connection failed: ' . $ex->getMessage();
        }
        return $connection;
    }

    /**
     * @param $sql
     * @return \PDOStatement
     */
    public function setQuery ($sql) {
        $connection = $this->getConnectionToDatabase();
        $query = $connection->query($sql);

        return $query;
    }
}