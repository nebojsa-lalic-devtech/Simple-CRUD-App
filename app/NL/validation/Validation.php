<?php

namespace app\NL\validation;

use app\NL\database\Database;

class Validation
{
    private $connection;

    /**
     * Validation constructor.
     */
    public function __construct()
    {
        $db = new Database();
        $this->connection = $db->getDatabase()->createConnection();
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function validateId($id)
    {
        $statement = $this->connection->prepare("SELECT id FROM employee WHERE id = $id");
        $statement->execute();
        $exists = $statement->fetch();
        if ($exists == true) {
            return true;
        } else {
            throw new \UnexpectedValueException("***** ID: '$id', DOES NOT EXISTS IN DATABASE *****");
        }
    }
}