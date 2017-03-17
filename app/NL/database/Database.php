<?php

namespace app\NL\database;

use MongoDB\Driver\Exception\ConnectionException;
use MongoDB\Driver\Manager;
use PDO;
use PDOException;

class Database
{
    private $dbHost;
    private $dbName;
    private $user;
    private $pass;
    private $currentDb = Config::CURRENT_DB;
    private $connection;

    /**
     * @return PDO
     */
    public function connectToMySQLDatabase()
    {
        $this->dbHost = Config::DB_HOST_MYSQL;
        $this->dbName = Config::DB_NAME_MYSQL;
        $this->user = Config::DB_USER_MYSQL;
        $this->pass = Config::DB_PASS_MYSQL;
        $connection = $this->connection;
        try {
            $dataSourceName = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            $connection = new \PDO($dataSourceName, $this->user, $this->pass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo 'Connection failed: ' . $ex->getMessage();
        }
        return $connection;
    }

    /**
     * @return Manager
     */
    public function connectToMongoDatabase()
    {
//        $this->dbHost = Config::DB_HOST_MONGO;
//        $this->dbName = Config::DB_NAME_MONGO;
//        $this->user = Config::DB_USER_MONGO;
//        $this->pass = Config::DB_PASS_MONGO;

        return $this->connection = new Manager('mongodb://localhost:27017');
    }
    
    public function getDatabaseConnection () {
        if ($this->currentDb == 'mysql') {
            $this->connection = $this->connectToMySQLDatabase();
            return $this->connection;
        } else if ($this->currentDb == 'mongodb') {
            $this->connection = $this->connectToMongoDatabase();
            return $this->connection;
        } else {
            throw new ConnectionException('***** BASE YOU SPECIFY DO NOT EXCIST *****');
        }
    }
}