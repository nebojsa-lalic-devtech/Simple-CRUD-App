<?php

namespace app\NL\validation;

use app\NL\database\Database;

class Validation
{
    private $db;

    /**
     * Validation constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function validateId($id)
    {
        $statement = $this->db->getDatabase()->createConnection()->prepare("SELECT id FROM employee WHERE id = $id");
        $statement->execute();
        $exists = $statement->fetch();

        if ($exists == true) {
            return true;
        } else {
            throw new \UnexpectedValueException("***** ID: '$id', DOES NOT EXISTS IN DATABASE *****");
        }
    }
}