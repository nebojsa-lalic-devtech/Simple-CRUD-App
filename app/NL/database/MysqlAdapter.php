<?php

namespace app\NL\database;

use PDO;

class MysqlAdapter implements IAdapter
{
    public function createConnection()
    {
        try {
            $dataSourceName = 'mysql:host=' . 'localhost' . ';dbname=' . 'simple-crud-app';
            $databaseConnection = new PDO($dataSourceName, 'root', 'root');
            $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $databaseConnection;
        } catch (\Exception $ex) {
            echo "***** CONNECTION TO MYSQL DATABASE FAILED! *****" . $ex->getMessage();
        }
    }
}