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
    private $currentDb;

    private static $connection = null;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $config = new Config();
        $this->currentDb = $config->currentDbName;
        switch ($this->currentDb) {
            case 'mysql':
                $this->dbHost = $config->dbHostMySql;
                $this->dbName = $config->dbNameMySql;
                $this->user = $config->dbUserMySql;
                $this->pass = $config->dbPassMySql;
                self::$connection = $this->connectToMySQLDatabase();
                break;
            case 'mongodb':
                $this->dbHost = $config->dbHostMongoDb;
                $this->dbName = $config->dbNameMongoDb;
                $this->user = $config->dbUserMongoDb;
                $this->pass = $config->dbPassMondoDb;
                self::$connection = $this->connectToMongoDatabase();
                break;
            default:
                throw new ConnectionException('***** BASE YOU SPECIFY DOES NOT EXIST *****');
                break;
        }
    }

    /**
     * @return null|PDO
     */
    private function connectToMySQLDatabase()
    {
        if (self::$connection == null) {
            try {
                $dataSourceName = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
                self::$connection = new \PDO($dataSourceName, $this->user, $this->pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $ex) {
                echo 'Connection to MySQL base failed: ' . $ex->getMessage();
            }
        }
        return self::$connection;
    }

    /**
     * @return Manager|null
     */
    private function connectToMongoDatabase()
    {
        if (self::$connection == null) {
            try {
                self::$connection = new Manager('mongodb://' . $this->dbHost . ':27017');
            } catch (ConnectionException $ex) {
                echo 'Connection to MongoDB base failed: ' . $ex->getMessage();
            }
        }
        return self::$connection;
    }

    /**
     * @return Manager|null|PDO
     */
    public function getDatabaseConnection()
    {
        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }

    /**
     * @return string
     */
    public function getCurrentDb()
    {
        return $this->currentDb;
    }
}