<?php

namespace app\NL\database;

use MongoDB\Driver\Exception\ConnectionException;
use MongoDB\Driver\Manager;

class MongoAdapter implements IAdapter
{

    /**
     * @return Manager
     */
    public function createConnection()
    {
        try {
            $databaseConnection = new Manager('mongodb://' . DB_HOST . ':27017');
            return $databaseConnection;
        } catch (ConnectionException $ex) {
            echo 'Connection to MongoDB base failed: ' . $ex->getMessage();
        }
    }

    /**
     * @param $query
     */
    public function execute($query)
    {
        self::createConnection()->executeBulkWrite($query);
    }
}