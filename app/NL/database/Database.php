<?php

namespace app\NL\database;

class Database
{
    private $mysqlAdapter;
    private $mongodbAdapter;

    /**
     * Database constructor.
     * @param MysqlAdapter $mysqlAdapter
     * @param MongoAdapter $mongodbAdapter
     */
    public function __construct(MysqlAdapter $mysqlAdapter, MongoAdapter $mongodbAdapter)
    {
        $this->mysqlAdapter = $mysqlAdapter;
        $this->mongodbAdapter = $mongodbAdapter;
    }

    /**
     * @return MongoAdapter|MysqlAdapter
     * @throws \Exception
     */
    public function getDatabase()
    {
        switch (CURRENT_DB) {
            case 'mysql':
                $connection = $this->mysqlAdapter;
                return $connection;
                break;
            case 'mongodb':
                $connection = $this->mongodbAdapter;
                return $connection;
                break;
            default:
                throw new \Exception('***** BASE YOU SPECIFY DO NOT EXIST *****');
                break;
        }
    }
}