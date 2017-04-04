<?php

namespace app\NL\validation;

use app\NL\database\Database;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\Query;

class ValidationMongodb
{
    private $connection;

    /**
     * ValidationMongodb constructor.
     */
    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getDatabase()->createConnection();
    }

    /**
     * @param $id
     * @return bool
     */
    public function validateId($id)
    {
        $objectId = new ObjectID((string)$id);
        $filter = ['_id' => $objectId];
        $query = new Query($filter, []);
        $keys = $this->connection->executeQuery(CURRENT_MONGO_TABLE, $query);
        $result = array();
        foreach ($keys as $key) {
            $result[] = $key;
        }
        if ($result == true) {
            return true;
        } else {
            throw new \UnexpectedValueException("***** ID: '$id', DOES NOT EXISTS IN DATABASE *****");
        }
    }
}