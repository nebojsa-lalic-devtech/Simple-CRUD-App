<?php

namespace app\NL\validation;

use app\NL\database\Database;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\Query;

class ValidationMongodb
{
    private $db;

    /**
     * ValidationMongodb constructor.
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function validateId($id)
    {
        $objectId = new ObjectID((string)$id);
        $filter = ['_id' => $objectId];
        $query = new Query($filter, []);
        $keys = $this->db->getDatabase()->createConnection()->executeQuery(CURRENT_MONGO_TABLE, $query);
        $result = array();
        foreach ($keys as $key) {
            $result[] = $key;
        }
        if ($result == true) {
            return $result;
        } else {
            throw new \UnexpectedValueException("***** ID: '$id', DOES NOT EXISTS IN DATABASE *****");
        }
    }
}