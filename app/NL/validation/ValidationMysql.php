<?php

namespace app\NL\validation;

use Psr\Container\ContainerInterface;

class ValidationMysql
{
    private $db;

    /**
     * ValidationMysql constructor.
     * @param ContainerInterface $containerInterface
     */
    public function __construct(ContainerInterface $containerInterface)
    {
        $this->db = $containerInterface->get('Database');
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