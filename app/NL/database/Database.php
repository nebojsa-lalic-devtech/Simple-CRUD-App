<?php

namespace app\NL\database;

class Database
{
    /**
     * @return MongoAdapter|MysqlAdapter
     * @throws \Exception
     */
    public function connectToDatabase()
    {
        switch (CURRENT_DB) {
            case 'mysql':
                $connection = new MysqlAdapter();
                return $connection;
                break;
            case 'mongodb':
                $connection = new MongoAdapter();
                return $connection;
                break;
            default:
                throw new \Exception('***** BASE YOU SPECIFY DO NOT EXCIST *****');
                break;
        }
    }
}