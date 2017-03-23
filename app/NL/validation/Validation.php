<?php

namespace app\NL\validation;

use app\NL\database\Database;

class Validation extends Database
{
    private $db;

    /**
     * Validation constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database();
    }


    public function validateId($id)
    {
        $statement = $this->db->getDatabaseConnection()->prepare("SELECT id FROM `simple-crud-app`.`employee`");
        $statement->execute();
        $idsArray = array();
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $idsArray[] = $row;
        }
        if (in_array($id, $idsArray)) {
            return true;
        } else {
            throw new \UnexpectedValueException("***** ID: '$id'', DOES NOT EXCIST IN DATABASE *****");
        }
    }

}