<?php

namespace app\NL\database;

class Database
{
    /**
     * @return \MongoDB\Driver\Manager|\PDO
     * @throws \Exception
     */
    public function connectToDatabase()
    {
        switch ('mysql') {
            case 'mysql':
                $adapter = new MysqlAdapter();
                $connection = $adapter->createConnection();
                return $connection;
                break;
            case 'mongodb':
                $adapter = new MongoAdapter();
                $connection = $adapter->createConnection();
                return $connection;
                break;
            default:
                throw new \Exception('***** BASE YOU SPECIFY DO NOT EXCIST *****');
                break;
        }
    }
}