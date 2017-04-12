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
    public function __construct($containerInterface)
    {
        $this->db = $containerInterface->get('Database');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function validateId($id)
    {
        $statement = $this->db->getDatabase()->createConnection()->prepare("SELECT * FROM employee WHERE id = :id LIMIT 1");
        $statement->execute(array(
            'id' => $id
        ));
        $employeeFromDb = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($employeeFromDb == true) {
            return $employeeFromDb;
        } else {
            throw new \UnexpectedValueException("***** ID: '$id', DOES NOT EXISTS IN DATABASE *****");
        }
    }
}