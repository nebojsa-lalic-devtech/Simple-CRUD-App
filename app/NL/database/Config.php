<?php

namespace app\NL\database;

class Config
{
    /**
     * Choose Database
     * 'mongodb' for MongoDB Database
     * 'mysql' for MySQL Database
     */
    public $currentDbName = 'mongodb';
    
    public $dbHostMySql = 'localhost';
    public $dbNameMySql = 'simple-crud-app';
    public $dbUserMySql = 'root';
    public $dbPassMySql = 'root';

    public $dbHostMongoDb = 'localhost';
    public $dbNameMongoDb = 'guest';
    public $dbUserMongoDb = 'root';
    public $dbPassMondoDb = 'root';
}