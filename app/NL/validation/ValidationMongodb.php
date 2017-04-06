<?php

namespace app\NL\validation;

use app\NL\database\Database;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\Query;
use Monolog\Logger;

class ValidationMongodb
{
    private $db;
    private $logger;

    /**
     * ValidationMongodb constructor.
     * @param Database $db
     * @param Logger $log
     */
    public function __construct(Database $db, Logger $log)
    {
        $this->db = $db;
        $this->logger = $log;
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
            $this->logger->error("***** ID:{$id}, DOES NOT EXISTS IN DATABASE *****");
            throw new \UnexpectedValueException("***** ID: '$id', DOES NOT EXISTS IN DATABASE *****");
        }
    }
}