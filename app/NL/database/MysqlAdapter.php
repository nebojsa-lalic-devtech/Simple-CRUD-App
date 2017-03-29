<?php

namespace app\NL\database;

use PDO;

class MysqlAdapter implements IAdapter
{
    public function createConnection()
    {
        try {
            $dataSourceName = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $databaseConnection = new PDO($dataSourceName, DB_USER, DB_PASS);
            $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $databaseConnection;
        } catch (\Exception $ex) {
            echo "***** CONNECTION TO MYSQL DATABASE FAILED! *****" . $ex->getMessage();
        }
    }
}