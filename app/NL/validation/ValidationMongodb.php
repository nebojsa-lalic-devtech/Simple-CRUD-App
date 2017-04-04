<?php

namespace app\NL\validation;

use app\NL\database\Database;

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
}