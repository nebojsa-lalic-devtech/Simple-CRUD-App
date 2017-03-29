<?php

namespace app\NL\database;

class Database
{
    private static $connection = null;

    public function connectToDatabase()
    {
        switch ('mysql') {
            case 'mysql':
                $dbAdapter = new MysqlAdapter();
                self::$connection = $dbAdapter->createConnection();
                return self::$connection;
                break;
            case 'mongodb':
                $dbAdapter = new MongoAdapter();
                self::$connection = $dbAdapter->createConnection();
                return self::$connection;
                break;
            default:
                throw new \Exception('***** BASE YOU SPECIFY DO NOT EXCIST *****');
                break;
        }
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}